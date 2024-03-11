<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResumeRequest;
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

        return Inertia::render('Resume/Show', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'resume' => Resume::byValue($value)->first(),
        ]);
    }

    public function edit(Resume $resume)
    {
        $this->authorize('update', $resume);

        return Inertia::render('Resume/Edit', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'resume' => $resume,
        ]);
    }

    public function create()
    {
        $this->authorize('create', Resume::class);

        return Inertia::render('Resume/Create', [
            'page' => 'newResume',
        ]);
    }

    public function update(ResumeRequest $request, Resume $resume)
    {
        $this->authorize('update', $resume);

        $this->saveResumeFiles($request);

        $resume->fill($request->validated());
        $resume->save();

        return response()->json([
            'message' => 'Resume updated successfully',
            'resume' => $resume->refresh(),
        ]);
    }

    public function store(ResumeRequest $request)
    {
        $this->authorize('create', Resume::class);

        $this->saveResumeFiles($request);

        /** @var Resume $resume */
        $resume = auth()->user()->resume()->create($request->validated());

        return redirect()->route('resume.edit', [$resume->id]);
    }
}
