<?php

namespace App\Http\Controllers;

use App\Cryptos\Encryptors\EducationEncryptor;
use App\Http\Requests\StoreEducationRequest;
use App\Http\Requests\UpdateEducationRequest;
use App\Models\Education;
use App\Models\Resume;

class EducationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreEducationRequest $request,
        Resume $resume,
        EducationEncryptor $encryptor
    ) {
        $this->authorize('create', [Education::class, $resume]);

        $resume->educations()->create($encryptor->encrypt($request->validated()));

        return back()->with('status', 'Education added successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateEducationRequest $request,
        Resume $resume,
        Education $education,
        EducationEncryptor $encryptor
    ) {
        $this->authorize('update', [Education::class, $resume, $education]);

        $education->update($encryptor->encrypt($request->validated()));

        return back()->with('status', 'Education updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resume $resume, Education $education)
    {
        $this->authorize('delete', [Education::class, $resume, $education]);

        $education->delete();

        return back()->with('status', 'Education deleted successfully');
    }
}
