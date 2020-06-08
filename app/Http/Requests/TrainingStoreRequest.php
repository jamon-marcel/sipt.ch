<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class TrainingStoreRequest extends FormRequest
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
      'title' => 'required',
      'description' => 'required',
      'description_short' => 'required',
      'location_id' => 'required|exists:App\Models\Location,id',
      'category_id' => 'required|exists:App\Models\TrainingCategory,id',
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
      'title.required' => [
        'field' => 'title',
        'error' => 'Titel wird benötigt!'
      ],
      'description.required' => [
        'field' => 'description',
        'error' => 'Beschreibung wird benötigt'
      ],
      'description_short.required' => [
        'field' => 'description_short',
        'error' => 'Kurzbeschreibung wird benötigt'
      ],
      'location_id.required' => [
        'field' => 'location_id',
        'error' => 'Kursort wird benötigt!'
      ],
      'location_id.exists' => [
        'field' => 'location_id',
        'error' => 'Kursort ungültig!'
      ],
      'category_id.required' => [
        'field' => 'category_id',
        'error' => 'Kategorie wird benötigt!'
      ],
      'category_id.exists' => [
        'field' => 'category_id',
        'error' => 'Kategorie ungültig!'
      ],
    ];
  }
}
