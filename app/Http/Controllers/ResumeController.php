<?php

namespace App\Http\Controllers;

use App\Cryptos\Decryptors\EducationDecryptor;
use App\Cryptos\Decryptors\ExampleDecryptor;
use App\Cryptos\Decryptors\ExperienceDecryptor;
use App\Cryptos\Encryptors\ResumeEncryptor;
use App\Cryptos\Decryptors\ResumeDecryptor;
use App\Http\Requests\ResumeRequest;
use App\Http\Resources\ResumeResource;
use App\Models\Resume;
use App\Rules\ResumeSearch;
use App\Support\ResumeFilesTrait;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ResumeController extends Controller
{
    use ResumeFilesTrait;

    public function index()
    {
        $this->authorize('viewAny', Resume::class);

        return Inertia::render('Resume/Index', [
            'resumes' => Resume::notHidden()->pluck('name', 'id'),
        ]);
    }

    public function show(string $value)
    {
        $validator = Validator::make([
            'value' => $value,
        ], [
            'value' => [new ResumeSearch],
        ]);

        if (! $validator->passes()) {
            return redirect()->to('/resume');
        }

        $resume = Resume::byValue($value)->first();
        $resume->profile = decrypt($resume->profile);
        $this->authorize('view', [Resume::class, $resume]);

        return Inertia::render('Resume/Show', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'resume' => $resume,
        ]);
    }

    public function edit(
        Resume $resume,
        ResumeDecryptor $decryptor,
        EducationDecryptor $educationDecryptor,
        ExperienceDecryptor $experienceDecryptor,
        ExampleDecryptor $exampleDecryptor,
    ) {
        $this->authorize('update', $resume);

        return Inertia::render('Resume/Edit', [
            'resume' => $decryptor->decrypt($resume),
            'examples' => $exampleDecryptor->decryptAll($resume->examples),
            'educations' => $educationDecryptor->decryptAll($resume->educations),
            'experiences' => $experienceDecryptor->decryptAll($resume->experiences),
            'skills' => $resume->skills,
        ]);
    }

    public function create()
    {
        $this->authorize('create', Resume::class);

        return Inertia::render('Resume/Create', [
            'page' => 'newResume',
        ]);
    }

    public function update(
        ResumeRequest $request,
        Resume $resume,
        ResumeEncryptor $encryptor
    ) {
        $this->authorize('update', $resume);

        $this->saveResumeFiles($request, $resume);

        $resume->fill($encryptor->encrypt($request->validated()));
        $resume->save();

        return redirect()
            ->route('resume.edit', [$resume->id])
            ->with('status', 'Resume updated successfully');
    }

    public function store(ResumeRequest $request, ResumeEncryptor $encryptor)
    {
        $this->authorize('create', Resume::class);

        /** @var Resume $resume */
        $resume = auth()->user()->resume()
            ->create($encryptor->encrypt($request->validated()));

        $this->saveResumeFiles($request, $resume);

        return redirect()
            ->route('resume.edit', [$resume->id])
            ->with('status', 'Resume created successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resume $resume)
    {
        $this->authorize('delete', [Resume::class, $resume]);

        $this->deleteResume($resume);

        return redirect()
            ->route('home.index')
            ->with('status', 'Resume deleted successfully');
    }
}
