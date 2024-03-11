<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExperienceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'company_name' => 'string|nullable',
            'title' => 'string|nullable',
            'city' => 'string|nullable',
            'state' => 'string|nullable',
            'started_at' => 'date',
            'ended_at' => 'date|after:started_at',
            'present' => 'boolean|nullable',
            'description' => 'string|nullable',
            'hidden' => 'boolean|nullable',
        ];
    }
}
