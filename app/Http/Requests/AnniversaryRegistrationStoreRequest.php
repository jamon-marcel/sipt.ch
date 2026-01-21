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
    $rules = [
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

    $ticketType = $this->input('ticket_type');

    if ($ticketType === 'both_days') {
      $rules['apero_friday'] = 'required|in:0,1';
      $rules['lunch_saturday'] = 'required|in:0,1';
    } elseif ($ticketType === 'friday_only') {
      $rules['apero_friday'] = 'required|in:0,1';
    } elseif ($ticketType === 'saturday_only') {
      $rules['lunch_saturday'] = 'required|in:0,1';
    }

    return $rules;
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
      'ticket_type.required' => 'Ticket muss ausgewählt werden.',
      'ticket_type.in' => 'Ungültige Ticket-Auswahl.',
      'apero_friday.required' => 'Apéro-Teilnahme muss ausgewählt werden.',
      'lunch_saturday.required' => 'Mittagessen-Teilnahme muss ausgewählt werden.',
      'toc.required' => 'AGBs müssen akzeptiert werden.',
    ];
  }
}
