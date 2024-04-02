<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreExampleRequest;
use App\Http\Requests\UpdateExampleRequest;
use App\Models\Example;
use App\Models\Resume;

class ExampleController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreExampleRequest $request,
        Resume $resume
    ) {
        $this->authorize('create', [Example::class, $resume]);

        $resume->examples()->create($request->validated());

        return redirect()
            ->route('resume.edit', [$resume->id])
            ->with('status', 'Education added successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateExampleRequest $request,
        Resume $resume,
        Example $example
    ) {
        $this->authorize('update', [Example::class, $resume, $example]);

        $example->update($request->validated());

        return redirect()
            ->route('resume.edit', [$resume->id])
            ->with('status', 'Example updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resume $resume, Example $example)
    {
        $this->authorize('delete', [Example::class, $resume, $example]);

        $example->delete();

        return redirect()
            ->route('resume.edit', [$resume->id])
            ->with('status', 'Example deleted successfully');
    }
}
