<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkplaceRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255|unique:workplaces,name,' . $this->route('workplace'),
            'address' => 'nullable|string|min:5|max:500',
            'description' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|regex:/^[\+]?[0-9\s\-\(\)]+$/|min:10|max:20',
            'email' => 'nullable|email|max:255|unique:workplaces,email,' . $this->route('workplace'),
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Workplace name is required.',
            'name.string' => 'Workplace name must be a string.',
            'name.min' => 'Workplace name must be at least 3 characters.',
            'name.max' => 'Workplace name must not exceed 255 characters.',
            'name.unique' => 'A workplace with this name already exists.',
            'address.string' => 'Address must be a string.',
            'address.min' => 'Address must be at least 5 characters.',
            'address.max' => 'Address must not exceed 500 characters.',
            'description.string' => 'Description must be a string.',
            'description.max' => 'Description must not exceed 1000 characters.',
            'phone.string' => 'Phone number must be a string.',
            'phone.regex' => 'Please provide a valid phone number.',
            'phone.min' => 'Phone number must be at least 10 characters.',
            'phone.max' => 'Phone number must not exceed 20 characters.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'Email address must not exceed 255 characters.',
            'email.unique' => 'This email address is already registered.',
        ];
    }
}
