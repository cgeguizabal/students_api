<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateStudentRequest extends FormRequest
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
            'firstName' => 'sometimes|string|max:30',
            'lastName' => 'sometimes|string|max:30',
            'age' => 'sometimes|integer|max:90',
            'grade' => 'sometimes|integer|max:12',
            'email' => 'sometimes|email|nullable|unique:students,email',
            'phone_number' => 'sometimes|string|unique:students,phone_number',
            'password' => 'sometimes|string|min:8',
        ];
    }
}