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
            'company_name' => ['string'],
            'title' => ['string'],
            'city' => ['string'],
            'state' => ['string'],
            'started_at' => ['nullable', 'date'],
            'ended_at' => ['nullable', 'date', 'after:started_at'],
            'present' => ['boolean', 'nullable'],
            'description' => ['string'],
            'is_hidden' => ['boolean', 'nullable'],
        ];
    }
}
