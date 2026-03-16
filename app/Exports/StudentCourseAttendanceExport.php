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

    // Get all students who have attended a course event in the last 3 years
    $studentIds = CourseEventStudent::where('course_event_student.is_cancelled', 0)
      ->whereHas('courseEvent', function ($query) use ($threeYearsAgo) {
        $query->where('dateStart', '>=', $threeYearsAgo);
      })
      ->pluck('student_id')
      ->unique();

    $students = Student::whereIn('id', $studentIds)
      ->with('user')
      ->orderBy('name')
      ->get();

    $data = [];
    foreach ($students as $s)
    {
      // Get the most recent course event date for this student
      $lastAttendance = CourseEventStudent::where('student_id', $s->id)
        ->where('course_event_student.is_cancelled', 0)
        ->whereHas('courseEvent', function ($query) use ($threeYearsAgo) {
          $query->where('dateStart', '>=', $threeYearsAgo);
        })
        ->join('course_events', 'course_events.id', '=', 'course_event_student.course_event_id')
        ->orderBy('course_events.dateStart', 'DESC')
        ->value('course_events.dateStart');

      $email = $s->user ? $s->user->email : '';

      $data[] = [
        'Vorname' => $s->firstname,
        'Name' => $s->name,
        'Strasse' => trim($s->street . ' ' . $s->street_no),
        'PLZ' => $s->zip,
        'Ort' => $s->city,
        'E-Mail' => $email,
        'Letzter Kursbesuch' => $lastAttendance ? \Carbon\Carbon::parse($lastAttendance)->format('d.m.Y') : '',
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
