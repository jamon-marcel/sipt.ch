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

  // Students
  Route::get('students', 'Api\StudentController@index');
  Route::get('student/{student}', 'Api\StudentController@show');
  Route::get('student/edit/{student}', 'Api\StudentController@edit');
  Route::post('student/update/{student}', 'Api\StudentController@update');

  // Tutors
  
  // Trainings
  Route::get('trainings', 'Api\TrainingController@index');
  Route::get('training/{training}', 'Api\TrainingController@show');
  Route::get('training/edit/{training}', 'Api\TrainingController@edit');
  Route::post('training/create', 'Api\TrainingController@store');
  Route::post('training/update/{training}', 'Api\TrainingController@update');
  Route::get('training/toggle/{training}', 'Api\TrainingController@toggle');
  Route::delete('training/destroy/{training}', 'Api\TrainingController@destroy');

});
