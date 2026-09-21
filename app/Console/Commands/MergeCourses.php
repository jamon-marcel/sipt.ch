<?php
namespace App\Console\Commands;

use App\Models\Course;
use App\Models\CourseEvent;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MergeCourses extends Command
{
  protected $signature = 'course:merge
    {--source= : Number or ID of the course to be merged (will be deleted)}
    {--target= : Number or ID of the course to keep}
    {--dry-run : Preview the merge without making any changes}';

  protected $description = 'Merge two courses by moving all events, bookings and relations from one to another';

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

    // Warn about events on the same start date - possible duplicates that should be cleaned up by hand
    $targetDates = CourseEvent::withTrashed()
      ->where('course_id', $target->id)
      ->pluck('dateStart', 'id')
      ->map(fn ($date) => (string) $date);

    $collisions = $events->filter(
      fn ($event) => $targetDates->contains((string) $event->dateStart)
    );

    if ($collisions->isNotEmpty()) {
      $this->warn("\n  Attention: the target course already has events starting on the same date:");
      foreach ($collisions as $event) {
        $this->warn('    ' . $event->getRawOriginal('dateStart') . ' (event ' . $event->id . ')');
      }
      $this->warn('  Both events are kept - check afterwards whether one of them should be removed.');
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
