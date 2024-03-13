<?php

namespace App\Http\Controllers;

use App\Cryptos\Decryptors\ResumeDecryptor;
use App\Models\Resume;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class PublicController extends Controller
{
    public function index(ResumeDecryptor $decryptor)
    {
        return Inertia::render('Resume/Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'resumes' => $decryptor->decryptAll(Resume::notHidden()->get()),
            'resume' => $decryptor->decrypt(auth()->user()?->resume),
        ]);
    }
}
