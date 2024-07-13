<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsageApprovalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
				return [
					'remarks'   => 'nullable|regex:/(^[A-Za-z0-9 -_]+$)+/|max:250',
					'decision'  => 'required|numeric|max:1',
				];
    }
}
