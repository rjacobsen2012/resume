<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateResumeExperienceRequest;
use App\Http\Requests\UpdateResumeExperienceRequest;
use App\Http\Resources\ResumeUserResource;
use App\Models\ResumeExperience;
use App\Models\ResumeUser;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;

class ResumeExperienceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param CreateResumeExperienceRequest $request
     * @param ResumeUser $resumeUser
     * @return JsonResponse
     */
    public function store(CreateResumeExperienceRequest $request, ResumeUser $resumeUser)
    {
        $resumeUser->resumeExperiences()->create([
            'company_name' => filter_var($request->get('company_name'), FILTER_SANITIZE_STRING),
            'title' => filter_var($request->get('title'), FILTER_SANITIZE_STRING),
            'city' => filter_var($request->get('city'), FILTER_SANITIZE_STRING),
            'state' => filter_var($request->get('state'), FILTER_SANITIZE_STRING),
            'started_at' => Carbon::parse($request->get('started_at')),
            'ended_at' => !$request->get('present') ?
                ($request->get('ended_at') ? Carbon::parse($request->get('ended_at')) : null) : null,
            'present' => $request->get('present'),
            'description' => filter_var($request->get('description'), FILTER_SANITIZE_STRING)
        ]);
        $resumeUser->refresh();

        return response()->json([
            'success' => true,
            'resumeUser' => new ResumeUserResource($resumeUser)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateResumeExperienceRequest $request
     * @param ResumeUser $resumeUser
     * @param ResumeExperience $resumeExperience
     * @return JsonResponse
     */
    public function update(UpdateResumeExperienceRequest $request, ResumeUser $resumeUser, ResumeExperience $resumeExperience)
    {
        $resumeExperience->update([
            'company_name' => filter_var($request->get('company_name'), FILTER_SANITIZE_STRING),
            'title' => filter_var($request->get('title'), FILTER_SANITIZE_STRING),
            'city' => filter_var($request->get('city'), FILTER_SANITIZE_STRING),
            'state' => filter_var($request->get('state'), FILTER_SANITIZE_STRING),
            'started_at' => Carbon::parse($request->get('started_at')),
            'ended_at' => !$request->get('present') ?
                ($request->get('ended_at') ? Carbon::parse($request->get('ended_at')) : null) : null,
            'present' => $request->get('present'),
            'description' => filter_var($request->get('description'), FILTER_SANITIZE_STRING),
            'hidden' => $request->get('hidden'),
        ]);

        $resumeUser->refresh();

        return response()->json([
            'success' => true,
            'resumeUser' => new ResumeUserResource($resumeUser)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ResumeUser $resumeUser
     * @param ResumeExperience $resumeExperience
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(ResumeUser $resumeUser, ResumeExperience $resumeExperience)
    {
        $resumeExperience->delete();
        $resumeUser->refresh();

        return response()->json([
            'success' => true,
            'resumeUser' => new ResumeUserResource($resumeUser)
        ], 200);
    }
}
