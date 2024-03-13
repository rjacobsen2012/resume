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
            'company_name' => ['string'],
            'title' => ['string'],
            'city' => ['string'],
            'state' => ['string'],
            'started_at' => ['date', 'nullable'],
            'ended_at' => ['date', 'after:started_at', 'nullable'],
            'present' => ['boolean', 'nullable'],
            'description' => ['string'],
            'is_hidden' => ['boolean', 'nullable'],
        ];
    }
}
