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
        $resumeSkill = ResumeSkill::firstOrCreate(['name' => strtolower($name)]);

        // A skill is created with NO date ranges. They are added afterwards, which is
        // what lets one skill have several ("2000 to 2005, then 2010 to 2016").
        $resume->skills()->create([
            'resume_skill_id' => $resumeSkill->id,
        ]);

        return redirect()
            ->route('resume.edit', [$resume->id])
            ->with('status', 'Skill added successfully');
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

        // Only the name is editable here now. How long the skill has been used is
        // derived from its date ranges, not typed in.
        $name = $request->input('name');

        if (filled($name)) {
            $skill->update([
                'resume_skill_id' => ResumeSkill::firstOrCreate(['name' => strtolower($name)])->id,
            ]);
        }

        return redirect()
            ->route('resume.edit', [$resume->id])
            ->with('status', 'Skill updated successfully');
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

        return redirect()
            ->route('resume.edit', [$resume->id])
            ->with('status', 'Skill deleted successfully');
    }
}
