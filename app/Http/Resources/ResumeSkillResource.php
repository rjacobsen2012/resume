<?php

namespace App\Http\Resources;

use App\Models\ResumeSkill;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResumeSkillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var ResumeSkill $resumeSkill */
        $resumeSkill = $this->resource;

        return [
            'id' => $resumeSkill->id,
            'name' => $resumeSkill->name,
            'years' => $resumeSkill->pivot->years,
            'months' => $resumeSkill->pivot->months,
        ];
    }
}
