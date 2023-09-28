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
use App\Http\Controllers\TasksController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RecordController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HoursController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\NotificationController;
use App\Models\AcademicYear;
use App\Models\Activity;
use App\Http\Livewire\Notifications;
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




Auth::routes();


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('homepage');
//Route::get('/user/{id}', [Monitoring::class, 'show'])->name('user.show');
Route::get('/createproject', [ProjectController::class, 'getMembers'])->name('get.members');
//Route::get('/user/{id}/selectproject/{projectid}', [ProjectController::class, 'getobjectives'])->name('get.objectives');
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
Route::post('/completeactivity', [ActivityController::class, 'completeactivity'])->name('activity.complete');
//Route::get('/user/{id}/getactivity/{activityid}', [ProjectController::class, 'getactivity'])->name('get.activity');
Route::post('/addsubtask', [SubtaskController::class, 'addsubtask'])->name('add.subtask');






//Route::get('/user/{id}/getactivity/{activityid}/getsubtask/{subtaskid}', [ActivityController::class, 'getsubtask'])->name('get.subtask');

Route::get('download/{contributionid}/{filename}', [FileController::class, 'download'])->name('download.file');
Route::get('downloadactivity/{actcontributionid}/{filename}', [FileController::class, 'downloadactivity'])->name('downloadactivity.file');
Route::get('downloadoutput/{submittedoutputid}/{filename}', [FileController::class, 'downloadoutput'])->name('downloadoutput.file');

Route::prefix('{username}')->group(function () {
    Route::get('/home', [TasksController::class, 'showtasks'])->name('tasks.show');
    Route::get('/duties/{currentYear}', [TasksController::class, 'showacadtasks'])->name('acadtasks.show');
    Route::get('/records', [RecordController::class, 'showrecords'])->name('records.show');
});

Route::get('/selectrecords/{username}/{ayid}/{semester}', [RecordController::class, 'selectrecords'])->name('records.select');


Route::prefix('/subtasks')->group(function () {
    Route::get('/{subtaskid}/{subtaskname}', [SubtaskController::class, 'displaysubtask'])->name('subtasks.display');
    Route::get('/{subtaskid}/{subtaskname}/complysubtask', [SubtaskController::class, 'complysubtask'])->name('comply.subtask');
    Route::post('/accepthours', [SubtaskController::class, 'accepthours'])->name('hours.accept');
    Route::post('/addsubtaskassignee', [SubtaskController::class, 'addsubtaskassignee'])->name('add.subtaskassignee');
    Route::post('/addtosubtask', [SubtaskController::class, 'addtosubtask'])->name('addto.subtask');
});

Route::prefix('/activities')->group(function () {
    Route::get('/{activityid}/{department}/{activityname}', [ActivityController::class, 'displayactivity'])->name('activities.display');
    Route::post('/acceptoutput', [OutputController::class, 'acceptoutput'])->name('output.accept');
    Route::post('/markcomplete', [ActivityController::class, 'markcomplete'])->name('activity.markcomplete');
    Route::post('/addassignee', [ActivityController::class, 'addassignee'])->name('add.assignee');
    Route::post('/unassignassignee', [ActivityController::class, 'unassignassignee'])->name('unassign.assignee');
    Route::post('/setnosubtask', [ActivityController::class, 'setnosubtask'])->name('set.nosubtask');
    Route::get('/{activityid}/{department}/{activityname}/complyactivity', [ActivityController::class, 'complyactivity'])->name('comply.activity');
    Route::post('/addtoactivity', [ActivityController::class, 'addtoactivity'])->name('addto.activity');
});

Route::prefix('/participationhours')->group(function () {

    Route::get('/{activityid}/{activityname}', [HoursController::class, 'displayhours'])->name('hours.display');
    Route::post('/acceptacthours', [HoursController::class, 'acceptacthours'])->name('acthours.accept');
});

Route::prefix('/projects')->group(function () {
    Route::prefix('/{department}')->group(function () {
        Route::get('/allprojects', [ProjectController::class, 'showproject'])
            ->name('project.show');

        Route::get('/allprojects/{currentyear}', [ProjectController::class, 'showyearproject'])
            ->name('yearproject.show');
    });


    Route::get('/newproject', [ProjectController::class, 'newproject'])
        ->name('projects.new');
});
Route::get('/display/{projectid}/{department}', [ProjectController::class, 'displayproject'])
    ->name('projects.display');
Route::get('/calendar/{projectid}/{department}', [ProjectController::class, 'displayActivityCalendar'])
    ->name('projects.calendar');
Route::get('/members/{projectid}/{department}', [ProjectController::class, 'displayMembers'])
    ->name('projects.members');
Route::get('/details/{projectid}/{department}', [ProjectController::class, 'displayDetails'])
    ->name('projects.details');
Route::get('/objectives/{projectid}/{department}', [ProjectController::class, 'displayObjectives'])
    ->name('projects.objectives');
Route::get('/activities/{projectid}/{department}', [ProjectController::class, 'displayActivities'])
    ->name('projects.activities');

Route::prefix('/projectinsights')->group(function () {
    Route::get('/{department}/select', [ReportController::class, 'showinsights'])->name('insights.show');
    Route::get('/{projectid}/{department}/{projectname}', [ReportController::class, 'indexinsights'])->name('insights.index');
});
Route::prefix('/output')->group(function () {
    Route::get('/{activityid}/{outputtype}', [ActivityController::class, 'getoutput'])->name('get.output');
    Route::get('/{activityid}/{outputtype}/complyoutput', [OutputController::class, 'complyoutput'])->name('comply.output');
    Route::post('/addoutput', [OutputController::class, 'addoutput'])->name('add.output');
    Route::post('/addtooutput', [OutputController::class, 'addtooutput'])->name('addto.output');
});


Route::get('/setacademicyear', [AcademicYearController::class, 'setacadyear'])->name('acadyear.set');
Route::post('/saveacademicyear', [AcademicYearController::class, 'saveacadyear'])->name('acadyear.save');

Route::prefix('/submission')->group(function () {
    Route::get('/{submissionid}/{submissionname}', [SubmissionController::class, 'displaysubmission'])->name('submission.display');
});
Route::prefix('/actsubmission')->group(function () {
    Route::get('/{actsubmissionid}/{actsubmissionname}', [SubmissionController::class, 'displayactsubmission'])->name('actsubmission.display');
});
Route::get('submittedoutput/{submittedoutputid}/{outputtype}/{submissionname}', [SubmissionController::class, 'displaysubmittedoutput'])->name('submittedoutput.display');
Route::get('/mark-notification-as-read/{id}', [NotificationController::class, 'markasread'])->name('notification.markasread');
