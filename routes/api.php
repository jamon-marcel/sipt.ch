<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import API controllers
use App\Http\Controllers\Api\AdministratorController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\TutorController;
use App\Http\Controllers\Api\TutorImageController;
use App\Http\Controllers\Api\TrainingController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\MailingController;
use App\Http\Controllers\Api\MailingQueueController;
use App\Http\Controllers\Api\MailinglistController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\CourseEventController;
use App\Http\Controllers\Api\CourseEventDateController;
use App\Http\Controllers\Api\CourseEventFileController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\BackofficeController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\SymposiumSubscriberController;
use App\Http\Controllers\Api\VipAddressController;
use App\Http\Controllers\Api\DownloadController;
use App\Http\Controllers\Api\DownloadFileController;

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
  Route::get('administrator', [AdministratorController::class, 'find']);

  // Student routes
  Route::middleware('role:student')->group(function() {
    Route::get('students/{slim?}', [StudentController::class, 'get']);
    Route::post('student/store', [StudentController::class, 'store'])->middleware('role:admin');
    Route::get('student/{student?}', [StudentController::class, 'find']);
    Route::put('student/{student}', [StudentController::class, 'update']);
    Route::delete('student/{student}', [StudentController::class, 'destroy'])->middleware('role:admin');
    Route::post('student/course/event/{student?}', [StudentController::class, 'storeEvent']);
    Route::get('student/course/event/{courseEvent}/{student?}', [StudentController::class, 'getEvent']);
    Route::get('student/course/events/{type?}/{limit?}/{student?}', [StudentController::class, 'getEvents']);
    Route::get('student/course/event/withdraw/{courseEvent}/{student?}', [StudentController::class, 'withdrawEvent']);
    Route::delete('student/course/event/{courseEvent}/{student?}', [StudentController::class, 'destroyEvent']);
  });

  // Tutor routes
  Route::middleware('role:tutor')->group(function() {
    Route::get('tutors/{constraint?}', [TutorController::class, 'get']);
    Route::get('tutor/{tutor?}', [TutorController::class, 'find']);
    Route::post('tutor', [TutorController::class, 'store'])->middleware('role:admin');
    Route::put('tutor/{tutor}', [TutorController::class, 'update']);
    Route::get('tutor/state/{tutor}', [TutorController::class, 'toggle'])->middleware('role:admin');
    Route::delete('tutor/{tutor}', [TutorController::class, 'destroy'])->middleware('role:admin');
    Route::get('tutor/course/events/{type?}/{tutor?}', [TutorController::class, 'getEvents']);
    Route::get('tutor/course/event/{courseEvent}/{tutor?}', [TutorController::class, 'getEvent']);
    Route::get('tutor/image/state/{tutorImage}', [TutorImageController::class, 'toggle']);
    Route::delete('tutor/image/{tutorImage}', [TutorImageController::class, 'destroy']);
    Route::put('tutor/image/{tutorImage}', [TutorImageController::class, 'coords']);
  });

  // Training routes for students
  Route::middleware('role:student')->group(function() {
    Route::get('trainings', [TrainingController::class, 'get']);
    Route::get('training/{training}', [TrainingController::class, 'find']);
  });

  // Training routes for admins
  Route::middleware('role:admin')->group(function() {
    Route::post('training', [TrainingController::class, 'store']);
    Route::put('training/{training}', [TrainingController::class, 'update']);
    Route::delete('training/{training}', [TrainingController::class, 'destroy']);
    Route::get('training/state/{training}', [TrainingController::class, 'toggle']);
  });

  // Location routes
  Route::middleware('role:admin')->group(function() {
    Route::get('locations', [LocationController::class, 'get']);
    Route::get('location/{location}', [LocationController::class, 'find']);
    Route::post('location', [LocationController::class, 'store']);
    Route::put('location/{location}', [LocationController::class, 'update']);
    Route::delete('location/{location}', [LocationController::class, 'destroy']);
    Route::get('location/state/{location}', [LocationController::class, 'toggle']);
  });

  // Mailing routes
  Route::middleware('role:admin')->group(function() {
    Route::get('mailings', [MailingController::class, 'get']);
    Route::get('mailing/{mailing}', [MailingController::class, 'find']);
    Route::post('mailing', [MailingController::class, 'store']);
    Route::put('mailing/{mailing}', [MailingController::class, 'update']);
    Route::delete('mailing/{mailing}', [MailingController::class, 'destroy']);

    // MailingQueue
    Route::get('mailingqueue/{mailing}', [MailingQueueController::class, 'get']);
    Route::post('mailingqueue/preview', [MailingQueueController::class, 'preview']);
    Route::post('mailingqueue/store', [MailingQueueController::class, 'store']);
    Route::delete('mailingqueue/entry/{mailingQueueItem}', [MailingQueueController::class, 'destroyEntry']);
    Route::delete('mailingqueue/batch/{mailingQueue}', [MailingQueueController::class, 'destroyBatch']);
  });

  // Mailinglists
  Route::get('mailinglists/{subscriberCount?}', [MailinglistController::class, 'get']);
  Route::get('mailinglists/subscriptions/{email}', [MailinglistController::class, 'getSubscriptions']);
  Route::post('mailinglist', [MailinglistController::class, 'addSubscription']);
  Route::delete('mailinglist/{mailinglistSubscriber}', [MailinglistController::class, 'deleteSubscription']);

  // Course routes
  Route::get('courses', [CourseController::class, 'get']);
  Route::get('course/{course}', [CourseController::class, 'find']);
  Route::post('course/create', [CourseController::class, 'store'])->middleware('role:admin');
  Route::put('course/{course}', [CourseController::class, 'update'])->middleware('role:admin');
  Route::get('course/state/{course}', [CourseController::class, 'toggle'])->middleware('role:admin');
  Route::delete('course/{course}', [CourseController::class, 'destroy'])->middleware('role:admin');
  Route::get('courses/by/training/{training}', [CourseController::class, 'getByTraining']);
  Route::get('course/with/events/{course}', [CourseController::class, 'getWithEvents']);

  // CourseEvents routes
  Route::get('course/events/fetch/{constraint?}', [CourseEventController::class, 'fetch']);
  Route::get('course/events/{course}', [CourseEventController::class, 'get']);
  Route::get('course/event/{courseEvent}', [CourseEventController::class, 'find']);
  Route::post('course/event', [CourseEventController::class, 'store'])->middleware('role:admin');
  Route::put('course/event/{courseEvent}', [CourseEventController::class, 'update'])->middleware('role:admin');
  Route::get('course/event/state/{courseEvent}', [CourseEventController::class, 'toggle'])->middleware('role:admin');
  Route::get('course/event/cancel/{courseEvent}', [CourseEventController::class, 'cancel']);
  Route::get('course/event/close/{courseEvent}', [CourseEventController::class, 'close']);
  Route::get('course/event/open/{courseEvent}', [CourseEventController::class, 'open']);
  Route::delete('course/event/{courseEvent}', [CourseEventController::class, 'destroy'])->middleware('role:admin');
  Route::get('course/events/by/course/{course}', [CourseEventController::class, 'getByCourse']);

  // CoursesEventDates routes
  Route::delete('course/event/date/{courseEventDate}', [CourseEventDateController::class, 'destroy'])->middleware('role:admin');

  // CourseEventFiles routes
  Route::middleware('role:tutor')->group(function() {
    Route::post('course/event/files', [CourseEventFileController::class, 'store']);
    Route::delete('course/event/file/{courseEventFile}', [CourseEventFileController::class, 'destroy']);
  });

  // Message routes
  Route::get('messages/{courseEvent}', [MessageController::class, 'get']);
  Route::get('message/{message}', [MessageController::class, 'find']);
  Route::post('message', [MessageController::class, 'store'])->middleware('role:tutor');

  // Settings
  Route::middleware('role:admin')->group(function() {
    Route::get('settings/locations', [SettingsController::class, 'locations']);
    Route::get('settings/training/categories', [SettingsController::class, 'trainingCategories']);
    Route::get('settings/specialisations', [SettingsController::class, 'specialisations']);
  });

  // Users
  Route::get('user/student', [UserController::class, 'student'])->middleware('role:student');
  Route::get('user/tutor', [UserController::class, 'tutor'])->middleware('role:tutor');
  Route::get('user/admin', [UserController::class, 'admin'])->middleware('role:admin');
  Route::post('user/email', [UserController::class, 'updateEmail']);
  Route::post('user/password', [UserController::class, 'updatePassword']);
  Route::post('user/tutor/register', [UserController::class, 'register'])->middleware('role:admin');

  // Upload routes
  Route::middleware('role:tutor')->group(function() {
    Route::post('image/upload', [UploadController::class, 'image']);
    Route::post('file/upload', [UploadController::class, 'file']);
  });

  // Backoffice
  Route::middleware('role:admin')->group(function() {
    Route::get('backoffice/courses/list/concluded', [BackofficeController::class, 'getConcludedCourses']);
    Route::get('backoffice/courses/list/closed', [BackofficeController::class, 'getClosedCourses']);
    Route::get('backoffice/student/attendance/{student}/{courseEvent}', [BackofficeController::class, 'setAttendance']);
    Route::get('backoffice/student/bookings/{student}', [BackofficeController::class, 'getBookings']);
    Route::get('backoffice/course/event/{courseEvent}', [BackofficeController::class, 'getCourseEvent']);
    Route::get('backoffice/course/by/number/{courseNumber}', [BackofficeController::class, 'getCourseByNumber']);
    Route::delete('backoffice/course/event/student/{courseEvent}/{student}', [BackofficeController::class, 'destroyCourseEventStudent']);
    Route::post('backoffice/course/event/add/student', [BackofficeController::class, 'addCourseEventStudent']);
    Route::get('backoffice/invoices/{constraint?}', [InvoiceController::class, 'get']);
    Route::get('backoffice/invoice/history/{invoice}', [InvoiceController::class, 'getHistory']);
    Route::get('backoffice/invoices', [InvoiceController::class, 'get']);
    Route::get('backoffice/invoice/{invoice}', [InvoiceController::class, 'find']);
    Route::put('backoffice/invoice/state/{invoice}', [InvoiceController::class, 'state']);
    Route::put('backoffice/invoice/cancel/{invoice}', [InvoiceController::class, 'cancel']);
    Route::get('backoffice/invoice/notice/{invoice}/{noticeType}', [InvoiceController::class, 'notice']);
    Route::post('backoffice/invoice/edit', [BackofficeController::class, 'editInvoice']);
    Route::post('backoffice/invoice/store', [BackofficeController::class, 'createInvoice']);
    Route::post('backoffice/invoice/manual/store', [BackofficeController::class, 'createManualInvoice']);
    Route::post('backoffice/import', [BackofficeController::class, 'import']);
  });

  // Symposium routes
  Route::middleware('role:admin')->group(function() {
    Route::get('symposium/subscribers', [SymposiumSubscriberController::class, 'get']);
    Route::get('symposium/{symposiumSubscriber?}', [SymposiumSubscriberController::class, 'find']);
    Route::post('symposium/subscribe', [SymposiumSubscriberController::class, 'store']);
    Route::put('symposium/{symposiumSubscriber}', [SymposiumSubscriberController::class, 'update']);
    Route::delete('symposium/{symposiumSubscriber}', [SymposiumSubscriberController::class, 'cancel']);
  });

  // Vip address routes
  Route::middleware('role:admin')->group(function() {
    Route::get('vip-addresses', [VipAddressController::class, 'get']);
    Route::get('vip-address/{vipAddress}', [VipAddressController::class, 'find']);
    Route::post('vip-address', [VipAddressController::class, 'store']);
    Route::put('vip-address/{vipAddress}', [VipAddressController::class, 'update']);
    Route::delete('vip-address/{vipAddress}', [VipAddressController::class, 'destroy']);
  });

  // News routes
  Route::middleware('role:admin')->group(function() {
    Route::get('news/articles', [App\Http\Controllers\Api\NewsArticleController::class, 'get']);
    Route::put('/news/articles/order/{category}', [App\Http\Controllers\Api\NewsArticleController::class, 'order']);
    Route::get('news/article/{newsArticle}', [App\Http\Controllers\Api\NewsArticleController::class, 'find']);
    Route::post('news/article', [App\Http\Controllers\Api\NewsArticleController::class, 'store']);
    Route::get('news/article/state/{newsArticle}', [App\Http\Controllers\Api\NewsArticleController::class, 'toggle']);
    Route::put('news/article/{newsArticle}', [App\Http\Controllers\Api\NewsArticleController::class, 'update']);
    Route::delete('news/article/{newsArticle}', [App\Http\Controllers\Api\NewsArticleController::class, 'destroy']);

    Route::get('news/categories', [App\Http\Controllers\Api\NewsCategoryController::class, 'get']);
    Route::post('news/category', [App\Http\Controllers\Api\NewsCategoryController::class, 'store']);
    Route::post('news/categories/order', [App\Http\Controllers\Api\NewsCategoryController::class, 'order']);
    Route::get('news/category/state/{newsCategory}', [App\Http\Controllers\Api\NewsCategoryController::class, 'toggle']);
    Route::put('news/category/{newsCategory}', [App\Http\Controllers\Api\NewsCategoryController::class, 'update']);
    Route::delete('news/category/{newsCategory}', [App\Http\Controllers\Api\NewsCategoryController::class, 'destroy']);
  });

  // Search address routes
  Route::middleware('role:admin')->group(function() {
    Route::post('search-address', [App\Http\Controllers\Api\SearchAddressController::class, 'search']);
  });

  // Downloads routes
  Route::middleware('role:admin')->group(function() {
    Route::get('downloads', [DownloadController::class, 'get']);
    Route::get('download/{download}', [DownloadController::class, 'find']);
    Route::post('download', [DownloadController::class, 'store']);
    Route::put('download/{download}', [DownloadController::class, 'update']);
    Route::put('downloads/order', [DownloadController::class, 'order']);
    Route::get('download/state/{download}', [DownloadController::class, 'toggle']);
    Route::delete('download/{download}', [DownloadController::class, 'destroy']);
    Route::delete('download/file/temp', [DownloadFileController::class, 'deleteUpload']);
    Route::delete('download/file/{download}', [DownloadFileController::class, 'delete']);
  });

});
