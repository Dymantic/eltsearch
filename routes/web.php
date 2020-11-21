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

Route::group([
    'prefix'     => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect']
], function () {
    Route::get('/', 'HomePageController@show');
    Route::view('how-it-works', 'front.how-it-works.page');
    Route::get('for-schools', 'ForSchoolsPageController@show');

    Route::get('privacy-policy', 'PrivacyPolicyController@show');
    Route::get('terms-of-service', 'TermsOfServiceController@show');
});

Route::get('/job-posts/{post:slug}/apply', 'ApplicationsController@create');
Route::post('/job-posts/{post:slug}/apply', 'ApplicationsController@store');

Route::get('login/facebook', 'FacebookLoginController@redirect');
Route::get('register/teacher/facebook', 'FacebookRegisterController@redirect');
Route::get('facebook/auth/callback', 'FacebookAuthResponseController@store');

Route::get('job-posts', 'JobPostsController@index');
Route::get('/job-posts/{post:slug}', 'JobPostsController@show');


Route::post('logout', 'LoginController@logout');

Route::get('register/teacher', 'TeacherRegistrationController@create');
Route::post('register/teacher', 'TeacherRegistrationController@store');

Route::view('register/school', 'front.schools.register');
Route::post('register/school', 'SchoolRegistrationController@store');

Route::view('login', 'front.login')->name('login');
Route::post('login', 'LoginController@login');

Route::get('teachers', 'TeacherDashboardController@show')->middleware(["auth", "teacher"]);

Route::get('schools', 'SchoolsDashboardController@show')->middleware(["auth", "school"]);
Route::get('admin', 'AdminDashboardController@show')->middleware(["auth", "admin"]);

Route::view('password/request', 'front.request-password-reset');
Route::post('password/request', 'RequestPasswordResetLinkController@sendResetLinkEmail');

Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'ResetPasswordController@reset');

Route::post('/api/me/reset-password', 'UserPasswordController@update')->middleware('auth');

Route::group([
    'middleware' => ['auth'],
    'prefix'     => 'api',
    'namespace'  => 'Api'
], function () {
    Route::get('locations', 'LocationsController@index');

    Route::get('school-types', 'SchoolTypesController@index');

    Route::get('basic-profile', 'BasicProfileController@show');

    Route::get('notifications', 'NotificationsController@index');
    Route::delete('notifications/{notification}', 'NotificationsController@delete');
    Route::post('read-notifications', 'ReadNotificationsController@store');

    Route::post('preferred-lang', 'PreferredLangController@store');
});


Route::group([
    'middleware' => ['school', 'auth'],
    'prefix'     => 'api',
    'namespace'  => 'Admin\Schools'
], function () {
    Route::get('schools/user-schools', 'UserSchoolsController@index');
    Route::post('schools/{school}', 'SchoolProfileController@update')
         ->middleware('can:manage,school');

    Route::post('schools/{school}/logos', 'SchoolLogosController@store')
         ->middleware('can:manage,school');
    Route::delete('schools/{school}/logos', 'SchoolLogosController@destroy')
         ->middleware('can:manage,school');

    Route::post('schools/{school}/images', 'SchoolImagesController@store')
         ->middleware('can:manage,school');
    Route::delete('schools/{school}/images/{image}', 'SchoolImagesController@delete')
         ->middleware('can:manage,school');

    Route::post('schools/{school}/billing-details', 'SchoolBillingDetailsController@update')
         ->middleware('can:manage,school');

    Route::get('schools/{school}/job-posts', 'SchoolJobPostsController@index')
         ->middleware('can:manage,school');
    Route::post('schools/{school}/job-posts', 'SchoolJobPostsController@store')
         ->middleware('can:manage,school');
    Route::post('schools/job-posts/{post}', 'SchoolJobPostsController@update')
         ->middleware('can:manage,post');
    Route::delete('schools/job-posts/{post}', 'SchoolJobPostsController@delete')
         ->middleware('can:manage,post');

    Route::post('schools/posts/published-job-posts', 'PublishedJobPostsController@store');
    Route::delete('schools/posts/published-job-posts/{job_post}', 'PublishedJobPostsController@destroy');

    Route::post('job-posts/{post}/images', 'JobPostImagesController@store')
         ->middleware('can:manage,post');
    Route::delete('job-posts/{post}/images/{image}', 'JobPostImagesController@destroy')
         ->middleware('can:manage,post');

    Route::get('schools/job-post-options', 'JobPostOptionsController@show');

    Route::get('schools/{school}/applications', 'SchoolApplicationsController@index');

    Route::post('schools/applications/{application}/show-of-interest', 'ShowOfInterestController@store');

    Route::get('schools/{school}/purchases', 'SchoolPurchasesController@index');
    Route::post('schools/{school}/purchases', 'SchoolPurchasesController@store');

    Route::get('schools/{school}/tokens', 'SchoolTokensController@index');
    Route::get('schools/{school}/resume-pass', 'SchoolResumePassController@show');
    Route::get('schools/packages', 'PackagesController@index');
});

Route::group([
    'middleware' => ['teacher', 'auth'],
    'prefix'     => 'api',
    'namespace'  => 'Teachers'
], function () {
    Route::get('teachers/profile/general', 'TeacherGeneralProfileController@show');
    Route::post('teachers/profile/general', 'TeacherGeneralProfileController@update');
    Route::get('teachers/profile/education', 'TeacherEducationProfileController@show');
    Route::post('teachers/profile/education', 'TeacherEducationProfileController@update');

    Route::get('teachers/previous-employments', 'TeacherPreviousEmploymentController@index');
    Route::post('teachers/previous-employments', 'TeacherPreviousEmploymentController@store');
    Route::post('teachers/previous-employments/{employment}',
        'TeacherPreviousEmploymentController@update')
         ->middleware('can:manage,employment');
    Route::delete('teachers/previous-employments/{employment}',
        'TeacherPreviousEmploymentController@delete')->middleware('can:manage,employment');

    Route::post('teachers/avatar', 'TeacherAvatarController@store');

    Route::post('teachers/public-teachers', 'PublicTeachersController@store');
    Route::delete('teachers/public-teachers', 'PublicTeachersController@destroy');

    Route::get('teachers/job-search', 'TeacherJobSearchController@show');
    Route::post('teachers/job-searches', 'TeacherJobSearchController@store');
    Route::delete('teachers/job-searches/{search}', 'TeacherJobSearchController@delete');

    Route::get('teachers/job-search-options', 'JobSearchOptionsController@show');

    Route::get('teachers/job-applications', 'TeacherJobApplicationsController@index');
    Route::post('teachers/job-applications', 'TeacherJobApplicationsController@store');

    Route::get('teachers/show-of-interests', 'TeacherShowOfInterestsController@index');

    Route::get('teachers/job-matches', 'TeacherJobMatchesController@index');
    Route::delete('teachers/job-matches/{match}', 'TeacherJobMatchesController@destroy')
         ->middleware('can:manage,match');


});


Route::group([
    'middleware' => ['admin', 'auth'],
    'prefix'     => 'api/admin/',
    'namespace'  => 'Admin'
], function () {

    Route::get('countries', 'CountriesController@index');
    Route::post('countries', 'CountriesController@store');
    Route::post('countries/{country}', 'CountriesController@update');
    Route::delete('countries/{country}', 'CountriesController@delete');

    Route::post('countries/{country}/regions', 'RegionsController@store');
    Route::post('regions/{region}', 'RegionsController@update');
    Route::delete('regions/{region}', 'RegionsController@delete');

    Route::post('regions/{region}/areas', 'AreasController@store');
    Route::post('areas/{area}', 'AreasController@update');
    Route::delete('areas/{area}', 'AreasController@delete');

    Route::get('school-types', 'SchoolTypesController@index');
    Route::post('school-types', 'SchoolTypesController@store');
    Route::post('school-types/{schoolType}', 'SchoolTypesController@update');
    Route::delete('school-types/{schoolType}', 'SchoolTypesController@delete');

    Route::post('public-announcements', 'PublicAnnouncementsController@store');
    Route::post('school-announcements', 'SchoolAnnouncementsController@store');
    Route::post('teacher-announcements', 'TeacherAnnouncementsController@store');
    Route::post('announcements/{announcement}', 'AnnouncementsController@update');
    Route::delete('announcements/{announcement}', 'AnnouncementsController@delete');
});
