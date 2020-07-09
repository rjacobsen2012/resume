<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:api', 'prefix' => 'v1', 'namespace' => 'Api', 'as' => 'api.v1.'], function () {

    Route::resource('resume-user', 'ResumeUserController');
    Route::resource('resume-user.resume-skill', 'ResumeSkillController');
    Route::resource('resume-user.resume-experience', 'ResumeExperienceController');
    Route::resource('resume-user.resume-work-example', 'ResumeWorkExampleController');

});
