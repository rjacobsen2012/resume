<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExperienceRequest;
use App\Http\Requests\UpdateExperienceRequest;
use App\Models\Experience;
use App\Models\Resume;
use Illuminate\Support\Carbon;

class ExperienceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExperienceRequest $request, Resume $resume)
    {
        $this->authorize('create', [Experience::class, $resume]);

        $resume->experiences()->create([
            'company_name' => $request->input('company_name'),
            'title' => $request->input('title'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'started_at' => Carbon::parse($request->input('started_at')),
            'ended_at' => Carbon::parse($request->input('ended_at')),
            'present' => (bool) $request->input('present'),
            'description' => $request->input('description'),
            'is_hidden' => (bool) $request->input('is_hidden'),
        ]);

        return response()->json([
            'message' => 'Experience added successfully',
            'resume' => $resume->refresh(),
        ]);
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

        $experience->update([
            'company_name' => $request->input('company_name'),
            'title' => $request->input('title'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'started_at' => Carbon::parse($request->input('started_at')),
            'ended_at' => Carbon::parse($request->input('ended_at')),
            'present' => (bool) $request->input('present'),
            'description' => $request->input('description'),
            'is_hidden' => (bool) $request->input('is_hidden'),
        ]);

        return response()->json([
            'message' => 'Experience updated successfully',
            'resume' => $resume->refresh(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resume $resume, Experience $experience)
    {
        $this->authorize('delete', [Experience::class, $resume, $experience]);

        $experience->delete();

        return response()->json([
            'message' => 'Experience deleted successfully',
            'resume' => $resume->refresh(),
        ]);
    }
}
