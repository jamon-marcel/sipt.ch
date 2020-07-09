<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class SymposiumSubscriberStoreRequest extends FormRequest
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
      'country' => 'required',
      'email' => 'required|string|email',
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
      'name.required' => 'Name muss ausgefüllt sein.',
      'firstname.required' => 'Vorname muss ausgefüllt sein.',
      'street.required' => 'Strasse muss ausgefüllt sein.',
      'street_no.required' => 'Nr. muss ausgefüllt sein.',
      'zip.required' => 'PLZ muss ausgefüllt sein.',
      'city.required' => 'Ort muss ausgefüllt sein.',
      'country.required' => 'Land muss ausgefüllt sein.',
      'email.required' => 'E-Mail muss ausgefüllt sein.',
      'email.email' => 'E-Mail ist ungültig.',
      'email.string' => 'E-Mail ist ungültig.',
      'qualifications.required' => 'Berufsabschluss muss ausgefüllt sein.',
      'toc.required' => 'AGBs müssen akzeptiert werden.',
    ];
  }
}
