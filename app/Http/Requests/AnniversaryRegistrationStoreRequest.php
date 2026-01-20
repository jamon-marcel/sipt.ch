<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class AnniversaryRegistrationStoreRequest extends FormRequest
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
      'salutation' => 'required',
      'firstname' => 'required',
      'name' => 'required',
      'email' => 'required|string|email|unique:anniversary_registrations',
      'street' => 'required',
      'street_no' => 'required',
      'zip' => 'required',
      'city' => 'required',
      'ticket_type' => 'required|in:both_days,friday_only,saturday_only',
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
      'salutation.required' => 'Anrede muss ausgefüllt sein.',
      'firstname.required' => 'Vorname muss ausgefüllt sein.',
      'name.required' => 'Name muss ausgefüllt sein.',
      'street.required' => 'Strasse muss ausgefüllt sein.',
      'street_no.required' => 'Hausnummer muss ausgefüllt sein.',
      'zip.required' => 'PLZ muss ausgefüllt sein.',
      'city.required' => 'Ort muss ausgefüllt sein.',
      'email.required' => 'E-Mail muss ausgefüllt sein.',
      'email.email' => 'E-Mail ist ungültig.',
      'email.unique' => 'Diese E-Mail-Adresse ist bereits registriert.',
      'email.string' => 'E-Mail ist ungültig.',
      'ticket_type.required' => 'Bitte wählen Sie ein Ticket.',
      'ticket_type.in' => 'Ungültige Ticket-Auswahl.',
      'toc.required' => 'AGBs müssen akzeptiert werden.',
    ];
  }
}
