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
      'has_alt_address' => 'required',

      'alt_company' => 'required_if:has_alt_address,1',
      'alt_name' => 'required_if:has_alt_address,1',
      'alt_street' => 'required_if:has_alt_address,1',
      'alt_street_no' => 'required_if:has_alt_address,1',
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
      'alt_company.required_if' => [
        'field' => 'alt_company',
        'error' => 'Firma wird benötigt!'
      ],
      'alt_name.required_if' => [
        'field' => 'alt_name',
        'error' => 'Vorname wird benötigt!'
      ],
      'alt_street.required_if' => [
        'field' => 'alt_street',
        'error' => 'Strasse wird benötigt!'
      ],
      'alt_street_no.required_if' => [
        'field' => 'alt_street_no',
        'error' => 'Nummer wird benötigt!'
      ],
      'alt_zip.required_if' => [
        'field' => 'alt_zip',
        'error' => 'Postleitzahl wird benötigt!'
      ],
      'alt_city.required_if' => [
        'field' => 'alt_city',
        'error' => 'Ort wird benötigt!'
      ],
    ];
  }
}
