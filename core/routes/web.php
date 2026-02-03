<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontController;

// Route::get('/', function () {
//     return view('frontend.pages.index');
// })->name('index');

Auth::routes();

// Social Auth Routes
Route::get('auth/google', [App\Http\Controllers\Auth\SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\SocialAuthController::class, 'handleGoogleCallback']);

Route::get('/', [FrontController::class, 'index'])->name('index');
Route::get('/up-comming-events', [FrontController::class, 'events'])->name('event');
Route::get('/event/{id}', [FrontController::class, 'eventSingle'])->name('event.single');
Route::get('/contact-us', [FrontController::class, 'contact'])->name('contact');
Route::get('/about', [FrontController::class, 'about'])->name('about');
Route::get('/live', [FrontController::class, 'live'])->name('live');
Route::get('/calendar', [FrontController::class, 'calendar'])->name('calendar');
Route::get('/api/calendar-events', [FrontController::class, 'getEvents'])->name('calendar.events');

// Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'admin'])->name('home');
    Route::resource('events', App\Http\Controllers\Admin\EventController::class);
    Route::resource('courses', App\Http\Controllers\Admin\CourseController::class);
    Route::resource('modules', App\Http\Controllers\Admin\ModuleController::class);
    Route::resource('lessons', App\Http\Controllers\Admin\LessonController::class);
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::get('courses/{course}/content', [App\Http\Controllers\Admin\CourseController::class, 'content'])->name('courses.content');
    
    Route::get('/livestream', [App\Http\Controllers\Admin\LiveStreamController::class, 'index'])->name('livestream.index');
    Route::post('/livestream', [App\Http\Controllers\Admin\LiveStreamController::class, 'update'])->name('livestream.update');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/my-courses', [App\Http\Controllers\StudentController::class, 'index'])->name('student.courses');
    Route::get('/course/{course}/learn', [App\Http\Controllers\StudentController::class, 'learn'])->name('student.course.learn');
});
