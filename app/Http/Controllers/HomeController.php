<?php

namespace App\Http\Controllers;

use App\Cryptos\Decryptors\ResumeDecryptor;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        return Inertia::render('Home');
    }
}
