<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255|unique:tasks,name,' . $this->route('task'),
            'description' => 'required|string|min:10|max:1000',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Task name is required.',
            'name.string' => 'Task name must be a string.',
            'name.min' => 'Task name must be at least 3 characters.',
            'name.max' => 'Task name must not exceed 255 characters.',
            'name.unique' => 'A task with this name already exists.',
            'description.required' => 'Task description is required.',
            'description.string' => 'Task description must be a string.',
            'description.min' => 'Task description must be at least 10 characters.',
            'description.max' => 'Task description must not exceed 1000 characters.',
        ];
    }
}
