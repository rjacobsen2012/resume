<?php

namespace App\Http\Controllers;

use App\Cryptos\Encryptors\ExampleEncryptor;
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
        Resume $resume,
        ExampleEncryptor $encryptor
    ) {
        $this->authorize('create', [Example::class, $resume]);

        $resume->examples()->create($encryptor->encrypt($request->validated()));

        return back()->with('status', 'Education added successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateExampleRequest $request,
        Resume $resume,
        Example $example,
        ExampleEncryptor $encryptor
    ) {
        $this->authorize('update', [Example::class, $resume, $example]);

        $example->update($encryptor->encrypt($request->validated()));

        return back()->with('status', 'Example updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resume $resume, Example $example)
    {
        $this->authorize('delete', [Example::class, $resume, $example]);

        $example->delete();

        return back()->with('status', 'Example deleted successfully');
    }
}
