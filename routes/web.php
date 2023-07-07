<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Monitoring;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OutputController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\SubtaskController;

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
Auth::routes();
Route::get('/user/{id}/project', [ProjectController::class, 'showproject'])->name('project.show');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/user/{id}', [Monitoring::class, 'show'])->name('user.show');
Route::get('/createproject', [ProjectController::class, 'getMembers'])->name('get.members');
Route::get('/user/{id}/selectproject/{projectid}', [ProjectController::class, 'getobjectives'])->name('get.objectives');
Route::POST('/saveproject', [ProjectController::class, 'store'])->name('project.store');
Route::POST('/saveactivity', [ActivityController::class, 'storeactivity'])->name('activity.store');
Route::POST('/savesubtask', [ActivityController::class, 'storesubtask'])->name('subtask.store');
Route::get('/user/{id}/manageaccount', [AdminController::class, 'manageaccount'])->name('admin.manage');
Route::get('/user/{id}/approveaccount', [AdminController::class, 'approveaccount'])->name('admin.approve');
Route::POST('/acceptaccount', [AdminController::class, 'acceptaccount'])->name('admin.accept');
Route::POST('/declineaccount', [AdminController::class, 'declineaccount'])->name('admin.decline');
Route::POST('/deleteaccount', [AdminController::class, 'deleteaccount'])->name('admin.delete');
Route::POST('/addaccount', [AdminController::class, 'addaccount'])->name('admin.add');
Route::post('/submitoutput', [OutputController::class, 'submitoutput'])->name('output.submit');
Route::post('/upload', [FileController::class, 'upload'])->name('upload.file');
Route::post('/submithoursrendered', [SubtaskController::class, 'submithoursrendered'])->name('hoursrendered.submit');
