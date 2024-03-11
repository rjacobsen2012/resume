<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', [
            'resumes' => Resume::notHidden()->orderBy('name')->get(),
        ]);
    }
}
