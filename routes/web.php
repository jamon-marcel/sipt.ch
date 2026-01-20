<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Spatie\Honeypot\ProtectAgainstSpam;

// Import controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ConsultingController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\SymposiumController;
use App\Http\Controllers\SymposiumSubscriberController;
use App\Http\Controllers\MailinglistController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DevController;
use App\Http\Controllers\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\AnniversaryController;
use App\Http\Controllers\AnniversaryRegistrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
*/

// Auth routes
Auth::routes(['verify' => true, 'register' => false]);
Route::get('/logout', [AuthLoginController::class, 'logout']);

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Das SIPT
Route::get('/das-sipt/ueber-uns', [AboutController::class, 'about'])->name('about_index');
Route::get('/das-sipt/leitung-dozierende', [AboutController::class, 'tutors'])->name('about_tutors');
Route::get('/das-sipt/dozent/{slug?}/{tutor}', [AboutController::class, 'tutor'])->name('about_tutor');
Route::get('/datenschutz', [AboutController::class, 'privacy'])->name('about_privacy');
Route::get('/faq', [AboutController::class, 'faq'])->name('about_faq');

// Bildungsangebot
Route::get('/export/bildungsangebot/{slug?}/{training}', [TrainingController::class, 'export'])->name('training_export');
Route::get('/bildungsangebote/{slug?}/{trainingCategory}', [TrainingController::class, 'trainingsByCategory'])->name('training_category');
Route::get('/bildungsangebot/{slug?}/{training}', [TrainingController::class, 'show'])->name('training_show');
Route::get('/bildungsangebot/modul/{slug?}/{course}/{redirect?}', [CourseController::class, 'show'])->name('course_show');

// Beratung und Zertifizierung
Route::get('/beratung-und-zertifizierung-von-institutionen', [ConsultingController::class, 'index'])->name('consulting_index');

// Netzwerk
Route::get('/netzwerk/sipt-therapeutinnen', [NetworkController::class, 'therapists'])->name('network_therapists');
// Route::get('/netzwerk/sipt-zertifizierte-kliniken', [NetworkController::class, 'clinics'])->name('network_clinics');
Route::get('/netzwerk/partner-institutionen', [NetworkController::class, 'partners'])->name('network_partners');

// Symposium
Route::get('/jubilaeums-fachtagung-15-jahre-sipt', [SymposiumController::class, 'anniversary'])->name('symposium_anniversary');
// Route::post('/jubilaeums-fachtagung-15-jahre-sipt/registration', [SymposiumSubscriberController::class, 'store'])->middleware(ProtectAgainstSpam::class)->name('symposium_register');
// Route::get('/jubilaeums-fachtagung-15-jahre-sipt/anmeldung-erfolgreich', [SymposiumController::class, 'registered'])->name('symposium_register_success');
Route::get('/jubilaeums-fachtagung-15-jahre-sipt/abmeldung/{symposiumSubscriber}', [SymposiumSubscriberController::class, 'cancel'])->name('symposium_cancel');
Route::get('/jubilaeums-fachtagung-15-jahre-sipt/abmeldung-erfolgreich', [SymposiumController::class, 'cancelled'])->name('symposium_cancelled');

// 20 Jahre SIPT Anniversary
Route::get('/20-jahre-sipt', [AnniversaryController::class, 'index'])->name('anniversary_index');
Route::post('/20-jahre-sipt/registration', [AnniversaryRegistrationController::class, 'store'])->middleware(ProtectAgainstSpam::class)->name('anniversary_register');
Route::get('/20-jahre-sipt/anmeldung-erfolgreich', [AnniversaryController::class, 'registered'])->name('anniversary_register_success');

// Mailinglist
Route::get('/newsletter', [MailinglistController::class, 'index'])->name('mailinglist_index');
Route::post('/newsletter/anmelden', [MailinglistController::class, 'register'])->name('mailinglist_register');
Route::post('/newsletter/aktualisieren', [MailinglistController::class, 'update'])->name('mailinglist_update');
Route::get('/newsletter/bestaetigung/{mailinglistSubscriber}', [MailinglistController::class, 'confirm'])->name('mailinglist_confirm');
Route::get('/newsletter/abbestellen/{mailinglistSubscriber}', [MailinglistController::class, 'cancel'])->name('mailinglist_cancel');
Route::get('/newsletter/verwalten/{mailinglistSubscriber:hash}', [MailinglistController::class, 'manage'])->name('mailinglist_manage');


// TOC / Privacy
Route::get('/agb', [AboutController::class, 'toc'])->name('about_toc');
Route::get('/datenschutz', [AboutController::class, 'privacy'])->name('about_privacy');

// Downloads
Route::get('/downloads', [DownloadController::class, 'index'])->name('downloads_index');

// Jobs
Route::get('/stelleninserate', [AboutController::class, 'jobs'])->name('jobs_index');

// Downloads
Route::get('/suche', [SearchController::class, 'index'])->name('search_index');
Route::post('/suche', [SearchController::class, 'index'])->name('search_index');
//Route::get('/search/export', [SearchController::class, 'export'])->name('search_export');

// Bookings
Route::get('/booking/{courseEvent}', [BookingController::class, 'add']);
Route::post('/booking/cancel/confirm', [BookingController::class, 'destroy'])->name('booking_cancel_confirm');
Route::get('/booking/cancel/{courseEvent}/{student}', [BookingController::class, 'cancel'])->name('booking_cancel_preview');
Route::post('/booking/register', [BookingController::class, 'registerAndStore']);
Route::post('/booking', [BookingController::class, 'store'])->middleware('role:student');
Route::delete('/booking/{courseEvent}', [BookingController::class, 'remove']);
Route::get('/bookings', [BookingController::class, 'get']);

// Student Login
Route::post('/auth/student/login', [LoginController::class, 'login'])->name('student_login');

// Student register
Route::get('/registration', [RegisterController::class, 'index'])->name('register_index');
Route::post('/registrieren', [RegisterController::class, 'store'])->middleware(ProtectAgainstSpam::class)->name('register_store');
Route::get('/registration/abgeschlossen', [RegisterController::class, 'registered'])->name('register_done');

/*
|--------------------------------------------------------------------------
| Admin Web routes
|--------------------------------------------------------------------------
|
*/

Route::middleware('auth:sanctum', 'verified')->group(function() {

  // Temp. Registration Symposium
  Route::get('/admin/jubilaeums-fachtagung-15-jahre-sipt', [SymposiumController::class, 'anniversaryAdmin']);
  Route::post('/admin/jubilaeums-fachtagung-15-jahre-sipt/registration', [SymposiumSubscriberController::class, 'store'])->middleware(ProtectAgainstSpam::class)->name('symposium_register');
  Route::get('/admin/jubilaeums-fachtagung-15-jahre-sipt/anmeldung-erfolgreich', [SymposiumController::class, 'registered'])->name('symposium_register_success');

  // Dev routes
  Route::get('/mask-user', [DevController::class, 'maskUser']);
  Route::get('/import-users', [DevController::class, 'importUser']);


  // Downloads for tutors / admins
  Route::get('/download/modulliste', [DownloadController::class, 'listCourses'])->middleware('role:tutor');
  Route::get('/download/teilnehmerliste/{courseEvent}', [DownloadController::class, 'listParticipants'])->middleware('role:admin');
  Route::get('/download/anwesenheitsliste/{courseEvent}', [DownloadController::class, 'listAttendances'])->middleware('role:tutor');
  Route::get('/download/fachtagung/teilnehmerliste', [DownloadController::class, 'listSymposiumParticipants'])->middleware('role:admin');
  Route::get('/export/fachtagung/teilnehmerliste', [DownloadController::class, 'exportSymposiumParticipants'])->middleware('role:admin');
  Route::get('/download/20-jahre-sipt/teilnehmerliste', [DownloadController::class, 'listAnniversaryParticipants'])->middleware('role:admin');
  Route::get('/export/20-jahre-sipt/teilnehmerliste', [DownloadController::class, 'exportAnniversaryParticipants'])->middleware('role:admin');
  Route::get('/export/adressliste/studenten', [DownloadController::class, 'exportStudentAddresses'])->middleware('role:admin');
  Route::get('/export/adressliste/dozenten', [DownloadController::class, 'exportTutorAddresses'])->middleware('role:admin');
  Route::get('/export/adressliste/vip', [DownloadController::class, 'exportVipAddresses'])->middleware('role:admin');

  // Downloads for students
  Route::get('/download/kursbestaetigung/{courseEvent}/{student?}', [DownloadController::class, 'confirmation'])->middleware('role:student');
  Route::get('/download/kurseinladung/{courseEvent}/{student?}', [DownloadController::class, 'invitation'])->middleware('role:student');
  Route::get('/download/kursuebersicht-alle/{student?}', [DownloadController::class, 'coursesOverview'])->middleware('role:student');
  Route::get('/download/kursuebersicht-absolviert/{student?}', [DownloadController::class, 'coursesAttended'])->middleware('role:student');

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
