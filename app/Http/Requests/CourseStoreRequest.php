<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CourseStoreRequest extends FormRequest
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
      'title'       => 'required',
      'description' => 'required',
      'credits'     => 'required|integer',
      'durability'  => 'required|integer',
      'cost'        => 'required'
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
        'error' => 'Beschreibung wird benötigt!'
      ],
      'credits.required' => [
        'field' => 'credits',
        'error' => 'Credits wird benötigt!'
      ],
      'credits.integer' => [
        'field' => 'credits',
        'error' => 'Credits muss eine Zahl sein!'
      ],
      'durability.required' => [
        'field' => 'durability',
        'error' => 'Kursdauer wird benötigt!'
      ],
      'durability.integer' => [
        'field' => 'durability',
        'error' => 'Kursdauer muss eine Zahl sein!'
      ],
      'cost.required' => [
        'field' => 'cost',
        'error' => 'Kosten wird benötigt!'
      ],
    ];
  }
}
