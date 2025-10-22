<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DownloadStoreRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'title' => 'required|string|max:255',
			'file' => 'required|string', // File reference from upload
		];
	}

	public function messages()
	{
		return [
			'title.required' => [
				'field' => 'title',
				'error' => 'Titel wird benötigt!'
			],
			'file.required' => [
				'field' => 'file',
				'error' => 'Datei wird benötigt!'
			],
		];
	}
}
