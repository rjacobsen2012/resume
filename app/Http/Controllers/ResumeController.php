<?php

namespace App\Http\Controllers;

use App\Cryptos\Decryptors\ResumeDecryptor;
use App\Cryptos\Encryptors\ResumeEncryptor;
use App\Http\Requests\ResumeRequest;
use App\Models\Resume;
use App\Rules\ResumeSearch;
use App\Support\ResumeFilesTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
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

    public function show(string $value, ResumeDecryptor $decryptor)
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
        $this->authorize('view', [Resume::class, $resume]);

        return Inertia::render('Resume/Show', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'resume' => $decryptor->decrypt($resume),
        ]);
    }

    public function edit(
        Resume $resume,
        ResumeDecryptor $decryptor,
    ) {
        $this->authorize('update', $resume);

        return Inertia::render('Resume/Edit', [
            'resume' => $decryptor->decrypt($resume->fresh()),
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

        $validated = $request->validated();
        $validated['is_hidden'] = (bool) $validated['is_hidden'];

        $resume->fill($encryptor->encrypt($validated));
        $resume->save();

        return redirect()
            ->route('resume.edit', [$resume->id])
            ->with('status', 'Resume updated successfully');
    }

    public function store(ResumeRequest $request, ResumeEncryptor $encryptor)
    {
        $this->authorize('create', Resume::class);

        $validated = $request->validated();
        $validated['is_hidden'] = (bool) $validated['is_hidden'];

        /** @var Resume $resume */
        $resume = auth()->user()->resume()
            ->create($encryptor->encrypt($validated));

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

    public function download(Resume $resume, string $type = 'pdf')
    {
        $this->authorize('view', [Resume::class, $resume]);

        $resumeFile = $type === 'pdf' ? $resume->pdf_resume : $resume->word_resume;
        $file = "storage/user/$resume->user_id/$resumeFile";

        if (! file_exists(public_path($file))) {
            return back()->with('status', 'File does not exist');
        }

        return redirect(url($file));
    }
}
