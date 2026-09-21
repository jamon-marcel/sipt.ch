<?php
namespace App\Console\Commands;

use App\Models\Course;
use App\Models\CourseEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MergeCourses extends Command
{
  protected $signature = 'course:merge
    {--source= : Number or ID of the course to be merged (will be deleted)}
    {--target= : Number or ID of the course to keep}
    {--dry-run : Preview the merge without making any changes}';

  protected $description = 'Merge two courses by moving all events, bookings and relations from one to another';

  /**
   * Tables that simply follow their course event, including their deleted rows.
   */
  protected array $eventTables = [
    'invoices' => 'invoices',
    'messages' => 'messages',
    'documents' => 'course_event_files',
  ];

  /**
   * Values that are compared between two events merged into each other.
   */
  protected array $comparedAttributes = [
    'max_participants',
    'location_id',
    'is_online',
    'is_bookable',
    'is_published',
    'is_cancelled',
    'is_closed',
  ];

  public function handle(): int
  {
    $source = $this->resolveCourse(
      $this->option('source') ?: $this->ask('Enter the number of the course to be MERGED (will be deleted)'),
      'source'
    );

    if (!$source) {
      return self::FAILURE;
    }

    $target = $this->resolveCourse(
      $this->option('target') ?: $this->ask('Enter the number of the course to KEEP (its number stays active)'),
      'target'
    );

    if (!$target) {
      return self::FAILURE;
    }

    if ($source->id === $target->id) {
      $this->error('Source and target course must be different.');
      return self::FAILURE;
    }

    $isDryRun = $this->option('dry-run');

    if ($isDryRun) {
      $this->warn("\n[DRY RUN MODE - No changes will be made]\n");
    }

    // Events are moved including soft-deleted ones, so that course:restore keeps working
    $events = CourseEvent::withTrashed()
      ->where('course_id', $source->id)
      ->orderBy('dateStart')
      ->get();

    $this->info("\n=== Merge Preview ===");
    $this->line("\nSOURCE (will be deleted):");
    $this->describeCourse($source);
    $this->line("\nTARGET (will be kept):");
    $this->describeCourse($target);

    // Events to be moved
    $this->info("\n=== Course events to be moved to #{$target->number} ===");

    if ($events->isEmpty()) {
      $this->warn('  No events found.');
    } else {
      $this->table(
        ['Event ID', 'Date Start', 'Max', 'Bookings', 'Invoices', 'Cancelled', 'Closed', 'Deleted At'],
        $events->map(function ($event) {
          return [
            $event->id,
            $event->getRawOriginal('dateStart'),
            $event->max_participants,
            DB::table('course_event_student')->where('course_event_id', $event->id)->count(),
            DB::table('invoices')->where('course_event_id', $event->id)->count(),
            $event->is_cancelled ? 'yes' : '',
            $event->is_closed ? 'yes' : '',
            $event->deleted_at,
          ];
        })->toArray()
      );
    }

    // A course must not end up with two active events on the same date, so events
    // sharing a start date are merged into a single one
    $groups = $this->collectMergeGroups($source, $target);
    $mergeGroups = $groups->where('fromSource', true)->values();
    $existingGroups = $groups->where('fromSource', false)->values();

    if ($mergeGroups->isNotEmpty()) {
      $this->info("\n=== Events on the same date (will be merged) ===");
      $this->previewMergeGroups($mergeGroups, $source);
    }

    if ($existingGroups->isNotEmpty()) {
      $this->info("\n=== Events of #{$target->number} that already share a date ===");
      $this->line('  They are not part of the merge, but can be merged in the same go.');
      $this->previewMergeGroups($existingGroups, $source);
    }

    // Relations
    $trainings = DB::table('course_training')
      ->where('course_id', $source->id)
      ->whereNull('deleted_at')
      ->pluck('training_id');

    $specialisations = DB::table('course_specialisation')
      ->where('course_id', $source->id)
      ->pluck('specialisation_id');

    $targetTrainings = DB::table('course_training')
      ->where('course_id', $target->id)
      ->whereNull('deleted_at')
      ->pluck('training_id');

    $targetSpecialisations = DB::table('course_specialisation')
      ->where('course_id', $target->id)
      ->pluck('specialisation_id');

    $newTrainings = $trainings->diff($targetTrainings);
    $newSpecialisations = $specialisations->diff($targetSpecialisations);

    $this->info("\n=== Relations ===");
    $this->line('  Trainings added to target: ' . $newTrainings->count() . ' (of ' . $trainings->count() . ' on source)');
    $this->line('  Specialisations added to target: ' . $newSpecialisations->count() . ' (of ' . $specialisations->count() . ' on source)');

    // Text fields: the target keeps its own unless the source version is preferred
    $adoptFields = [];

    if (!$isDryRun) {
      if ($existingGroups->isNotEmpty()) {
        $question = 'Merge the ' . $existingGroups->count()
          . " date(s) of #{$target->number} listed above as well?";

        if ($this->confirm("\n" . $question, false)) {
          $mergeGroups = $mergeGroups->concat($existingGroups);
        }
      }

      $this->info("\n=== Title and description ===");
      $this->line("  Target #{$target->number}: {$target->title}");
      $this->line("  Source #{$source->number}: {$source->title}");

      $choice = $this->choice(
        'Which title and description should the merged course keep?',
        ["Target (#{$target->number})", "Source (#{$source->number})"],
        0
      );

      if (Str::startsWith($choice, 'Source')) {
        $adoptFields = [
          'title' => $source->title,
          'description' => $source->description,
        ];
      }
    }

    if ($isDryRun) {
      $this->info("\n[DRY RUN COMPLETE - No changes were made]");
      return self::SUCCESS;
    }

    if (!$this->confirm("\nProceed with merge? Course #{$source->number} will be deleted.")) {
      $this->info('Merge cancelled.');
      return self::SUCCESS;
    }

    try {
      DB::beginTransaction();

      // Move events first: the CourseObserver cascades the soft delete of a course
      // to its events and their dates, so they must no longer belong to the source.
      CourseEvent::withTrashed()
        ->where('course_id', $source->id)
        ->update(['course_id' => $target->id]);

      // Merge the events that share a start date into the event that is kept
      $mergedEvents = 0;
      $mergeTotals = array_fill_keys(array_keys($this->emptyResult()), 0);

      foreach ($mergeGroups as $group) {
        foreach ($group['merge'] as $event) {
          $counts = $this->mergeEvent($event, $group['keep'], true);

          foreach ($counts as $key => $count) {
            $mergeTotals[$key] += $count;
          }

          // The CourseEventObserver soft-deletes the dates that stayed behind
          $event->delete();
          $mergedEvents++;
        }
      }

      // Move relations, skipping the ones the target already has
      foreach ($newTrainings as $trainingId) {
        DB::table('course_training')->insert([
          'id' => (string) Str::uuid(),
          'training_id' => $trainingId,
          'course_id' => $target->id,
          'created_at' => now(),
          'updated_at' => now(),
        ]);
      }

      foreach ($newSpecialisations as $specialisationId) {
        DB::table('course_specialisation')->insert([
          'id' => (string) Str::uuid(),
          'course_id' => $target->id,
          'specialisation_id' => $specialisationId,
          'created_at' => now(),
          'updated_at' => now(),
        ]);
      }

      DB::table('course_training')->where('course_id', $source->id)->delete();
      DB::table('course_specialisation')->where('course_id', $source->id)->delete();

      if ($adoptFields) {
        $target->update($adoptFields);
      }

      $source->delete();

      DB::commit();

      $this->info("\n✓ Merge completed!");
      $this->info("  - Moved {$events->count()} course event(s) to #{$target->number}");

      if ($mergedEvents) {
        $this->info("  - Merged {$mergedEvents} event(s) into the event of the same date");
        $this->info('    Moved along: ' . $mergeTotals['bookings'] . ' booking(s), '
          . $mergeTotals['invoices'] . ' invoice(s), '
          . $mergeTotals['dates'] . ' date(s), '
          . $mergeTotals['messages'] . ' message(s), '
          . $mergeTotals['documents'] . ' document(s)');

        if ($mergeTotals['duplicates']) {
          $this->warn('    Removed ' . $mergeTotals['duplicates'] . ' duplicate booking(s) of students booked on both events');
        }

        if ($mergeTotals['billedDuplicates']) {
          $this->warn('    ' . $mergeTotals['billedDuplicates'] . ' of them were already billed - check their invoices');
        }
      }

      $this->info('  - Added ' . $newTrainings->count() . ' training relation(s)');
      $this->info('  - Added ' . $newSpecialisations->count() . ' specialisation relation(s)');

      if ($adoptFields) {
        $this->info("  - Title and description taken over from #{$source->number}");
      }

      $this->info("  - Deleted course #{$source->number} ({$source->id})");
      $this->line("\n  Active course: #{$target->number} {$target->title}");

      return self::SUCCESS;
    } catch (\Exception $e) {
      DB::rollBack();
      $this->error('Merge failed: ' . $e->getMessage());
      return self::FAILURE;
    }
  }

  /**
   * Group the active events of both courses by start date. Groups that hold more
   * than one event end up with two events on the same date and are merged into a
   * single one. Groups without an event of the source course already exist on the
   * target and are only merged on demand, the merge must not silently clean up
   * dates it does not touch. Trashed events are history and may share a date.
   */
  protected function collectMergeGroups(Course $source, Course $target): Collection
  {
    $events = CourseEvent::whereIn('course_id', [$target->id, $source->id])
      ->orderBy('created_at')
      ->get();

    // The event with the most active bookings survives, because it carries the
    // capacity, location and flags that were actually used. Events of the course
    // that is kept win a tie, followed by the older one.
    $bookings = DB::table('course_event_student')
      ->whereIn('course_event_id', $events->pluck('id'))
      ->whereNull('deleted_at')
      ->where('is_cancelled', 0)
      ->groupBy('course_event_id')
      ->pluck(DB::raw('count(*)'), 'course_event_id');

    $ranking = fn ($event) => [
      $bookings->get($event->id, 0),
      $event->course_id === $target->id,
    ];

    return $events
      ->groupBy(fn ($event) => $event->getRawOriginal('dateStart'))
      ->filter(fn ($group) => $group->count() > 1)
      ->sortKeys()
      ->map(function ($group, $date) use ($ranking, $source) {
        $fromSource = $group->contains(fn ($event) => $event->course_id === $source->id);
        $group = $group->sort(fn ($a, $b) => $ranking($b) <=> $ranking($a))->values();

        return [
          'date' => $date,
          'fromSource' => $fromSource,
          'keep' => $group->first(),
          'merge' => $group->slice(1)->values(),
        ];
      })
      ->values();
  }

  /**
   * Show per date which event survives and what is moved into it.
   */
  protected function previewMergeGroups(Collection $mergeGroups, Course $source): void
  {
    foreach ($mergeGroups as $group) {
      $keep = $group['keep'];

      $this->line("\n  {$group['date']}");
      $this->line('    Kept:   ' . $keep->id . ' (' . $this->eventOrigin($keep, $source) . ')');

      $bookings = DB::table('course_event_student')
        ->where('course_event_id', $keep->id)
        ->whereNull('deleted_at')
        ->where('is_cancelled', 0)
        ->count();

      foreach ($group['merge'] as $event) {
        $counts = $this->mergeEvent($event, $keep, false);
        $bookings += $counts['activeBookings'];

        $this->line('    Merged: ' . $event->id . ' (' . $this->eventOrigin($event, $source) . ')');
        $this->line('      Moved: ' . $counts['bookings'] . ' booking(s), '
          . $counts['invoices'] . ' invoice(s), '
          . $counts['dates'] . ' date(s), '
          . $counts['messages'] . ' message(s), '
          . $counts['documents'] . ' document(s)');

        if ($counts['duplicates']) {
          $this->warn('      ' . $counts['duplicates'] . ' student(s) booked on both events - the duplicate booking is removed');
        }

        if ($counts['billedDuplicates']) {
          $this->warn('      ' . $counts['billedDuplicates'] . ' removed booking(s) were already billed - check their invoices');
        }

        $differences = $this->attributeDifferences($keep, $event);

        if ($differences) {
          $this->warn('      Values kept from the surviving event: ' . implode(', ', $differences));
        }
      }

      if ($keep->max_participants && $bookings > $keep->max_participants) {
        $this->warn("      Attention: {$bookings} bookings exceed the maximum of {$keep->max_participants} participants");
      }
    }
  }

  /**
   * Move everything that belongs to $from over to $into. Nothing is written with
   * $apply = false, the result then only tells what the merge would move.
   */
  protected function mergeEvent(CourseEvent $from, CourseEvent $into, bool $apply): array
  {
    $result = $this->emptyResult();

    $existing = DB::table('course_event_student')->where('course_event_id', $into->id)->get();
    $existingActive = $existing->whereNull('deleted_at')->keyBy('student_id');
    $existingRows = $existing->map(fn ($booking) => $booking->student_id . '|' . $booking->deleted_at);

    $bookings = DB::table('course_event_student')
      ->where('course_event_id', $from->id)
      ->orderBy('created_at')
      ->get();

    foreach ($bookings as $booking) {
      // Deleted bookings are history and just follow their event
      if ($booking->deleted_at) {
        if (!$existingRows->contains($booking->student_id . '|' . $booking->deleted_at)) {
          $this->moveBooking($booking->id, $into->id, $apply);
          $result['deletedBookings']++;
        }

        continue;
      }

      $duplicate = $existingActive->get($booking->student_id);

      if (!$duplicate) {
        $this->moveBooking($booking->id, $into->id, $apply);
        $result['bookings']++;
        $result['activeBookings'] += $booking->is_cancelled ? 0 : 1;
        continue;
      }

      // The student is booked on both events, which ces_unique_constraint forbids.
      // A cancelled booking gives way to an active one, otherwise the booking of
      // the surviving event is kept.
      $result['duplicates']++;

      if ($duplicate->is_cancelled && !$booking->is_cancelled) {
        $this->dropBooking($duplicate->id, $apply);
        $this->moveBooking($booking->id, $into->id, $apply);
        $result['bookings']++;
        $result['activeBookings']++;
        continue;
      }

      $result['billedDuplicates'] += $booking->is_billed ? 1 : 0;
      $this->dropBooking($booking->id, $apply);
    }

    // Dates: identical ones are dropped with the merged event, additional days are kept
    $existingDates = DB::table('course_event_dates')
      ->where('course_event_id', $into->id)
      ->whereNull('deleted_at')
      ->get()
      ->map(fn ($date) => $date->date . '|' . $date->timeStart . '|' . $date->timeEnd);

    $dates = DB::table('course_event_dates')
      ->where('course_event_id', $from->id)
      ->whereNull('deleted_at')
      ->get();

    foreach ($dates as $date) {
      if ($existingDates->contains($date->date . '|' . $date->timeStart . '|' . $date->timeEnd)) {
        continue;
      }

      if ($apply) {
        DB::table('course_event_dates')->where('id', $date->id)->update([
          'course_event_id' => $into->id,
          'updated_at' => now(),
        ]);
      }

      $result['dates']++;
    }

    foreach ($this->eventTables as $key => $table) {
      $query = DB::table($table)->where('course_event_id', $from->id);

      $result[$key] = $apply
        ? $query->update(['course_event_id' => $into->id, 'updated_at' => now()])
        : $query->count();
    }

    return $result;
  }

  protected function emptyResult(): array
  {
    return [
      'bookings' => 0,
      'activeBookings' => 0,
      'deletedBookings' => 0,
      'duplicates' => 0,
      'billedDuplicates' => 0,
      'dates' => 0,
      'invoices' => 0,
      'messages' => 0,
      'documents' => 0,
    ];
  }

  protected function moveBooking(string $id, string $eventId, bool $apply): void
  {
    if ($apply) {
      DB::table('course_event_student')->where('id', $id)->update([
        'course_event_id' => $eventId,
        'updated_at' => now(),
      ]);
    }
  }

  protected function dropBooking(string $id, bool $apply): void
  {
    if ($apply) {
      DB::table('course_event_student')->where('id', $id)->update([
        'deleted_at' => now(),
        'updated_at' => now(),
      ]);
    }
  }

  /**
   * Values that differ between two merged events - the surviving event keeps its
   * own, so they are reported for a manual check.
   */
  protected function attributeDifferences(CourseEvent $keep, CourseEvent $merged): array
  {
    $differences = [];

    foreach ($this->comparedAttributes as $attribute) {
      if ($keep->$attribute != $merged->$attribute) {
        $differences[] = $attribute . ': ' . $keep->$attribute . ' (instead of ' . $merged->$attribute . ')';
      }
    }

    return $differences;
  }

  protected function eventOrigin(CourseEvent $event, Course $source): string
  {
    return $event->course_id === $source->id ? 'source' : 'target';
  }

  /**
   * Resolve a course by its number or ID, asking which one if a number is ambiguous.
   */
  protected function resolveCourse(?string $input, string $role): ?Course
  {
    if (empty($input)) {
      $this->error("No {$role} course given.");
      return null;
    }

    $course = Course::find($input);

    if ($course) {
      return $course;
    }

    $courses = Course::where('number', $input)->orderBy('title')->get();

    if ($courses->isEmpty()) {
      $this->error("No course found with number or ID: {$input}");
      return null;
    }

    if ($courses->count() === 1) {
      return $courses->first();
    }

    $this->warn("\nSeveral courses share the number {$input}:");
    $this->table(
      ['#', 'ID', 'Title', 'Published'],
      $courses->map(fn ($course, $index) => [
        $index + 1,
        $course->id,
        $course->title,
        $course->is_published ? 'yes' : '',
      ])->toArray()
    );

    $selection = (int) $this->ask("Which one is the {$role} course? (1-" . $courses->count() . ')');

    if ($selection < 1 || $selection > $courses->count()) {
      $this->error("Invalid selection: {$selection}");
      return null;
    }

    return $courses[$selection - 1];
  }

  protected function describeCourse(Course $course): void
  {
    $this->line("  Number: #{$course->number}");
    $this->line("  Title: {$course->title}");
    $this->line("  ID: {$course->id}");
    $this->line("  Credits: {$course->credits} | Cost: {$course->cost} | Published: " . ($course->is_published ? 'yes' : 'no'));
  }
}
