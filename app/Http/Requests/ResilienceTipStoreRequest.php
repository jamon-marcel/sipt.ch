<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResilienceTipStoreRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'title' => 'required|string|max:255',
			'subtitle' => 'nullable|string|max:255',
			'description' => 'nullable|string',
			'file' => 'nullable|string',
		];
	}

	public function messages()
	{
		return [
			'title.required' => [
				'field' => 'title',
				'error' => 'Titel wird benötigt!'
			],
		];
	}
}
