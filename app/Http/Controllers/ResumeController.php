<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class ResumeController
 * @package App\Http\Controllers
 */
class ResumeController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Resume', ['resumeUser' => resumeUser()]);
    }

    public function downloadResume(): BinaryFileResponse
    {
        $file = public_path('files/rjacobsen_current_resume_feb2024.pdf');
        $headers = ['Content-Type' => 'application/pdf'];
        return response()->download($file, 'richard_jacobsen_resume.pdf', $headers);
    }

    public function downloadResumeWord(): BinaryFileResponse
    {
        $file = public_path('files/rjacobsen_current_resume_feb2024.docx');
        $headers = ['Content-Type' => 'application/pdf'];
        return response()->download($file, 'richard_jacobsen_resume.docx', $headers);
    }
}
