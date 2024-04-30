<?php

namespace App\Support;

use App\Models\Resume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait ResumeFilesTrait
{
    protected function saveResumeFiles(Request $request, Resume $resume): void
    {
        if ($file = $request->file('pdf_resume')) {
            $fileName = $file->getClientOriginalName();
            $resumeName = 'user/'.$request->user()->id.'/'.$fileName;
            Storage::disk('public')->put($resumeName, file_get_contents($file));
            $resume->pdf_resume = $fileName;
        } elseif ($request->input('delete_pdf')) {
            $resumeName = 'user/'.$request->user()->id.'/'.$resume->pdf_resume;
            Storage::disk('public')->delete($resumeName);
            $resume->pdf_resume = null;
        }

        if ($file = $request->file('word_resume')) {
            $fileName = $file->getClientOriginalName();
            $resumeName = 'user/'.$request->user()->id.'/'.$fileName;
            Storage::disk('public')->put($resumeName, file_get_contents($file));
            $resume->word_resume = $fileName;
        } elseif ($request->input('delete_word')) {
            $resumeName = 'user/'.$request->user()->id.'/'.$resume->word_resume;
            Storage::disk('public')->delete($resumeName);
            $resume->word_resume = null;
        }

        $resume->save();
    }

    protected function deleteResumeFiles(Resume $resume): void
    {
        if ($resume->pdf_resume) {
            $resumeName = 'user/'.$resume->user->id.'/'.$resume->pdf_resume;
            Storage::disk('public')->delete($resumeName);
        }

        if ($resume->word_resume) {
            $resumeName = 'user/'.$resume->user->id.'/'.$resume->word_resume;
            Storage::disk('public')->delete($resumeName);
        }
    }

    protected function deleteResume(?Resume $resume = null): void
    {
        if ($resume instanceof Resume) {
            $resume->educations()->delete();
            $resume->examples()->delete();
            $resume->experiences()->delete();
            $resume->skills()->delete();
            $this->deleteResumeFiles($resume);
            $resume->delete();
        }
    }
}
