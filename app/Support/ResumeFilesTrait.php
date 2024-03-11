<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait ResumeFilesTrait
{
    protected function saveResumeFiles(Request $request): void
    {
        if ($file = $request->file('pdf')) {
            $extension = $file->getClientOriginalExtension();
            $resumeName = config('resume.file') . '.' . $extension;
            Storage::disk('public')->put($resumeName, file_get_contents($file));
            Log::info('form file: ' . PHP_EOL . json_encode($file->getClientOriginalExtension()));
        }

        if ($file = $request->file('word')) {
            $extension = $file->getClientOriginalExtension();
            $resumeName = config('resume.file') . '.' . $extension;
            Storage::disk('public')->put($resumeName, file_get_contents($file));
            Log::info('form file: ' . PHP_EOL . json_encode($file->getClientOriginalExtension()));
        }
    }
}