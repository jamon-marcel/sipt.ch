<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class NewsArticleStoreRequest extends FormRequest
{
  public function authorize()
  {
    return true;
  }

  public function rules()
  {
    return [
      'text' => 'required',
      'category_id' => 'required',
    ];
  }

  public function messages()
  {
    return [
      'text.required' => [
        'field' => 'text',
        'error' => 'Text wird benötigt!'
      ],
      'category_id.required' => [
        'field' => 'category_id',
        'error' => 'Kategorie wird benötigt!'
      ],
    ];
  }
}
