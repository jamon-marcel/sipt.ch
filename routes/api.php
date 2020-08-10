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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

Route::middleware('auth:sanctum')->group(function() {

  // Administrators
  Route::get('administrator', 'Api\AdministratorController@find');

  // Student routes
  Route::middleware('role:student')->group(function() {
    Route::get('students', 'Api\StudentController@get');
    Route::get('student/{student?}', 'Api\StudentController@find');
    Route::put('student/{student}', 'Api\StudentController@update');
    Route::post('student/course/event/{student?}', 'Api\StudentController@storeEvent');
    Route::get('student/course/event/{courseEvent}/{student?}', 'Api\StudentController@getEvent');
    Route::get('student/course/events/{type?}/{limit?}/{student?}', 'Api\StudentController@getEvents');
    Route::get('student/course/event/withdraw/{courseEvent}/{student?}', 'Api\StudentController@withdrawEvent');
    Route::delete('student/course/event/{courseEvent}/{student?}', 'Api\StudentController@destroyEvent');
  });

  // Tutor routes
  Route::middleware('role:tutor')->group(function() {
    Route::get('tutors/{constraint?}', 'Api\TutorController@get');
    Route::get('tutor/{tutor?}', 'Api\TutorController@find');
    Route::post('tutor', 'Api\TutorController@store')->middleware('role:admin');
    Route::put('tutor/{tutor}', 'Api\TutorController@update');
    Route::get('tutor/state/{tutor}', 'Api\TutorController@toggle')->middleware('role:admin');
    Route::delete('tutor/{tutor}', 'Api\TutorController@destroy')->middleware('role:admin');
    Route::get('tutor/course/events/{type?}/{tutor?}', 'Api\TutorController@getEvents');
    Route::get('tutor/course/event/{courseEvent}/{tutor?}', 'Api\TutorController@getEvent');
    Route::get('tutor/image/state/{tutorImage}', 'Api\TutorImageController@toggle');
    Route::delete('tutor/image/{tutorImage}', 'Api\TutorImageController@destroy');
    Route::put('tutor/image/{tutorImage}', 'Api\TutorImageController@coords');
  });

  // Training routes for students
  Route::middleware('role:student')->group(function() {
    Route::get('trainings', 'Api\TrainingController@get');
    Route::get('training/{training}', 'Api\TrainingController@find');
  });

  // Training routes for admins
  Route::middleware('role:admin')->group(function() {
    Route::post('training', 'Api\TrainingController@store');
    Route::put('training/{training}', 'Api\TrainingController@update');
    Route::delete('training/{training}', 'Api\TrainingController@destroy');
    Route::get('training/state/{training}', 'Api\TrainingController@toggle');
  });

  // Course routes
  Route::get('courses', 'Api\CourseController@get');
  Route::get('course/{course}', 'Api\CourseController@find');
  Route::post('course/create', 'Api\CourseController@store')->middleware('role:admin');
  Route::put('course/{course}', 'Api\CourseController@update')->middleware('role:admin');
  Route::get('course/state/{course}', 'Api\CourseController@toggle')->middleware('role:admin');
  Route::delete('course/{course}', 'Api\CourseController@destroy')->middleware('role:admin');
  Route::get('courses/by/training/{training}', 'Api\CourseController@getByTraining');
  Route::get('course/with/events/{course}', 'Api\CourseController@getWithEvents');

  // CourseEvents routes
  Route::get('course/events/fetch/{constraint?}', 'Api\CourseEventController@fetch');
  Route::get('course/events/{course}', 'Api\CourseEventController@get');
  Route::get('course/event/{courseEvent}', 'Api\CourseEventController@find');
  Route::post('course/event', 'Api\CourseEventController@store')->middleware('role:admin');
  Route::put('course/event/{courseEvent}', 'Api\CourseEventController@update')->middleware('role:admin');
  Route::get('course/event/state/{courseEvent}', 'Api\CourseEventController@toggle')->middleware('role:admin');
  Route::get('course/event/cancel/{courseEvent}', 'Api\CourseEventController@cancel');
  Route::get('course/event/close/{courseEvent}', 'Api\CourseEventController@close');
  Route::get('course/event/open/{courseEvent}', 'Api\CourseEventController@open');
  Route::delete('course/event/{courseEvent}', 'Api\CourseEventController@destroy')->middleware('role:admin');
  Route::get('course/events/by/course/{course}', 'Api\CourseEventController@getByCourse');

  // CoursesEventDates routes
  Route::delete('course/event/date/{courseEventDate}', 'Api\CourseEventDateController@destroy')->middleware('role:admin');

  // CourseEventFiles routes
  Route::middleware('role:tutor')->group(function() {
    Route::post('course/event/files', 'Api\CourseEventFileController@store');
    Route::delete('course/event/file/{courseEventFile}', 'Api\CourseEventFileController@destroy');
  });

  // Settings
  Route::middleware('role:admin')->group(function() {
    Route::get('settings/locations', 'Api\SettingsController@locations');
    Route::get('settings/training/categories', 'Api\SettingsController@trainingCategories');
  });

  // Users
  Route::get('user/student', 'Api\UserController@student')->middleware('role:student');
  Route::get('user/tutor', 'Api\UserController@tutor')->middleware('role:tutor');
  Route::get('user/admin', 'Api\UserController@admin')->middleware('role:admin');
  Route::post('user/email', 'Api\UserController@updateEmail');
  Route::post('user/tutor/register', 'Api\UserController@register')->middleware('role:admin');

  // Upload routes
  Route::middleware('role:tutor')->group(function() {
    Route::post('image/upload','Api\UploadController@image');
    Route::post('file/upload','Api\UploadController@file');
  });

  // Backoffice
  Route::middleware('role:admin')->group(function() {
    Route::get('backoffice/courses/list/concluded', 'Api\BackofficeController@getConcludedCourses');
    Route::get('backoffice/courses/list/closed', 'Api\BackofficeController@getClosedCourses');
    Route::get('backoffice/student/attendance/{student}/{courseEvent}', 'Api\BackofficeController@setAttendance');
    Route::get('backoffice/student/bookings/{student}', 'Api\BackofficeController@getBookings');
    Route::get('backoffice/course/event/{courseEvent}', 'Api\BackofficeController@getCourseEvent');
    Route::delete('backoffice/course/event/student/{courseEvent}/{student}', 'Api\BackofficeController@destroyCourseEventStudent');
    Route::get('backoffice/invoices/{constraint?}', 'Api\InvoiceController@get');
    Route::get('backoffice/invoice/history/{invoice}', 'Api\InvoiceController@getHistory');
    Route::get('backoffice/invoice/{invoice}', 'Api\InvoiceController@find');
    Route::put('backoffice/invoice/state/{invoice}', 'Api\InvoiceController@state');
    Route::put('backoffice/invoice/cancel/{invoice}', 'Api\InvoiceController@cancel');
    Route::get('backoffice/invoice/notice/{invoice}/{noticeType}', 'Api\InvoiceController@notice');
    Route::post('backoffice/invoice/store', 'Api\BackofficeController@createInvoice');
    Route::post('backoffice/import', 'Api\BackofficeController@import');
  });

  // Symposium routes
  Route::middleware('role:admin')->group(function() {
    Route::get('symposium/subscribers', 'Api\SymposiumSubscriberController@get');
    Route::get('symposium/{symposiumSubscriber?}', 'Api\SymposiumSubscriberController@find');
    Route::post('symposium/subscribe', 'Api\SymposiumSubscriberController@store');
    Route::put('symposium/{symposiumSubscriber}', 'Api\SymposiumSubscriberController@update');
    Route::delete('symposium/{symposiumSubscriber}', 'Api\SymposiumSubscriberController@cancel');

  });

});
