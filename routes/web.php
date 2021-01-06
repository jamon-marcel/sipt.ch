<?php

use Illuminate\Support\Facades\Route;
use Spatie\Honeypot\ProtectAgainstSpam;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
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
// Route::post('/jubilaeums-fachtagung-15-jahre-sipt/registration', 'SymposiumSubscriberController@store')->middleware(ProtectAgainstSpam::class)->name('symposium_register');
// Route::get('/jubilaeums-fachtagung-15-jahre-sipt/anmeldung-erfolgreich', 'SymposiumController@registered')->name('symposium_register_success');
Route::get('/jubilaeums-fachtagung-15-jahre-sipt/abmeldung/{symposiumSubscriber}', 'SymposiumSubscriberController@cancel')->name('symposium_cancel');
Route::get('/jubilaeums-fachtagung-15-jahre-sipt/abmeldung-erfolgreich', 'SymposiumController@cancelled')->name('symposium_cancelled');

// Newsletter
Route::get('/newsletter/abbestellen/{newsletterSubscriber}', 'NewsletterController@cancel')->name('newsletter_cancel');

// TOC
Route::get('/agb', 'AboutController@toc')->name('about_toc');

// Downloads
Route::get('/downloads', 'DownloadController@index')->name('downloads_index');

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

/*
|--------------------------------------------------------------------------
| Admin Web routes
|--------------------------------------------------------------------------
|
*/

Route::middleware('auth:sanctum', 'verified')->group(function() {

  // Temp. Registration Symposium
  Route::get('/admin/jubilaeums-fachtagung-15-jahre-sipt', 'SymposiumController@anniversaryAdmin');
  Route::post('/admin/jubilaeums-fachtagung-15-jahre-sipt/registration', 'SymposiumSubscriberController@store')->middleware(ProtectAgainstSpam::class)->name('symposium_register');
  Route::get('/admin/jubilaeums-fachtagung-15-jahre-sipt/anmeldung-erfolgreich', 'SymposiumController@registered')->name('symposium_register_success');

  // Dev routes
  Route::get('/mask-user', 'DevController@maskUser');
  Route::get('/invite', 'DevController@invite');
  Route::get('/bills', 'DevController@bills');
  Route::get('/reminder', 'DevController@reminder');
  Route::get('/message', 'DevController@message');

  // Downloads for tutors / admins
  Route::get('/download/modulliste', 'DownloadController@listCourses')->middleware('role:tutor');
  Route::get('/download/teilnehmerliste/{courseEvent}', 'DownloadController@listParticipants')->middleware('role:admin');
  Route::get('/download/anwesenheitsliste/{courseEvent}', 'DownloadController@listAttendances')->middleware('role:tutor');
  Route::get('/download/fachtagung/teilnehmerliste', 'DownloadController@listSymposiumParticipants')->middleware('role:admin');
  Route::get('/export/fachtagung/teilnehmerliste', 'DownloadController@exportSymposiumParticipants')->middleware('role:admin');
  Route::get('/export/adressliste/studenten', 'DownloadController@exportStudentAddresses')->middleware('role:admin');
  Route::get('/export/adressliste/dozenten', 'DownloadController@exportTutorAddresses')->middleware('role:admin');
  Route::get('/export/adressliste/vip', 'DownloadController@exportVipAddresses')->middleware('role:admin');


  // Downloads for students
  Route::get('/download/kursbestaetigung/{courseEvent}/{student?}', 'DownloadController@confirmation')->middleware('role:student');
  Route::get('/download/kurseinladung/{courseEvent}/{student?}', 'DownloadController@invitation')->middleware('role:student');
  Route::get('/download/kursuebersicht/{student?}', 'DownloadController@overview')->middleware('role:student');


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
