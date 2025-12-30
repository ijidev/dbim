<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontController;

// Route::get('/', function () {
//     return view('frontend.pages.index');
// })->name('index');

Auth::routes();

Route::get('/', [FrontController::class, 'index'])->name('index');
Route::get('/up-comming-events', [FrontController::class, 'events'])->name('event');
Route::get('/event', [FrontController::class, 'eventSingle'])->name('event.single');
Route::get('/contact-us', [FrontController::class, 'contact'])->name('contact');
Route::get('/about', [FrontController::class, 'about'])->name('about');

Route::get('/dashboard', [HomeController::class, 'admin'])->name('home');

// Route::get('/', [HomeController::class, 'index'])->name('home');
