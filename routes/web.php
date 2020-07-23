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

Route::get('/', function () {
    return view('welcome');
});

Route::post('logout', 'LoginController@logout');

Route::get('register/teacher', 'TeacherRegistrationController@create');
Route::post('register/teacher', 'TeacherRegistrationController@store');

Route::view('register/school', 'front.schools.register');
Route::post('register/school', 'SchoolRegistrationController@store');

Route::view('login', 'front.login')->name('login');
Route::post('login', 'LoginController@login');

Route::get('teachers', 'TeacherDashboardController@show')->middleware(["auth", "teacher"]);

Route::get('schools', 'SchoolsDashboardController@show')->middleware(["auth", "school"]);

Route::view('password/request', 'front.request-password-reset');
Route::post('password/request', 'RequestPasswordResetLinkController@sendResetLinkEmail');

Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'ResetPasswordController@reset');


Route::group([
    'middleware' => ['school', 'auth'],
    'prefix'     => 'api',
    'namespace'  => 'Admin\Schools'
], function () {
    Route::post('schools/{school}', 'SchoolProfileController@update');
});

Route::group([
    'middleware' => ['admin', 'auth'],
    'prefix'     => 'api',
    'namespace'  => 'Admin'
], function() {

    Route::post('countries', 'CountriesController@store');
    Route::post('countries/{country}', 'CountriesController@update');

    Route::post('countries/{country}/regions', 'RegionsController@store');
    Route::post('regions/{region}', 'RegionsController@update');
    Route::delete('regions/{region}', 'RegionsController@delete');

    Route::post('regions/{region}/areas', 'AreasController@store');
    Route::post('areas/{area}', 'AreasController@update');
    Route::delete('areas/{area}', 'AreasController@delete');

    Route::post('school-types', 'SchoolTypesController@store');
    Route::post('school-types/{schoolType}', 'SchoolTypesController@update');
    Route::delete('school-types/{schoolType}', 'SchoolTypesController@delete');
});
