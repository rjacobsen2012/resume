<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreExperienceRequest extends FormRequest
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
            'started_at' => 'required|date',
            'ended_at' => 'required|date|after:started_at',
            'present' => 'boolean|nullable',
            'description' => 'string|nullable',
            'hidden' => 'boolean|nullable',
        ];
    }
}
