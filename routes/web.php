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
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/login', 'HomeController@login')->name('login');

// Home
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/pdf', 'HomeController@pdf')->name('home');

// Register (marked for deletion)
Route::get('/student/sign-up', 'RegisterController@register');
Route::post('/student/store', 'RegisterController@store')->name('student_store');

// Das SIPT
Route::get('/das-sipt/ueber-uns', 'AboutController@about')->name('about_index');
Route::get('/das-sipt/leitung-dozierende', 'AboutController@tutors')->name('about_tutors');
Route::get('/das-sipt/dozent/{slug?}/{tutor}', 'AboutController@tutor')->name('about_tutor');

// Beratung und Zertifizierung
Route::get('/beratung-und-zertifizierung-von-institutionen', 'ConsultingController@index')->name('consulting_index');

// Netzwerk
Route::get('/netzwerk/sipt-therapeutinnen', 'NetworkController@therapists')->name('network_therapists');
Route::get('/netzwerk/sipt-zertifizierte-kliniken', 'NetworkController@clinics')->name('network_clinics');
Route::get('/netzwerk/partner-institutionen', 'NetworkController@partners')->name('network_partners');

// Symposium
Route::get('/jubilaeums-fachtagung-15-jahre-sipt', 'SymposiumController@anniversary')->name('symposium_anniversary');
Route::post('/jubilaeums-fachtagung-15-jahre-sipt/registration', 'SymposiumSubscriberController@store')->name('symposium_register');
Route::get('/jubilaeums-fachtagung-15-jahre-sipt/anmeldung-erfolgreich', 'SymposiumController@registered')->name('symposium_register_success');

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
  })->where('any', '.*')->middleware('role:student')->name('dashboard_student');

  // CatchAll: Dashboard Dozenten
  Route::get('tutor/{any?}', function () {
    return view('dashboards.tutor.app');
  })->where('any', '.*')->middleware('role:tutor')->name('dashboard_tutor');

  // CatchAll: Dashboard Administration
  Route::get('administration/{any?}', function () {
    return view('dashboards.administration.app');
  })->where('any', '.*')->middleware('role:admin')->name('dashboard_admin');
});
