<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\Monitoring;
use App\Http\Controllers\ActivityController;

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
Route::get('/project/{id}', [ProjectController::class, 'showproject'])->name('project.show');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/user/{id}', [Monitoring::class, 'show'])->name('user.show');
Route::get('/createproject', [ProjectController::class, 'getMembers'])->name('get.members');
Route::get('/project/{id}/selectproject/{projectid}', [ProjectController::class, 'getobjectives'])->name('get.objectives');
Route::POST('/saveproject', [ProjectController::class, 'store'])->name('project.store');
Route::POST('/saveactivity', [ActivityController::class, 'storeactivity'])->name('activity.store');
Route::POST('/savesubtask', [ActivityController::class, 'storesubtask'])->name('subtask.store');
