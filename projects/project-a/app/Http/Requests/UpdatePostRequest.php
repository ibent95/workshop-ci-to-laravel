<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Form Request for updating a Post resource.
 *
 * @category Requests
 * @package  App\Http\Requests
 * @author   Your Name <example@example.com>
 * @license  MIT License
 * @link     https://example.com
 */
class UpdatePostRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules(): array
	{
		return [
			'title' => ['required', 'string', 'max:255'],
			'body' => ['required', 'string'],
			'published_at' => ['nullable', 'date'],
		];
	}
}
