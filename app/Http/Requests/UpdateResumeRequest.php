<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateResumeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'string',
            ],
            'email' => [
                'string',
                'email',
            ],
            'profile' => [
                'string',
                'nullable',
            ],
            'title' => [
                'string',
                'nullable',
            ],
            'city' => [
                'string',
                'nullable',
            ],
            'state' => [
                'string',
                'nullable',
            ],
            'country' => [
                'string',
                'nullable',
            ],
            'linked_in_profile' => [
                'string',
                'nullable',
            ],
            'github_profile' => [
                'string',
                'nullable',
            ],
            'phone' => [
                'string',
                'nullable',
            ],
            'new_skill.name' => [
                'string',
                'unique:resume_skills,name',
                'nullable',
            ],
            'is_hidden' => [
                'boolean',
                'nullable',
            ],
        ];
    }
}
