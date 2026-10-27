<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSkillRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        // How long a skill has been used is derived from its date ranges now, so
        // only the name is editable here.
        return [
            'name' => ['sometimes', 'string'],
        ];
    }
}
