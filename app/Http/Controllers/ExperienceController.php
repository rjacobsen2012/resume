<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExperienceRequest;
use App\Http\Requests\UpdateExperienceRequest;
use App\Models\Experience;
use App\Models\Resume;

class ExperienceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreExperienceRequest $request,
        Resume $resume
    ) {
        $this->authorize('create', [Experience::class, $resume]);

        $validated = $request->validated();
        $validated['is_hidden'] = (bool) $validated['is_hidden'];
        $validated['present'] = (bool) $validated['present'];

        $resume->experiences()->create($validated);

        return redirect()
            ->route('resume.edit', [$resume->id])
            ->with('status', 'Experience added successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateExperienceRequest $request,
        Resume $resume,
        Experience $experience
    ) {
        $this->authorize('update', [Experience::class, $resume, $experience]);

        $validated = $request->validated();
        $validated['is_hidden'] = (bool) $validated['is_hidden'];
        $validated['present'] = (bool) $validated['present'];

        $experience->update($validated);

        return redirect()
            ->route('resume.edit', [$resume->id])
            ->with('status', 'Experience updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resume $resume, Experience $experience)
    {
        $this->authorize('delete', [Experience::class, $resume, $experience]);

        $experience->delete();

        return redirect()
            ->route('resume.edit', [$resume->id])
            ->with('status', 'Experience deleted successfully');
    }
}
