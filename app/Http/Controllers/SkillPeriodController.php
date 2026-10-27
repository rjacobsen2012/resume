<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSkillPeriodRequest;
use App\Http\Requests\UpdateSkillPeriodRequest;
use App\Models\Resume;
use App\Models\Skill;
use App\Models\SkillPeriod;
use Illuminate\Http\RedirectResponse;

/**
 * The stretches of time a skill was in use. A skill is added with none, and spans
 * are added and removed afterwards.
 */
class SkillPeriodController extends Controller
{
    public function store(
        StoreSkillPeriodRequest $request,
        Resume $resume,
        Skill $skill
    ): RedirectResponse {
        $this->authorize('update', [Skill::class, $resume, $skill]);

        $skill->periods()->create([
            'started_on' => $request->date('started_on'),
            // absent or blank means the skill is still in use
            'ended_on' => $request->filled('ended_on') ? $request->date('ended_on') : null,
        ]);

        return redirect()
            ->route('resume.edit', [$resume->id])
            ->with('status', 'Date range added successfully');
    }

    /**
     * Correct an existing range. The backfilled dates are derived from the old
     * years/months totals, not recorded history, so most of them need adjusting.
     */
    public function update(
        UpdateSkillPeriodRequest $request,
        Resume $resume,
        Skill $skill,
        SkillPeriod $period
    ): RedirectResponse {
        $this->authorize('update', [Skill::class, $resume, $skill]);

        abort_unless($period->skill_id === $skill->id, 404);

        $period->update([
            'started_on' => $request->date('started_on'),
            'ended_on' => $request->filled('ended_on') ? $request->date('ended_on') : null,
        ]);

        return redirect()
            ->route('resume.edit', [$resume->id])
            ->with('status', 'Date range updated successfully');
    }

    public function destroy(
        Resume $resume,
        Skill $skill,
        SkillPeriod $period
    ): RedirectResponse {
        $this->authorize('update', [Skill::class, $resume, $skill]);

        // ⚠️ Confirm the period really belongs to this skill. Without it, an id from
        // another user's skill would be accepted purely because the URL named this one.
        abort_unless($period->skill_id === $skill->id, 404);

        $period->delete();

        return redirect()
            ->route('resume.edit', [$resume->id])
            ->with('status', 'Date range removed successfully');
    }
}
