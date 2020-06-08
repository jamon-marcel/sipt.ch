<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StudentStoreEventCourseRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'course_events.*.id' => 'required|exists:App\Models\CourseEvent,id',
      'id' => 'required|exists:App\Models\Student,id',
    ];
  }

  /**
   * Custom message for validation
   *
   * @return array
   */
  public function messages()
  {
    return [
      'course_events.*.id.required' => [
        'field' => 'course_id',
        'error' => 'Modul wird benötigt!'
      ],
      'course_events.*.id.exists' => [
        'field' => 'course_id',
        'error' => 'Modul ungültig!'
      ],
      'id.required' => [
        'field' => 'student_id',
        'error' => 'Student benötigt!'
      ],
      'id.exists' => [
        'field' => 'student_id',
        'error' => 'Student ungültig!'
      ],
    ];
  }
}
