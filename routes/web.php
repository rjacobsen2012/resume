<?php

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

Route::get('/', 'GuestController@index')->name('guest');

Route::get('resume-user/download-resume', 'ResumeController@downloadResume')->name('resume-user.download-resume');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::resource('resume', 'ResumeController')->only(['index']);

    Route::get('/home', function () {
        return redirect()->to(route('resume.index'));
    });

});
