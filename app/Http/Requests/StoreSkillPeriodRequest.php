<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSkillPeriodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'started_on' => ['required', 'date'],
            // blank means still in use, and an end before the start is not a range
            'ended_on' => ['nullable', 'date', 'after_or_equal:started_on'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'ended_on.after_or_equal' => 'The end date cannot be before the start date.',
            'started_on.required' => 'A start date is needed.',
        ];
    }
}
