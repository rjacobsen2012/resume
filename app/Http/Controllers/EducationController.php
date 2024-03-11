<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEducationRequest;
use App\Http\Requests\UpdateEducationRequest;
use App\Models\Education;
use App\Models\Resume;
use Illuminate\Support\Carbon;

class EducationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEducationRequest $request, Resume $resume)
    {
        $this->authorize('create', [Education::class, $resume]);

        $resume->educations()->create([
            'school' => $request->input('school'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'degree' => $request->input('degree'),
            'started_at' => Carbon::parse($request->input('started_at')),
            'ended_at' => Carbon::parse($request->input('ended_at')),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            'message' => 'Education added successfully',
            'resume' => $resume->refresh(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateEducationRequest $request,
        Resume $resume,
        Education $education
    ) {
        $this->authorize('update', [Education::class, $resume, $education]);

        $education->update([
            'school' => $request->input('school'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'degree' => $request->input('degree'),
            'started_at' => Carbon::parse($request->input('started_at')),
            'ended_at' => Carbon::parse($request->input('ended_at')),
            'description' => $request->input('description'),
        ]);

        return response()->json([
            'message' => 'Education updated successfully',
            'resume' => $resume->refresh(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resume $resume, Education $education)
    {
        $this->authorize('delete', [Education::class, $resume, $education]);

        $education->delete();

        return response()->json([
            'message' => 'Education deleted successfully',
            'resume' => $resume->refresh(),
        ]);
    }
}
