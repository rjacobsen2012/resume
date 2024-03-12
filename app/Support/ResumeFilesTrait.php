<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait ResumeFilesTrait
{
    protected function saveResumeFiles(Request $request): void
    {
        if ($file = $request->file('pdf_resume')) {
            $extension = $file->getClientOriginalExtension();
            $resumeName = 'user/' . $request->user()->id . '/' . config('resume.file') . '.' . $extension;
            Storage::disk('public')->put($resumeName, file_get_contents($file));
//            Log::info('form file: ' . PHP_EOL . json_encode($file->getClientOriginalExtension()));
        }

        if ($file = $request->file('word_resume')) {
            $extension = $file->getClientOriginalExtension();
            $resumeName = 'user/' . $request->user()->id . '/' . config('resume.file') . '.' . $extension;
            Storage::disk('public')->put($resumeName, file_get_contents($file));
//            Log::info('form file: ' . PHP_EOL . json_encode($file->getClientOriginalExtension()));
        }
    }
}