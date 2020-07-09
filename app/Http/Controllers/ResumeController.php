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
    /**
     * @return Response
     */
    public function index()
    {
        return Inertia::render('Admin/Resume', ['resumeUser' => resumeUser()]);
    }

    /**
     * @return BinaryFileResponse
     */
    public function downloadResume()
    {
        $file = public_path('files/rjacobsen_resume_pdf_2020.pdf');
        $headers = ['Content-Type' => 'application/pdf'];
        return response()->download($file, 'rjacobsen_resume_pdf_2020.pdf', $headers);
    }

    /**
     * @return BinaryFileResponse
     */
    public function downloadResumeWord()
    {
        $file = public_path('files/rjacobsen_resume_word_2020.docx');
        $headers = ['Content-Type' => 'application/pdf'];
        return response()->download($file, 'rjacobsen_resume_word_2020.docx', $headers);
    }
}
