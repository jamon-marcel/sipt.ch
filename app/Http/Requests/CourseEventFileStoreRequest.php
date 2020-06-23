<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CourseEventFileStoreRequest extends FormRequest
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
      'files.*.course_event_id' => 'required|exists:App\Models\CourseEvent,id',
      'files.*.name' => 'required',
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
      'files.*.course_event_id.required' => [
        'field' => 'course_id',
        'error' => 'Modul wird benötigt!'
      ],
      'files.*.course_event_id.exists' => [
        'field' => 'course_id',
        'error' => 'Modul ungültig!'
      ],
      'files.*.name.required' => [
        'field' => 'name',
        'error' => 'Datei wird benötigt!'
      ],
    ];
  }
}
