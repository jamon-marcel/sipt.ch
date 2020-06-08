<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class StudentStoreRequest extends FormRequest
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
      'name' => 'required',
      'firstname' => 'required',
      'email' => 'required|email|unique:users',
      'street' => 'required',
      'street_no' => 'required',
      'zip' => 'required',
      'city' => 'required',
      'phone' => 'required',
      'qualifications' => 'required',
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
      'name.required' => 'Name wird benötigt!',
      'firstname.required' => 'Vorname wird benötigt!',
      'email.required' => 'E-Mail wird benötigt!',
      'email.email' => 'E-Mail ungültig!',
      'email.unique' => 'Es existiert bereits ein Benutzer mit dieser E-Mail!',
      'street.required' => 'Strasse wird benötigt!',
      'street_no.required' => 'Nummer wird benötigt!',
      'zip.required' => 'Postleitzahl wird benötigt!',
      'city.required' => 'Ort wird benötigt!',
      'phone.required' => 'Telefon wird benötigt!',
      'qualifications.required' => 'Berufsabschluss wird benötigt!',
    ];
  }
}
