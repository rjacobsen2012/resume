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
            'school' => ['string'],
            'city' => ['string'],
            'state' => ['string'],
            'degree' => ['string', 'nullable'],
            'started_at' => ['date', 'nullable'],
            'ended_at' => ['after:started_at', 'nullable'],
            'description' => ['string'],
        ];
    }
}
