<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StudentRegisterRequest extends FormRequest
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
      'name' => 'required',
      'firstname' => 'required',
      'street' => 'required',
      'zip' => 'required',
      'city' => 'required',
      'country' => 'required',
      'phone' => 'required',
      'qualifications' => 'required',
      'toc' => 'required',
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
      'email.unique' => 'Es existiert bereits ein Benutzer mit dieser E-Mail-Adresse.',
      'toc.required' => 'AGBs müssen akzeptiert werden.',
    ];
  }
}
