<?php

namespace App\Http\Resources;

use App\Models\ResumeWorkExample;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResumeWorkExampleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var ResumeWorkExample $resumeWorkExample */
        $resumeWorkExample = $this->resource;

        return [
            'id' => $resumeWorkExample->id,
            'url' => $resumeWorkExample->url,
            'title' => $resumeWorkExample->title,
        ];
    }
}
