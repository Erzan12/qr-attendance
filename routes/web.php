<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\EventParticipantController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
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

Auth::routes();
Route::middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::view('about', 'about')->name('about');
    Route::resource('events', EventController::class);
    Route::resource('students', StudentController::class);
    Route::resource('faculties', FacultyController::class);
    Route::get('/faculties/{faculty}/qrcode', [FacultyController::class, 'qrcode'])->name('faculties.qr');
    Route::get('/students/{student}/qrcode', [StudentController::class, 'qrcode'])->name('students.qr');
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('profile/password', [ProfileController::class, 'showPassword'])->name('profile.password-show');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password-update');
    Route::get('events/{event}/participants', [EventParticipantController::class, 'index'])->name('event-participants.index');
    Route::delete('events/{event}/participants', [EventParticipantController::class, 'destroy'])->name('event-participants.destroy');
});

Route::get('/offline', function () {
    return view('vendor/laravelpwa/offline'); 
});