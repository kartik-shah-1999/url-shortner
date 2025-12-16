<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'pass1' => ['required','string','min:8'],
            'pass2' => ['required','same:pass1']
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Name is required.',
            'name.string'   => 'Name must be a valid string.',
            'name.max'      => 'Name cannot exceed 30 characters.',

            'email.required' => 'Email address is required.',
            'email.email'    => 'Please enter a valid email address.',
            'email.max'      => 'Email cannot exceed 100 characters.',
            'email.unique'   => 'This email is already registered.',

            'pass1.required' => 'Password is required.',
            'pass1.string'   => 'Password must be a valid string.',
            'pass1.min'      => 'Password must be at least 8 characters long.',

            'pass2.required' => 'Please confirm your password.',
            'pass2.same'     => 'Passwords do not match.',
        ];
    }
}
