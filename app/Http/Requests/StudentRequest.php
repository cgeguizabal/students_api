<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
            'firstName' => 'required|string|max:30',
            'lastName' => 'required|string|max:30',
            'age' => 'required|integer|max:90',
            'grade' => 'required|integer|max:12',
            'email' => 'email|nullable|unique:students,email',
            'phone_number' => 'required|string|unique:students,phone_number',
            'password' => 'required|string|min:8',
        ];
    }
}