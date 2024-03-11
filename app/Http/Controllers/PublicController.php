<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class PublicController extends Controller
{
    public function index()
    {
        return Inertia::render('Resume/Index', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'resumes' => Resume::notHidden()->get(),
            'resume' => auth()->user()?->resume
        ]);
    }
}
