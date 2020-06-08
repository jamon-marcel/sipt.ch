<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CourseEventStoreRequest extends FormRequest
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
      'course_id'        => 'required|exists:App\Models\Course,id',
      'location_id'      => 'required_if:is_online,0',
      'is_online'        => 'required|boolean',
      'dates'            => 'required',
      'max_participants' => 'required|integer|min:1'
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
      'course_id.required_if' => [
        'field' => 'course_id',
        'error' => 'Modul wird benötigt!'
      ],
      'course_id.exists' => [
        'field' => 'course_id',
        'error' => 'Modul ungültig!'
      ],
      'location_id.required' => [
        'field' => 'location_id',
        'error' => 'Kursort wird benötigt!'
      ],
      'location_id.exists' => [
        'field' => 'location_id',
        'error' => 'Kursort ungültig!'
      ],
      'dates.required' => [
        'field' => 'dates',
        'error' => 'Daten werden benötigt!'
      ],
      'max_participants.required' => [
        'field' => 'max_participants',
        'error' => 'max. Teilnehmer wird benötigt!'
      ],
      'max_participants.integer' => [
        'field' => 'max_participants',
        'error' => 'max. Teilnehmer muss eine Zahl sein!'
      ],
      'max_participants.min' => [
        'field' => 'max_participants',
        'error' => 'Mind. 1 Teilnehmer ist erforderlich!'
      ],
      'is_online' => [
        'field' => 'is_online',
        'error' => 'Online Kurs wird benötigt!'
      ]
    ];

  }
}
