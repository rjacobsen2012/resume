<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Resume;
use App\Models\ResumeSkill;
use App\Models\Skill;

class SkillController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreSkillRequest $request,
        Resume $resume
    ) {
        $this->authorize('create', [Skill::class, $resume]);

        $name = $request->input('name');
        $years = $request->input('years') ?? 0;
        $months = $request->input('months') ?? 0;
        $resumeSkill = ResumeSkill::firstOrCreate(['name' => strtolower($name)]);
        $resume->skills()->create([
            'resume_skill_id' => $resumeSkill->id,
            'years' => $years,
            'months' => $months,
        ]);

        return response()->json([
            'message' => 'Skill added successfully',
            'resume' => $resume->refresh(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateSkillRequest $request,
        Resume $resume,
        Skill $skill
    ) {
        $this->authorize('update', [Skill::class, $resume, $skill]);

        $years = $request->input('years') ?? 0;
        $months = $request->input('months') ?? 0;
        $skill->update([
            'years' => $years,
            'months' => $months,
        ]);

        return response()->json([
            'message' => 'Skill updated successfully',
            'resume' => $resume->refresh(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Resume $resume,
        Skill $skill
    ) {
        $this->authorize('delete', [Skill::class, $resume, $skill]);

        $skill->delete();

        return response()->json([
            'message' => 'Skill deleted successfully',
            'resume' => $resume->refresh(),
        ]);
    }
}
