<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class UserChangeEmailRequest extends FormRequest
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
      'email' => 'required|string|email|max:255|unique:users',
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
      'email.required' => [
        'field' => 'email',
        'error' => 'E-Mail wird benötigt!'
      ],
      'email.email' => [
        'field' => 'email',
        'error' => 'E-Mail ungültig!'
      ],
      'email.unique' => [
        'field' => 'email',
        'error' => 'E-Mail bereits vorhanden!'
      ],
    ];
  }
}
