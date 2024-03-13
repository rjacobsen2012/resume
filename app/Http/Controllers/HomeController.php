<?php

namespace App\Http\Controllers;

use App\Cryptos\Decryptors\ResumeDecryptor;
use App\Models\Resume;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(ResumeDecryptor $decryptor)
    {
        return Inertia::render('Home', [
            'resumes' => $decryptor->decryptAll(Resume::notHidden()->orderBy('name')->get()),
        ]);
    }
}
