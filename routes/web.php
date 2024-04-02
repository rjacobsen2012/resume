<?php

use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\UserThemeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ResumeController::class, 'index'])->name('resume.index');
Route::get('resume/{resume}/download/{type?}', [ResumeController::class, 'download'])->name('resume.download');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::put('user/{user}/theme', [UserThemeController::class, 'update'])->name('user-theme.update');

    Route::get('resume/edit', [ResumeController::class, 'edit'])->name('resume.edit');
    Route::get('resume/create', [ResumeController::class, 'create'])->name('resume.create');
    Route::put('resume/update', [ResumeController::class, 'update'])->name('resume.update');
    Route::post('resume/store', [ResumeController::class, 'store'])->name('resume.store');

    Route::resource('resume.skill', SkillController::class)
        ->only(['store', 'update', 'destroy']);

    Route::resource('resume.education', EducationController::class)
        ->only(['store', 'update', 'destroy']);

    Route::resource('resume.experience', ExperienceController::class)
        ->only(['store', 'update', 'destroy']);

    Route::resource('resume.example', ExampleController::class)
        ->only(['store', 'update', 'destroy']);
});
