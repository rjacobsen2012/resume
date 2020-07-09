<?php

namespace App\Http\Resources;

use App\Models\ResumeUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResumeUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var ResumeUser $resumeUser */
        $resumeUser = $this->resource;

        return [
            'id' => $resumeUser->id,
            'name' => $resumeUser->name,
            'email' => $resumeUser->email,
            'profile' => $resumeUser->profile,
            'phone' => $resumeUser->phone,
            'skills' => ResumeSkillResource::collection($resumeUser->resumeSkills),
            'experiences' => ResumeExperienceResource::collection($resumeUser->resumeExperiences),
            'workExamples' => ResumeWorkExampleResource::collection($resumeUser->resumeWorkExamples),
            'gravatar' => 'https://secure.gravatar.com/avatar/' . md5($resumeUser->email) . '?size=56',
            'github_profile' => $resumeUser->github_profile,
            'linked_in_profile' => $resumeUser->linked_in_profile,
        ];
    }
}
