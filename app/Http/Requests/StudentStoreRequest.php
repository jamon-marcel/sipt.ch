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
      'zip' => 'required',
      'city' => 'required',
      'country' => 'required',
      'phone' => 'required',
      'qualifications' => 'required',
      'has_alt_address' => 'required',
      'alt_company' => 'required_if:has_alt_address,1',
      'alt_street' => 'required_if:has_alt_address,1',
      'alt_zip' => 'required_if:has_alt_address,1',
      'alt_city' => 'required_if:has_alt_address,1',
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
        'error' => 'Name muss ausgefüllt sein.'
      ],
      'firstname.required' => [
        'field' => 'firstname',
        'error' => 'Vorname muss ausgefüllt sein.'
      ],
      'street.required' => [
        'field' => 'street',
        'error' => 'Strasse muss ausgefüllt sein.'
      ],
      'zip.required' => [
        'field' => 'zip',
        'error' => 'Postleitzahl muss ausgefüllt sein.'
      ],
      'city.required' => [
        'field' => 'city',
        'error' => 'Ort muss ausgefüllt sein.'
      ],
      'country.required' => [
        'field' => 'country',
        'error' => 'Land muss ausgefüllt sein.'
      ],
      'phone.required' => [
        'field' => 'phone',
        'error' => 'Telefon muss ausgefüllt sein.'
      ],
      'qualifications.required' => [
        'field' => 'qualifications',
        'error' => 'Berufsabschluss muss ausgefüllt sein.'
      ],
      'alt_company.required_if' => [
        'field' => 'alt_company',
        'error' => 'Firma muss ausgefüllt sein.'
      ],
      'alt_street.required_if' => [
        'field' => 'alt_street',
        'error' => 'Strasse muss ausgefüllt sein.'
      ],
      'alt_zip.required_if' => [
        'field' => 'alt_zip',
        'error' => 'Postleitzahl muss ausgefüllt sein.'
      ],
      'alt_city.required_if' => [
        'field' => 'alt_city',
        'error' => 'Ort muss ausgefüllt sein.'
      ],
    ];
  }
}
