<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class MailingStoreRequest extends FormRequest
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
      'greetings' => 'required',
      'subject' => 'required',
      'body' => 'required',
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
      'salutation.required' => [
        'field' => 'salutation',
        'error' => 'Anrede wird benötigt!'
      ],
      'greetings.required' => [
        'field' => 'greetings',
        'error' => 'Grusszeile wird benötigt!'
      ],
      'subject.required' => [
        'field' => 'subject',
        'error' => 'Betreff wird benötigt!'
      ],
      'body.required' => [
        'field' => 'body',
        'error' => 'Inhalt wird benötigt!'
      ],
    ];
  }
}
