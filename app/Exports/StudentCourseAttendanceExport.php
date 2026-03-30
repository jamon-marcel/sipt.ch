<?php
namespace App\Exports;
use App\Models\Student;
use App\Models\CourseEventStudent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentCourseAttendanceExport implements FromCollection, WithHeadings
{
  /**
  * @return \Illuminate\Support\Collection
  */
  public function collection()
  {
    $threeYearsAgo = date('Y.m.d', strtotime('-3 years'));

    $attendanceScope = function ($query) use ($threeYearsAgo) {
      $query->where('is_cancelled', 0)
        ->where('dateStart', '>=', $threeYearsAgo);
    };

    // Get all students who have actually attended a course event in the last 3 years
    $studentIds = CourseEventStudent::where('course_event_student.is_cancelled', 0)
      ->where('has_attendance', 1)
      ->whereHas('courseEvent', $attendanceScope)
      ->pluck('student_id')
      ->unique();

    $students = Student::whereIn('id', $studentIds)
      ->with('user')
      ->orderBy('name')
      ->get();

    $data = [];
    foreach ($students as $s)
    {
      // Get the most recent attended course event for this student
      $lastEvent = CourseEventStudent::where('student_id', $s->id)
        ->where('course_event_student.is_cancelled', 0)
        ->where('has_attendance', 1)
        ->whereHas('courseEvent', $attendanceScope)
        ->with('courseEvent')
        ->get()
        ->sortByDesc(function ($entry) {
          return $entry->courseEvent->getAttributes()['dateStart'];
        })
        ->first();

      $lastDate = '';
      if ($lastEvent && $lastEvent->courseEvent) {
        $lastDate = $lastEvent->courseEvent->dateStart;
      }

      $email = $s->user ? $s->user->email : '';

      $data[] = [
        'Vorname' => $s->firstname,
        'Name' => $s->name,
        'Strasse' => trim($s->street . ' ' . $s->street_no),
        'PLZ' => $s->zip,
        'Ort' => $s->city,
        'E-Mail' => $email,
        'Letzter Kursbesuch' => $lastDate,
      ];
    }

    return collect($data);
  }

  public function headings(): array
  {
    return [
      'Vorname',
      'Name',
      'Strasse',
      'PLZ',
      'Ort',
      'E-Mail',
      'Letzter Kursbesuch',
    ];
  }
}
