<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class NewsletterSubscriberStoreRequest extends FormRequest
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
      'email' => 'required|string|email',
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
      'email.required' => 'E-Mail muss ausgefüllt sein.',
      'email.email' => 'E-Mail ist ungültig.',
      'email.string' => 'E-Mail ist ungültig.',
    ];
  }
}
