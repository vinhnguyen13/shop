<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest	 extends FormRequest
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
	public function rules($step = 'step1')
	{
		$arr = [
			'step1' => [
				'email' => 'required',
			],
			'step2' => [
				'shipping_name' => 'required',
				'shipping_address' => 'required',
				'shipping_phone' => 'required',
				'billing_name' => 'required',
				'billing_address' => 'required',
				'billing_phone' => 'required',
			],
			'step3' => [
				'payment_method' => 'required',
			]
		];
		return $arr[$step];
	}

	public function messages()
	{
		return [
			'name.required' => 'A name is required',
			'building_id.required' => 'Choose a location'
		];
	}
}
