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

Auth::routes(['verify' => true]);
Route::get('auth/login', 'Auth\AuthController@getLogin');

Route::get('/', 'HomeController@index')->name('home');
Route::get('/login', 'HomeController@login')->name('login');
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/student/sign-up', 'RegisterController@register');
Route::post('/student/store', 'RegisterController@store')->name('student_store');

/*
|--------------------------------------------------------------------------
| Admin Web routes
|--------------------------------------------------------------------------
|
*/

Route::middleware('auth:sanctum', 'verified')->group(function() {

  // CatchAll: Dashboard Student
  Route::get('student/{any?}', function () {
    return view('dashboards.student.app');
  })->where('any', '.*')->middleware('role:student');

  // CatchAll: Dashboard Dozenten
  Route::get('tutor/{any?}', function () {
    return view('dashboards.tutor.app');
  })->where('any', '.*')->middleware('role:tutor');

  // CatchAll: Dashboard Administration
  Route::get('administration/{any?}', function () {
    return view('dashboards.administration.app');
  })->where('any', '.*')->middleware('role:admin');
});
