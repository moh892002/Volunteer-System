<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VolunteerRequest extends FormRequest
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
            'name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:volunteers,email,' . $this->route('volunteer'),
            'phone' => 'required|string|regex:/^[\+]?[0-9\s\-\(\)]+$/|min:10|max:20',
            'skills' => 'required|string|min:5|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Volunteer name is required.',
            'name.string' => 'Volunteer name must be a string.',
            'name.min' => 'Volunteer name must be at least 2 characters.',
            'name.max' => 'Volunteer name must not exceed 255 characters.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'phone.required' => 'Phone number is required.',
            'phone.string' => 'Phone number must be a string.',
            'phone.regex' => 'Please provide a valid phone number.',
            'phone.min' => 'Phone number must be at least 10 characters.',
            'phone.max' => 'Phone number must not exceed 20 characters.',
            'skills.required' => 'Skills information is required.',
            'skills.string' => 'Skills must be a string.',
            'skills.min' => 'Skills description must be at least 5 characters.',
            'skills.max' => 'Skills description must not exceed 500 characters.',
        ];
    }
}
