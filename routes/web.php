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

Auth::routes(['verify' => true]);

Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/home', 'HomeController@index')->name('home');

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

  // CatchAll: Dashboard Administration
  Route::get('administration/{any?}', function () {
    return view('dashboards.administration.app');
  })->where('any', '.*')->middleware('role:admin');
});
