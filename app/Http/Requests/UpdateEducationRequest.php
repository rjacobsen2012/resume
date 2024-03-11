<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEducationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'school' => 'string|nullable',
            'city' => 'string|nullable',
            'state' => 'string|nullable',
            'degree' => 'string',
            'started_at' => 'date',
            'ended_at' => 'after:started_at',
            'description' => 'string|nullable',
        ];
    }
}
