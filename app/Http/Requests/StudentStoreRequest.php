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
      'name.required' => [
        'field' => 'name',
        'error' => 'Name wird benötigt!'
      ],
      'firstname.required' => [
        'field' => 'firstname',
        'error' => 'Vorname wird benötigt!'
      ],
      'street.required' => [
        'field' => 'street',
        'error' => 'Strasse wird benötigt!'
      ],
      'street_no.required' => [
        'field' => 'street_no',
        'error' => 'Nummer wird benötigt!'
      ],
      'zip.required' => [
        'field' => 'zip',
        'error' => 'Postleitzahl wird benötigt!'
      ],
      'city.required' => [
        'field' => 'city',
        'error' => 'Ort wird benötigt!'
      ],
      'phone.required' => [
        'field' => 'phone',
        'error' => 'Telefon wird benötigt!'
      ],
      'qualifications.required' => [
        'field' => 'qualifications',
        'error' => 'Berufsabschluss wird benötigt!'
      ],
    ];
  }
}
