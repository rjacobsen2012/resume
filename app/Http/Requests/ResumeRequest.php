<?php

namespace App\Http\Requests;

use App\Models\Resume;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ResumeRequest extends FormRequest
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
                Rule::unique(Resume::class)
                    ->ignore($this->route('resume')),
            ],
            'profile' => [
                'string',
            ],
            'title' => [
                'string',
            ],
            'city' => [
                'string',
            ],
            'state' => [
                'string',
            ],
            'country' => [
                'string',
            ],
            'linked_in_profile' => [
                'string',
            ],
            'github_profile' => [
                'string',
            ],
            'phone' => [
                'string',
            ],
            'new_skill.name' => [
                'string',
                'unique:resume_skills,name',
            ],
            'is_hidden' => [
                'boolean',
                'nullable',
            ],
        ];
    }
}
