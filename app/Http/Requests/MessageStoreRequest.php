<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class MessageStoreRequest extends FormRequest
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
      'course_event_id'  => 'required|exists:App\Models\CourseEvent,id',
      'subject'          => 'required',
      'message'          => 'required',
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
      'course_event_id.required' => [
        'field' => 'course_event_id',
        'error' => 'Veranstaltung wird benötigt!'
      ],
      'course_event_id.exists' => [
        'field' => 'course_event_id',
        'error' => 'Veranstaltung ungültig!'
      ],
      'subject.required' => [
        'field' => 'subject',
        'error' => 'Betreff wird benötigt!'
      ],
      'message.required' => [
        'field' => 'message',
        'error' => 'Nachricht werden benötigt!'
      ],
    ];
  }
}
