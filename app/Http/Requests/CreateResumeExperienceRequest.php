<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateResumeExperienceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_name' => 'string',
            'title' => 'string',
            'city' => 'string',
            'state' => 'string',
            'started_at' => 'date',
            'ended_at' => 'nullable|date',
            'present' => 'nullable|integer',
            'description' => 'string',
        ];
    }
}
