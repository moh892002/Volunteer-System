<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization is handled by policies
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'volunteer_id' => 'required|exists:volunteers,id',
            'workplace_id' => 'required|exists:workplaces,id',
            'task_id' => 'required|exists:tasks,id',
            'status' => 'sometimes|in:pending,active,completed',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'volunteer_id.required' => 'Please select a volunteer.',
            'volunteer_id.exists' => 'The selected volunteer does not exist.',
            'workplace_id.required' => 'Please select a workplace.',
            'workplace_id.exists' => 'The selected workplace does not exist.',
            'task_id.required' => 'Please select a task.',
            'task_id.exists' => 'The selected task does not exist.',
            'status.in' => 'The status must be pending, active, or completed.',
        ];
    }
}
