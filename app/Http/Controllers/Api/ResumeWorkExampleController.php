<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateResumeWorkExampleRequest;
use App\Http\Requests\UpdateResumeWorkExampleRequest;
use App\Http\Resources\ResumeUserResource;
use App\Models\ResumeWorkExample;
use App\Models\ResumeUser;
use Exception;
use Illuminate\Http\JsonResponse;

class ResumeWorkExampleController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param CreateResumeWorkExampleRequest $request
     * @param ResumeUser $resumeUser
     * @return JsonResponse
     */
    public function store(CreateResumeWorkExampleRequest $request, ResumeUser $resumeUser)
    {
        $resumeUser->resumeWorkExamples()->create([
            'url' => filter_var($request->get('url'), FILTER_SANITIZE_STRING),
            'title' => filter_var($request->get('title'), FILTER_SANITIZE_STRING)
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
     * @param UpdateResumeWorkExampleRequest $request
     * @param ResumeUser $resumeUser
     * @param ResumeWorkExample $resumeWorkExample
     * @return JsonResponse
     */
    public function update(UpdateResumeWorkExampleRequest $request, ResumeUser $resumeUser, ResumeWorkExample $resumeWorkExample)
    {
        $resumeWorkExample->update([
            'url' => filter_var($request->get('url'), FILTER_SANITIZE_STRING),
            'title' => filter_var($request->get('title'), FILTER_SANITIZE_STRING)
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
     * @param ResumeWorkExample $resumeWorkExample
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(ResumeUser $resumeUser, ResumeWorkExample $resumeWorkExample)
    {
        $resumeWorkExample->delete();
        $resumeUser->refresh();

        return response()->json([
            'success' => true,
            'resumeUser' => new ResumeUserResource($resumeUser)
        ], 200);
    }
}
