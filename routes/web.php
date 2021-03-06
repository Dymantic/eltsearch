<?php

use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\RegistrationPageController;
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
    Route::get('delivery-policy', 'DeliveryPolicyController@show');
    Route::get('refund-policy', 'RefundPolicyController@show');
    Route::get('terms-of-service', 'TermsOfServiceController@show');

    Route::view('register/school', 'front.schools.register');

    Route::get('register', [RegistrationPageController::class, 'show']);

    Route::get('contact', [ContactMessageController::class, 'show']);

    Route::view('login', 'front.login')->name('login');
    Route::view('password/request', 'front.request-password-reset');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');

    Route::get('schools/{school:key}', 'SchoolProfilesController@show');

    Route::get('job-posts', 'JobPostsController@index');
    Route::get('/job-posts/{post:slug}', 'JobPostsController@show');

    Route::get('/job-posts/{post:slug}/apply', 'ApplicationsController@create');
    Route::get('guest-applications/create-application', 'GuestApplicationsController@create');
    Route::get('guest-applications/create-profile', 'GuestApplicationsProfileController@create');
    Route::get('guest-applications/add-experience', 'GuestApplicationExperienceController@create');
    Route::get('guest-applications/add-profile-image', 'GuestApplicationsProfileImageController@create');
});

Route::get('/secure3d-orders/{purchase:purchase_uuid}/return', 'SuccessSecure3DSPurchaseController@store');
Route::get('/secure3d-orders/{purchase:purchase_uuid}/cancel', 'CancelledSecure3DSPurchaseController@store');



Route::get('login/google', 'GoogleLoginController@redirect');
Route::get('google/auth/callback', 'GoogleAuthResponseController@store')->middleware('test_google_oauth');
Route::get('register/teacher/google', 'GoogleRegisterController@redirect');

Route::get('login/facebook', 'FacebookLoginController@redirect');
Route::get('register/teacher/facebook', 'FacebookRegisterController@redirect');
Route::get('facebook/auth/callback', 'FacebookAuthResponseController@store');




Route::post('guest-applications', 'GuestApplicationsController@store');

Route::post('guest-applications/profile', 'GuestApplicationsProfileController@store');

Route::post('guest-applications/experience', 'GuestApplicationExperienceController@store');

Route::post('guest-applications/profile-image', 'GuestApplicationsProfileImageController@store')->middleware('json.response');
Route::post('complete-guest-applications', 'CompleteGuestApplicationsController@store');

Route::post('logout', 'LoginController@logout');

Route::get('register/teacher', 'TeacherRegistrationController@create');
Route::post('register/teacher', 'TeacherRegistrationController@store');


Route::post('register/school', 'SchoolRegistrationController@store');


Route::post('login', 'LoginController@login');

Route::get('teachers', 'TeacherDashboardController@show')->middleware(["auth", "teacher"]);

Route::get('schools', 'SchoolsDashboardController@show')->middleware(["auth", "school"]);
Route::get('admin', 'AdminDashboardController@show')->middleware(["auth", "admin"]);


Route::post('password/request', 'RequestPasswordResetLinkController@sendResetLinkEmail');


Route::post('password/reset', 'ResetPasswordController@reset');

Route::post('/api/me/reset-password', 'UserPasswordController@update')->middleware('auth');

Route::post('contact', 'ContactMessageController@store');

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
    Route::delete('read-notifications/{notification}', 'ReadNotificationsController@destroy');
    Route::get('new-notifications-status', 'NewNotificationsStatusController@show');

    Route::post('preferred-lang', 'PreferredLangController@store');

    Route::get('nations', 'NationsController@index');

    Route::get('job-posts/{post:slug}', 'PublicJobPostsController@show');




});


Route::group([
    'middleware' => ['school', 'auth'],
    'prefix'     => 'api',
    'namespace'  => 'Schools'
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

    Route::get('schools/{school}/public-teachers', 'PublicTeachersController@index');
    Route::get('schools/{school}/public-teachers/{slug}', 'PublicTeachersController@show');

    Route::get('schools/{school}/recruitment-attempts', 'SchoolRecruitmentAttemptsController@index');
    Route::post('schools/{school}/recruitment-attempts', 'SchoolRecruitmentAttemptsController@store');

    Route::get('schools/{school}/dashboard-status', 'SchoolDashboardStatusController@show');
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
    Route::post('teachers/area', 'TeacherAreaController@update');

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

    Route::get('teachers/recruitment-attempts', 'TeacherRecruitmentAttemptsController@index');

    Route::post('teachers/dismissed-recruitment-attempts', 'DismissedRecruitmentAttemptsController@store');

    Route::get('teachers/dashboard-status', 'TeacherDashboardStatusController@show');

    Route::post('teachers/application-approvals', 'ApplicationApprovalsController@show');

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

    Route::get('announcements', 'AnnouncementsController@index');
    Route::post('public-announcements', 'PublicAnnouncementsController@store');
    Route::post('school-announcements', 'SchoolAnnouncementsController@store');
    Route::post('teacher-announcements', 'TeacherAnnouncementsController@store');
    Route::post('announcements/{announcement}', 'AnnouncementsController@update');
    Route::delete('announcements/{announcement}', 'AnnouncementsController@delete');

    Route::get('job-posts', 'JobPostsController@index');
    Route::get('job-posts/{jobPost}', 'JobPostsController@show');
    Route::get('job-posts-overview', 'JobPostsOverviewController@show');

    Route::get('teachers', 'TeachersController@index');
    Route::get('teachers-overview', 'TeacherOverviewController@show');
    Route::get('teachers/{teacher}', 'TeachersController@show');

    Route::get('schools-overview', 'SchoolsOverviewController@show');
    Route::get('schools', 'SchoolsController@index');
    Route::get('schools/{school}', 'SchoolsController@show');
    Route::get('schools/{school}/job-posts', 'SchoolJobPostsController@index');
    Route::get('schools/{school}/purchases', 'SchoolPurchasesController@index');

    Route::get('purchases', 'PurchasesController@index');
    Route::get('purchases/{purchase}', 'PurchasesController@show');
    Route::get('purchases-overview', 'PurchasesOverviewController@show');

    Route::post('disabled-teachers', 'DisabledTeachersController@store');
    Route::delete('disabled-teachers/{teacher}', 'DisabledTeachersController@destroy');

    Route::post('disabled-schools', 'DisabledSchoolsController@store');
    Route::delete('disabled-schools/{school}', 'DisabledSchoolsController@destroy');

    Route::post('disabled-job-posts', 'DisabledJobPostsController@store');
    Route::delete('disabled-job-posts/{post}', 'DisabledJobPostsController@destroy');
});
