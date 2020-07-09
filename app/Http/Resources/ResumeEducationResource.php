<?php

namespace App\Http\Resources;

use App\Models\ResumeEducation;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResumeEducationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var ResumeEducation $resumeEducation */
        $resumeEducation = $this->resource;

        return [
            'id' => $resumeEducation->id,
            'school' => $resumeEducation->school,
            'city' => $resumeEducation->city,
            'state' => $resumeEducation->state,
            'degree' => $resumeEducation->degree ?: '',
            'started_at' => $resumeEducation->started_at,
            'ended_at' => $resumeEducation->ended_at,
            'description' => $resumeEducation->description,
        ];
    }
}
