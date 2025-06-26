<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupportRequestRequest extends FormRequest
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

            'email'   => ['required', 'string', 'email'],
            'subject' => ['required', 'string', 'max:255',
                Rule::unique('support_requests')->where('email', $this->input('email'))],
            'message' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'subject.unique' => 'You have already sent a request with this subject and email.',
        ];
    }
}
