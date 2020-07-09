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

// Auth routes
Auth::routes(['verify' => true, 'register' => false]);
Route::get('/logout', 'Auth\LoginController@logout');

// Home
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');

// Das SIPT
Route::get('/das-sipt/ueber-uns', 'AboutController@about')->name('about_index');
Route::get('/das-sipt/leitung-dozierende', 'AboutController@tutors')->name('about_tutors');
Route::get('/das-sipt/dozent/{slug?}/{tutor}', 'AboutController@tutor')->name('about_tutor');

// Bildungsangebot
Route::get('/bildungsangebote/{slug?}/{trainingCategory}', 'TrainingController@trainingsByCategory')->name('training_category');
Route::get('/bildungsangebot/{slug?}/{training}', 'TrainingController@show')->name('training_show');
Route::get('/bildungsangebot/modul/{slug?}/{course}/{redirect?}', 'CourseController@show')->name('course_show');

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

// Bookings
Route::get('/booking/{courseEvent}', 'BookingController@add');
Route::post('/booking/cancel/confirm', 'BookingController@destroy')->name('booking_cancel_confirm');
Route::get('/booking/cancel/{courseEvent}/{student}', 'BookingController@cancel')->name('booking_cancel_preview');
Route::post('/booking/register', 'BookingController@registerAndStore');
Route::post('/booking', 'BookingController@store')->middleware('role:student');
Route::delete('/booking/{courseEvent}', 'BookingController@remove');
Route::get('/bookings', 'BookingController@get');

// Student Login
Route::post('/auth/student/login', 'LoginController@login')->name('student_login');


// Dev
Route::get('/import', 'RegisterController@import');
Route::get('/teilnehmerliste/{courseEvent}', 'RegisterController@participantlist');

// Dev - email previews
Route::get('preview/verification', function () {
  $user = App\Models\User::find('3a2fa106-970c-4ef1-a817-ff5e1043a863');
  return new App\Mail\EmailVerification(['user' => $user, 'user_data' => ['password' => 'asdfasdfa']]);
});

/*
|--------------------------------------------------------------------------
| Admin Web routes
|--------------------------------------------------------------------------
|
*/

Route::middleware('auth:sanctum', 'verified')->group(function() {

  // Downloads for tutors / admins
  Route::get('/download/modulliste', 'DownloadController@courses')->middleware('role:tutor');
  Route::get('/download/teilnehmerliste/{courseEvent}', 'DownloadController@participants')->middleware('role:tutor');

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
