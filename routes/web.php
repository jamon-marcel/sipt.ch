<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware gwroup. Now create something great!
|
*/

Route::get('/', function () {
  return view('welcome');
});

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/student', 'StudentController@index')->name('dashboard.student');


Route::get('/test/courses/{course}', 'TestController@course');
Route::get('/test/student/register', 'TestController@register');
Route::post('/test/student/store', 'TestController@store')->name('student_store');
Route::get('/test/student/dates/{student}', 'TestController@student');
Route::get('/test/courses', 'TestController@courses');

/*
|--------------------------------------------------------------------------
| Admin Web routes
|--------------------------------------------------------------------------
|
*/

Route::middleware('auth:sanctum')->group(function() {

  // CatchAll: Dashboard Student
  Route::get('student/{any?}', function () {
    return view('dashboards.student.app');
  })->where('any', '.*')->middleware('role:student');

  // CatchAll: Dashboard Dozenten

  // CatchAll: Dashboard Administration
  Route::get('administration/{any?}', function () {
    return view('dashboards.administration.app');
  })->where('any', '.*')->middleware('role:admin');
});
