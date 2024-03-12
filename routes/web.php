<?php

use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthUserLoading;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::resource('resume', ResumeController::class)
    ->only(['index', 'show', 'create']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    AuthUserLoading::class,
])->group(function () {
    Route::resource('home', HomeController::class)->only('index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('resume', ResumeController::class)
        ->only(['edit', 'create', 'store', 'update']);

    Route::resource('resume.skill', SkillController::class)
        ->only(['store', 'update', 'destroy']);

    Route::resource('resume.education', EducationController::class)
        ->only(['store', 'update', 'destroy']);

    Route::resource('resume.experience', ExperienceController::class)
        ->only(['store', 'update', 'destroy']);

    Route::get('users', [UserController::class, 'data'])->name('user.data');
    Route::put('user/{user}/update-roles', [UserController::class, 'updateUserRoles'])->name('user.update-roles');
    Route::resource('user', UserController::class);

    Route::get('roles', [RoleController::class, 'data'])->name('role.data');
    Route::resource('role', RoleController::class);

    Route::get('permissions', [PermissionController::class, 'data'])->name('permission.data');
    Route::resource('permission', PermissionController::class);
});
