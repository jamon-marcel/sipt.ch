<?php
namespace App\Console\Commands;

use App\Models\Course;
use App\Models\CourseEvent;
use App\Models\CourseEventDate;
use App\Models\CourseEventStudent;
use App\Models\Student;
use Illuminate\Console\Command;

class CourseRestore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'course:restore';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore a soft-deleted course and its related events and student registrations';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $number = $this->ask('Enter the course number to restore (e.g., 41)');

        if (empty($number)) {
            $this->error('Course number is required.');
            return self::FAILURE;
        }

        // Find all soft-deleted courses by number
        $courses = Course::withTrashed()
            ->where('number', $number)
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();

        if ($courses->isEmpty()) {
            $existingCourse = Course::where('number', $number)->first();
            if ($existingCourse) {
                $this->error("Course #{$number} exists and is not deleted.");
            } else {
                $this->error("No deleted course found with number: {$number}");
            }
            return self::FAILURE;
        }

        // Display all found courses
        $this->info('');
        $this->info("Found {$courses->count()} deleted course(s) with number #{$number}:");

        $tableData = $courses->map(function ($course, $index) {
            $events = CourseEvent::withTrashed()
                ->where('course_id', $course->id)
                ->where('is_cancelled', 0)
                ->whereNotNull('deleted_at')
                ->count();

            return [
                $index + 1,
                $course->id,
                $course->title,
                $events,
                $course->deleted_at,
            ];
        })->toArray();

        $this->table(['#', 'ID', 'Title', 'Events', 'Deleted At'], $tableData);

        // Ask which course(s) to restore
        $this->info('');
        $selection = $this->ask('Enter the number(s) to restore (e.g., 1 or 1,2,3 or "all")');

        if (empty($selection)) {
            $this->info('Operation cancelled.');
            return self::SUCCESS;
        }

        // Determine which courses to restore
        $selectedCourses = collect();
        if (strtolower($selection) === 'all') {
            $selectedCourses = $courses;
        } else {
            $indices = array_map('trim', explode(',', $selection));
            foreach ($indices as $idx) {
                $idx = (int) $idx;
                if ($idx >= 1 && $idx <= $courses->count()) {
                    $selectedCourses->push($courses[$idx - 1]);
                } else {
                    $this->error("Invalid selection: {$idx}");
                    return self::FAILURE;
                }
            }
        }

        // Show detailed summary of what will be restored
        $this->info('');
        $this->line(str_repeat('=', 80));
        $this->info('RECORDS TO BE RESTORED');
        $this->line(str_repeat('=', 80));

        $totalEvents = 0;
        $totalDates = 0;
        $totalStudents = 0;

        foreach ($selectedCourses as $course) {
            $this->info('');
            $this->info("COURSE: {$course->title} (#{$course->number})");
            $this->line(str_repeat('-', 60));

            // Get non-cancelled events for this course
            $events = CourseEvent::withTrashed()
                ->where('course_id', $course->id)
                ->where('is_cancelled', 0)
                ->whereNotNull('deleted_at')
                ->orderBy('dateStart')
                ->get();

            if ($events->isEmpty()) {
                $this->warn('  No deleted events found for this course.');
            } else {
                $this->info('');
                $this->info('  Course Events:');

                $eventTableData = $events->map(function ($event) {
                    return [
                        $event->id,
                        $event->getRawOriginal('dateStart'),
                        $event->max_participants,
                        $event->deleted_at,
                    ];
                })->toArray();

                $this->table(
                    ['Event ID', 'Date Start', 'Max Participants', 'Deleted At'],
                    $eventTableData
                );
            }

            // Get event dates for these events
            $eventIds = $events->pluck('id')->toArray();
            $eventDates = CourseEventDate::withTrashed()
                ->whereIn('course_event_id', $eventIds)
                ->whereNotNull('deleted_at')
                ->orderBy('date')
                ->get();

            if ($eventDates->isEmpty()) {
                $this->warn('  No deleted event dates found.');
            } else {
                $this->info('');
                $this->info('  Event Dates:');

                $dateTableData = $eventDates->map(function ($date) use ($events) {
                    $event = $events->firstWhere('id', $date->course_event_id);

                    return [
                        $date->getRawOriginal('date'),
                        $date->getRawOriginal('timeStart') . ' - ' . $date->getRawOriginal('timeEnd'),
                        $event ? $event->getRawOriginal('dateStart') : 'N/A',
                        $date->deleted_at,
                    ];
                })->toArray();

                $this->table(
                    ['Date', 'Time', 'Event Start', 'Deleted At'],
                    $dateTableData
                );
            }

            // Get non-cancelled student registrations for these events
            $studentRegistrations = CourseEventStudent::withTrashed()
                ->whereIn('course_event_id', $eventIds)
                ->where('is_cancelled', 0)
                ->whereNotNull('deleted_at')
                ->get();

            if ($studentRegistrations->isEmpty()) {
                $this->warn('  No deleted student registrations found.');
            } else {
                $this->info('');
                $this->info('  Student Registrations:');

                $studentTableData = $studentRegistrations->map(function ($registration) use ($events) {
                    $student = Student::withTrashed()->find($registration->student_id);
                    $event = $events->firstWhere('id', $registration->course_event_id);

                    return [
                        $student ? $student->fullName : 'Unknown',
                        $registration->booking_number,
                        $event ? $event->getRawOriginal('dateStart') : 'N/A',
                        $registration->deleted_at,
                    ];
                })->toArray();

                $this->table(
                    ['Student', 'Booking #', 'Event Date', 'Deleted At'],
                    $studentTableData
                );
            }

            $totalEvents += $events->count();
            $totalDates += $eventDates->count();
            $totalStudents += $studentRegistrations->count();
        }

        $this->info('');
        $this->line(str_repeat('=', 80));
        $this->info("TOTAL: {$selectedCourses->count()} course(s), {$totalEvents} event(s), {$totalDates} date(s), {$totalStudents} registration(s)");
        $this->line(str_repeat('=', 80));

        $this->info('');
        if (!$this->confirm('Do you want to proceed with the restoration?')) {
            $this->info('Operation cancelled.');
            return self::SUCCESS;
        }

        // Perform restoration
        $this->info('');
        $this->info('Restoring records...');

        $restoredCourses = 0;
        $restoredEvents = 0;
        $restoredDates = 0;
        $restoredStudents = 0;

        foreach ($selectedCourses as $course) {
            // Get related non-cancelled soft-deleted events
            $events = CourseEvent::withTrashed()
                ->where('course_id', $course->id)
                ->where('is_cancelled', 0)
                ->whereNotNull('deleted_at')
                ->get();

            // Get related soft-deleted event dates
            $eventIds = $events->pluck('id')->toArray();
            $eventDates = CourseEventDate::withTrashed()
                ->whereIn('course_event_id', $eventIds)
                ->whereNotNull('deleted_at')
                ->get();

            // Get related non-cancelled soft-deleted student registrations
            $studentRegistrations = CourseEventStudent::withTrashed()
                ->whereIn('course_event_id', $eventIds)
                ->where('is_cancelled', 0)
                ->whereNotNull('deleted_at')
                ->get();

            // Restore course
            $course->restore();
            $restoredCourses++;

            // Restore events
            foreach ($events as $event) {
                $event->restore();
                $restoredEvents++;
            }

            // Restore event dates
            foreach ($eventDates as $date) {
                $date->restore();
                $restoredDates++;
            }

            // Restore student registrations
            foreach ($studentRegistrations as $registration) {
                $registration->restore();
                $restoredStudents++;
            }

            $this->info("  [OK] Course '{$course->title}' restored with {$events->count()} events, {$eventDates->count()} dates, {$studentRegistrations->count()} registrations");
        }

        $this->info('');
        $this->info("Restoration completed: {$restoredCourses} course(s), {$restoredEvents} event(s), {$restoredDates} date(s), {$restoredStudents} registration(s)");

        return self::SUCCESS;
    }
}
