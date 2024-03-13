<?php

namespace App\Http\Controllers;

use App\Cryptos\Encryptors\ExperienceEncryptor;
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
        Resume $resume,
        ExperienceEncryptor $encryptor,
    ) {
        $this->authorize('create', [Experience::class, $resume]);

        $resume->experiences()->create($encryptor->encrypt($request->validated()));

        return back()->with('status', 'Experience added successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateExperienceRequest $request,
        Resume $resume,
        Experience $experience,
        ExperienceEncryptor $encryptor
    ) {
        $this->authorize('update', [Experience::class, $resume, $experience]);

        $experience->update($encryptor->encrypt($request->validated()));

        return back()->with('status', 'Experience updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resume $resume, Experience $experience)
    {
        $this->authorize('delete', [Experience::class, $resume, $experience]);

        $experience->delete();

        return back()->with('status', 'Experience deleted successfully');
    }
}
