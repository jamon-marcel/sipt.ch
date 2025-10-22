<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DownloadUpdateRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'title' => 'required|string|max:255',
			'file' => 'nullable|string', // File reference from upload (empty string = delete)
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
