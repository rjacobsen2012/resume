<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateResumeSkillRequest;
use App\Http\Requests\UpdateResumeSkillRequest;
use App\Http\Resources\ResumeUserResource;
use App\Models\ResumeSkill;
use App\Models\ResumeUser;
use Illuminate\Http\JsonResponse;

class ResumeSkillController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param CreateResumeSkillRequest $request
     * @param ResumeUser $resumeUser
     * @return JsonResponse
     */
    public function store(CreateResumeSkillRequest $request, ResumeUser $resumeUser)
    {
        $name = $request->get('name');
        $years = $request->get('years');
        $months = $request->get('months');

        /** @var ResumeSkill $skill */
        $skill = skill($name);
        $resumeUser->resumeSkills()->attach($skill->id, ['years' => $years, 'months' => $months]);
        $resumeUser->refresh();

        return response()->json([
            'success' => true,
            'resumeUser' => new ResumeUserResource($resumeUser)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateResumeSkillRequest $request
     * @param ResumeUser $resumeUser
     * @param ResumeSkill $resumeSkill
     * @return JsonResponse
     */
    public function update(UpdateResumeSkillRequest $request, ResumeUser $resumeUser, ResumeSkill $resumeSkill)
    {
        $name = $request->get('name');
        $years = $request->get('years');
        $months = $request->get('months');

        /** @var ResumeSkill $skill */
        $skill = skill($name);

        if ($resumeSkill->id !== $skill->id) {
            $resumeUser->resumeSkills()->detach($resumeSkill->id);
            $resumeUser->resumeSkills()->attach($skill->id, ['years' => $years, 'months' => $months]);
        } else {
            $resumeUser->resumeSkills()->updateExistingPivot($resumeSkill->id, [
                'years' => $years,
                'months' => $months
            ]);
        }

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
     * @param ResumeSkill $resumeSkill
     * @return JsonResponse
     */
    public function destroy(ResumeUser $resumeUser, ResumeSkill $resumeSkill)
    {
        $resumeUser->resumeSkills()->detach($resumeSkill->id);
        $resumeUser->refresh();

        return response()->json([
            'success' => true,
            'resumeUser' => new ResumeUserResource($resumeUser)
        ], 200);
    }
}
