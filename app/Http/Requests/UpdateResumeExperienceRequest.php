<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateResumeExperienceRequest extends FormRequest
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
            'company_name' => 'required|string',
            'title' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'started_at' => 'required|date',
            'ended_at' => 'nullable|date',
            'present' => 'nullable|integer',
            'description' => 'required|string',
        ];
    }
}
