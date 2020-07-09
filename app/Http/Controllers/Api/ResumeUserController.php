<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateResumeUserRequest;
use App\Http\Requests\UpdateResumeUserRequest;
use App\Http\Resources\ResumeUserResource;
use App\Models\ResumeUser;
use Illuminate\Http\JsonResponse;

class ResumeUserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param CreateResumeUserRequest $request
     * @return JsonResponse
     */
    public function store(CreateResumeUserRequest $request)
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $profile = $request->get('profile');
        $phone = $request->get('phone');
        $githubProfile = $request->get('github_profile');
        $linkedinProfile = $request->get('linked_in_profile');

        $resumeUser = auth()->user()->resumeUser;

        if ($resumeUser) {
            $resumeUser->update([
                'name' => $name,
                'email' => $email,
                'profile' => $profile,
                'phone' => $phone,
                'github_profile' => $githubProfile,
                'linked_in_profile' => $linkedinProfile,
            ]);
        } else {
            $resumeUser = auth()->user()->resumeUser()->create([
                'name' => $name,
                'email' => $email,
                'profile' => $profile,
                'phone' => $phone,
                'github_profile' => $githubProfile,
                'linked_in_profile' => $linkedinProfile,
            ]);
        }

        return response()->json([
            'success' => true,
            'resumeUser' => new ResumeUserResource($resumeUser)
        ], 200);
    }

    /**
     * Update an existing resource.
     *
     * @param UpdateResumeUserRequest $request
     * @param ResumeUser $resumeUser
     * @return JsonResponse
     */
    public function update(UpdateResumeUserRequest $request, ResumeUser $resumeUser)
    {
        $name = $request->get('name');
        $email = $request->get('email');
        $profile = $request->get('profile');

        $resumeUser->update([
            'name' => $name,
            'email' => $email,
            'profile' => $profile,
        ]);

        return response()->json([
            'success' => true,
            'resumeUser' => new ResumeUserResource($resumeUser->load(['resumeSkills']))
        ], 200);
    }
}
