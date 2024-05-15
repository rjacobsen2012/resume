<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResumeRequest;
use App\Http\Requests\UpdateResumeRequest;
use App\Models\Resume;
use App\Models\User;
use App\Support\ResumeFilesTrait;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ResumeController extends Controller
{
    use ResumeFilesTrait;

    public function index()
    {
        /** @var User $user */
        if (! $user = auth()->user()) {
            return Inertia::render('Welcome');
        }

        if (! $user->resume) {
            return Inertia::render('Welcome');
        }

        return Inertia::render('Resume/Show', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'resume' => $user->resume->load([
                'skills',
                'examples',
                'experiences',
                'educations',
            ]),
        ]);
    }

    public function edit()
    {
        /** @var User $user */
        $user = auth()->user();
        $resume = $user?->resume;
        $this->authorize('update', $resume);

        return Inertia::render('Resume/Edit', [
            'resume' => $resume->load([
                'skills',
                'examples',
                'experiences',
                'educations',
            ]),
        ]);
    }

    public function create()
    {
        $this->authorize('create', Resume::class);

        return Inertia::render('Resume/Create', [
            'page' => 'newResume',
        ]);
    }

    public function update(UpdateResumeRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $resume = $user?->resume;
        $this->authorize('update', $resume);

        $this->saveResumeFiles($request, $resume);

        $validated = $request->validated();
        $validated['is_hidden'] = (bool) $validated['is_hidden'];

        $resume->fill($validated);
        $resume->save();

        return redirect()
            ->route('resume.edit', [$resume->id])
            ->with('status', 'Resume updated successfully');
    }

    public function store(StoreResumeRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();
        $this->authorize('create', Resume::class);

        $validated = $request->validated();
        $validated['is_hidden'] = (bool) $validated['is_hidden'];

        /** @var Resume $resume */
        $resume = $user->resume()
            ->create($validated);

        $this->saveResumeFiles($request, $resume);

        return redirect()
            ->route('resume.edit', [$resume->id])
            ->with('status', 'Resume created successfully');
    }

    public function download(Resume $resume, string $type = 'pdf')
    {
        $resumeFile = $type === 'pdf' ? $resume->pdf_resume : $resume->word_resume;
        $file = "user/$resume->user_id/$resumeFile";

        if (! file_exists(public_path('storage/' . $file))) {
            return back()->with('status', 'File does not exist');
        }

        return Storage::disk('public')->download($file);
    }
}
