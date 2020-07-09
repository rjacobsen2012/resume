<?php

namespace App\Http\Resources;

use App\Models\ResumeExperience;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResumeExperienceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var ResumeExperience $resumeExperience */
        $resumeExperience = $this->resource;

        return [
            'id' => $resumeExperience->id,
            'company_name' => $resumeExperience->company_name,
            'title' => $resumeExperience->title,
            'city' => $resumeExperience->city,
            'state' => $resumeExperience->state,
            'started_at' => $resumeExperience->started_at,
            'ended_at' => $resumeExperience->ended_at,
            'present' => $resumeExperience->present,
            'description' => $resumeExperience->description,
        ];
    }
}
