<?php
namespace App\Console\Commands;

use App\Models\User;
use App\Models\CourseEventStudent;
use Illuminate\Console\Command;

class UserCourseEvents extends Command
{
  protected $signature = 'user:course-events {--all : Include bookings without attendance}';
  protected $description = 'List all course events a user has attended';

  public function handle(): int
  {
    $input = trim((string) $this->ask('Enter the user id (or email)'));

    if ($input === '') {
      $this->error('No user id given.');
      return self::FAILURE;
    }

    $user = User::find($input) ?: User::where('email', $input)->first();

    if (!$user) {
      $this->error("User not found: {$input}");
      return self::FAILURE;
    }

    if (!$user->student) {
      $this->error("User has no student record: {$user->email} ({$user->id})");
      return self::FAILURE;
    }

    $student = $user->student;

    $this->info("\n{$student->firstname} {$student->name} <{$user->email}>");
    $this->line("User id: {$user->id}");
    $this->line("Student id: {$student->id} (#{$student->number})");

    $query = CourseEventStudent::where('student_id', $student->id)
      ->where('course_event_student.is_cancelled', 0)
      ->with('courseEvent.course');

    if (!$this->option('all')) {
      $query->where('has_attendance', 1);
    }

    $entries = $query->get()
      ->filter(fn (CourseEventStudent $entry): bool => (bool) $entry->courseEvent)
      ->sortBy(fn (CourseEventStudent $entry): string => $entry->courseEvent->getAttributes()['dateStart']);

    if ($entries->isEmpty()) {
      $this->warn("\nNo course events found.");
      return self::SUCCESS;
    }

    $rows = $entries->map(function (CourseEventStudent $entry): array {
      $event = $entry->courseEvent;
      $course = $event->course;

      return [
        $event->dateStart,
        $course ? $course->number : '',
        $course ? $course->title : '',
        $course ? $course->credits : '',
        $entry->booking_number,
        $entry->has_attendance ? 'ja' : 'nein',
        $entry->is_billed ? 'ja' : 'nein',
      ];
    })->values()->all();

    $this->info("\nFound ".count($rows).' course events');
    $this->table(['Datum', 'Kurs-Nr.', 'Kurs', 'Credits', 'Buchungs-Nr.', 'Besucht', 'Verrechnet'], $rows);

    return self::SUCCESS;
  }
}
