<?php

namespace App\Http\Requests;

use App\Rules\SkillNotExistsOnResume;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreSkillRequest extends FormRequest
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
                'required',
                'string',
                new SkillNotExistsOnResume(),
            ],
            'years' => ['required', 'numeric'],
            'months' => ['required', 'numeric'],
        ];
    }
}
