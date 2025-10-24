<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PartnerInstitutionStoreRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'name' => 'required|string|max:255',
			'description' => 'nullable|string',
		];
	}

	public function messages()
	{
		return [
			'name.required' => [
				'field' => 'name',
				'error' => 'Name wird benötigt!'
			],
		];
	}
}
