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
        /** @var User|null $user */
        $user = auth()->user() ?? User::first();

        if (! $user?->resume) {
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
        /** @var User|null $user */
        $user = auth()->user();
        $resume = $user?->resume;

        // Nothing to edit yet. A bare 403 here tells the user nothing and offers no way on.
        if (! $resume) {
            return redirect()->route('resume.create');
        }

        $this->authorize('update', $resume);

        return Inertia::render('Resume/Edit', [
            'resume' => $resume->load([
                // the periods come with the skills, so the editor can render and the
                // pill label can be computed without a query per skill
                'skills.periods',
                'examples',
                'experiences',
                'educations',
            ]),
        ]);
    }

    public function create()
    {
        // They already have one, and there is only ever one. Take them to it rather than
        // rendering a form that the policy will refuse on submit.
        if (auth()->user()?->resume) {
            return redirect()->route('resume.edit');
        }

        $this->authorize('create', Resume::class);

        return Inertia::render('Resume/Create', [
            'page' => 'newResume',
        ]);
    }

    public function update(UpdateResumeRequest $request)
    {
        /** @var User|null $user */
        $user = auth()->user();
        $resume = $user?->resume;
        $this->authorize('update', $resume);

        $this->saveResumeFiles($request, $resume);

        $validated = $request->validated();
        $validated['is_hidden'] = (bool) ($validated['is_hidden'] ?? false);

        $resume->fill($validated);
        $resume->save();

        return redirect()
            ->route('resume.edit')
            ->with('status', 'Resume updated successfully');
    }

    public function store(StoreResumeRequest $request)
    {
        /** @var User|null $user */
        $user = auth()->user();
        $this->authorize('create', Resume::class);

        $validated = $request->validated();
        $validated['is_hidden'] = (bool) ($validated['is_hidden'] ?? false);

        /** @var Resume $resume */
        $resume = $user->resume()
            ->create($validated);

        $this->saveResumeFiles($request, $resume);

        return redirect()
            ->route('resume.edit')
            ->with('status', 'Resume created successfully');
    }

    public function download(Resume $resume, string $type = 'pdf')
    {
        $resumeFile = $type === 'pdf' ? $resume->pdf_resume : $resume->word_resume;
        $file = "user/$resume->user_id/$resumeFile";

        if (! file_exists(public_path('storage/'.$file))) {
            return back()->with('status', 'File does not exist');
        }

        return Storage::disk('public')->download($file);
    }
}
