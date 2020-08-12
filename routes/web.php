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
    Route::post('schools/{school}', 'SchoolProfileController@update')->middleware('can:manage,school');

    Route::post('schools/{school}/logos', 'SchoolLogosController@store')->middleware('can:manage,school');
    Route::delete('schools/{school}/logos', 'SchoolLogosController@destroy')->middleware('can:manage,school');

    Route::post('schools/{school}/images', 'SchoolImagesController@store')->middleware('can:manage,school');
    Route::delete('schools/{school}/images/{image}', 'SchoolImagesController@delete')->middleware('can:manage,school');

    Route::post('schools/{school}/job-posts', 'SchoolJobPostsController@store')->middleware('can:manage,school');
    Route::post('schools/job-posts/{post}', 'SchoolJobPostsController@update')->middleware('can:manage,post');
    Route::delete('schools/job-posts/{post}', 'SchoolJobPostsController@delete')->middleware('can:manage,post');

    Route::post('published-job-posts', 'PublishedJobPostsController@store');
    Route::delete('published-job-posts/{post}', 'PublishedJobPostsController@destroy');

    Route::post('job-posts/{post}/images', 'JobPostImagesController@store')->middleware('can:manage,post');
});

Route::group([
    'middleware' => ['teacher', 'auth'],
    'prefix'     => 'api',
    'namespace'  => 'Teachers'
], function () {
    Route::post('teachers/profile/general', 'TeacherGeneralProfileController@update');
    Route::post('teachers/profile/education', 'TeacherEducationProfileController@update');

    Route::post('teachers/previous-employment', 'TeacherPreviousEmploymentController@store');
    Route::post('teachers/previous-employments/{employment}', 'TeacherPreviousEmploymentController@update')->middleware('can:manage,employment');
    Route::delete('teachers/previous-employments/{employment}', 'TeacherPreviousEmploymentController@delete')->middleware('can:manage,employment');

    Route::post('teachers/avatar', 'TeacherAvatarController@store');

    Route::post('teachers/public-teachers', 'PublicTeachersController@store');
    Route::delete('teachers/public-teachers', 'PublicTeachersController@destroy');

    Route::post('teachers/job-searches', 'TeacherJobSearchController@store');
    Route::delete('teachers/job-searches/{search}', 'TeacherJobSearchController@delete');

    Route::post('teachers/job-applications', 'TeacherJobApplicationsController@store');
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
