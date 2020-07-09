<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateResumeEducationRequest;
use App\Http\Requests\UpdateResumeEducationRequest;
use App\Http\Resources\ResumeUserResource;
use App\Models\ResumeEducation;
use App\Models\ResumeUser;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;

class ResumeEducationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param CreateResumeEducationRequest $request
     * @param ResumeUser $resumeUser
     * @return JsonResponse
     */
    public function store(CreateResumeEducationRequest $request, ResumeUser $resumeUser)
    {
        $resumeUser->resumeEducations()->create([
            'school' => filter_var($request->get('school'), FILTER_SANITIZE_STRING),
            'city' => filter_var($request->get('city'), FILTER_SANITIZE_STRING),
            'state' => filter_var($request->get('state'), FILTER_SANITIZE_STRING),
            'degree' => filter_var($request->get('degree'), FILTER_SANITIZE_STRING),
            'started_at' => Carbon::parse($request->get('started_at')),
            'ended_at' => Carbon::parse($request->get('ended_at')),
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
     * @param UpdateResumeEducationRequest $request
     * @param ResumeUser $resumeUser
     * @param ResumeEducation $resumeEducation
     * @return JsonResponse
     */
    public function update(UpdateResumeEducationRequest $request, ResumeUser $resumeUser, ResumeEducation $resumeEducation)
    {
        $resumeEducation->update([
            'school' => filter_var($request->get('school'), FILTER_SANITIZE_STRING),
            'city' => filter_var($request->get('city'), FILTER_SANITIZE_STRING),
            'state' => filter_var($request->get('state'), FILTER_SANITIZE_STRING),
            'degree' => filter_var($request->get('degree'), FILTER_SANITIZE_STRING),
            'started_at' => Carbon::parse($request->get('started_at')),
            'ended_at' => Carbon::parse($request->get('ended_at')),
            'description' => filter_var($request->get('description'), FILTER_SANITIZE_STRING)
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
     * @param ResumeEducation $resumeEducation
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(ResumeUser $resumeUser, ResumeEducation $resumeEducation)
    {
        $resumeEducation->delete();
        $resumeUser->refresh();

        return response()->json([
            'success' => true,
            'resumeUser' => new ResumeUserResource($resumeUser)
        ], 200);
    }
}
