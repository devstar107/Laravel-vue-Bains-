<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/job-application',[App\Http\Controllers\JobController::class,'jobApplication'])->name('job-application');
Route::post('/job-application',[App\Http\Controllers\JobController::class,'saveJobApplication'])->name('job-post-application');
Route::get('/view',[App\Http\Controllers\JobController::class,'view'])->name('view-job-application');
Route::get('/deny-app/{id}',[App\Http\Controllers\JobController::class,'denyApp'])->name('deny-app');
Route::get('/approve-app/{id}',[App\Http\Controllers\JobController::class,'approveApp'])->name('approve-app');
Route::get('/view-job-application',[App\Http\Controllers\JobController::class,'view_ajax'])->name('view-ajax-job-application');


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
