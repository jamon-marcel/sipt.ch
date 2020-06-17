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
  Route::get('administrator', 'Api\AdministratorController@index');

  // Students
  Route::get('students', 'Api\StudentController@index');
  Route::post('student/update/{student}', 'Api\StudentController@update');

  Route::get('student/profile/{student?}', 'Api\StudentController@profile')->middleware('role:student');
  Route::get('student/edit/{student}', 'Api\StudentController@edit')->middleware('role:student');
  Route::post('student/store/course/event/{student?}', 'Api\StudentController@storeCourseEvent');
  Route::delete('student/remove/course/event/{courseEvent}/{student?}', 'Api\StudentController@destroyCourseEvent');
  Route::get('student/courses/booked/{student?}', 'Api\StudentController@bookedCourses')->middleware('role:student');
  Route::get('student/courses/attended/{student?}', 'Api\StudentController@attendedCourses')->middleware('role:student');
  Route::get('student/courses/upcoming/{limit}', 'Api\StudentController@upcomingCourses')->middleware('role:student');
  Route::get('student/courses/{student}', 'Api\StudentController@courses');
  Route::get('student/course/show/{courseEvent}', 'Api\StudentController@course');
  Route::get('student/{student}', 'Api\StudentController@show');


  // Tutors
  Route::get('tutors', 'Api\TutorController@index');
  Route::get('tutors/active', 'Api\TutorController@active');
  Route::get('tutor/{tutor}', 'Api\TutorController@show');
  Route::get('tutor/edit/{tutor}', 'Api\TutorController@edit');
  Route::post('tutor/create', 'Api\TutorController@store');
  Route::post('tutor/update/{tutor}', 'Api\TutorController@update');
  Route::get('tutor/toggle/{tutor}', 'Api\TutorController@toggle');
  Route::delete('tutor/destroy/{tutor}', 'Api\TutorController@destroy');

  // Trainings
  Route::get('trainings', 'Api\TrainingController@index');
  Route::get('training/{training}', 'Api\TrainingController@show');
  Route::get('training/edit/{training}', 'Api\TrainingController@edit');
  Route::post('training/create', 'Api\TrainingController@store');
  Route::post('training/update/{training}', 'Api\TrainingController@update');
  Route::get('training/toggle/{training}', 'Api\TrainingController@toggle');
  Route::delete('training/destroy/{training}', 'Api\TrainingController@destroy');

  // Courses
  Route::get('courses', 'Api\CourseController@index');
  Route::get('courses/by/training/{training}', 'Api\CourseController@getCoursesByTraining');
  Route::get('course/{course}', 'Api\CourseController@show');
  Route::get('course/edit/{course}', 'Api\CourseController@edit');
  Route::post('course/create', 'Api\CourseController@store');
  Route::post('course/update/{course}', 'Api\CourseController@update');
  Route::get('course/toggle/{course}', 'Api\CourseController@toggle');
  Route::delete('course/destroy/{course}', 'Api\CourseController@destroy');


  // CourseEvents
  Route::get('course/events/by/course/{course}', 'Api\CourseEventController@getCourseEventsByCourse');
  Route::get('course/events/{course}', 'Api\CourseEventController@index');
  Route::get('course/event/{courseEvent}', 'Api\CourseEventController@show');
  Route::post('course/event/create', 'Api\CourseEventController@store');
  Route::post('course/event/update/{courseEvent}', 'Api\CourseEventController@update');
  Route::get('course/event/edit/{courseEvent}', 'Api\CourseEventController@edit');
  Route::get('course/event/toggle/{courseEvent}', 'Api\CourseEventController@toggle');
  Route::get('course/event/cancel/{courseEvent}', 'Api\CourseEventController@cancel');
  Route::delete('course/event/destroy/{courseEvent}', 'Api\CourseEventController@destroy');
  Route::get('course/event/student/{courseEvent}', 'Api\CourseEventController@student');


  // CoursesEventDates
  Route::delete('course/event/date/destroy/{courseEventDate}', 'Api\CourseEventDateController@destroy');

  // Register a tutor
  Route::post('user/tutor/register', 'Api\UserController@register')->middleware('role:admin');

  // Settings
  Route::get('settings/locations', 'Api\SettingsController@locations');
  Route::get('settings/training/categories', 'Api\SettingsController@trainingCategories');

  // Users
  Route::get('user/student', 'Api\UserController@student')->middleware('role:student');
  Route::get('user/tutor', 'Api\UserController@tutor')->middleware('role:tutor');
  Route::get('user/admin', 'Api\UserController@admin')->middleware('role:admin');
  Route::post('user/update/email', 'Api\UserController@updateEmail');

});
