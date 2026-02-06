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

// Profile Route (Placeholder)
Route::get('/profile', [HomeController::class, 'index'])->name('profile.show');

Route::get('/', [FrontController::class, 'index'])->name('index');
Route::get('/up-comming-events', [FrontController::class, 'events'])->name('event');
Route::get('/event/{id}', [FrontController::class, 'eventSingle'])->name('event.single');
Route::post('/event/{event}/register', [App\Http\Controllers\EventRegistrationController::class, 'store'])->name('event.register');
Route::get('/contact-us', [FrontController::class, 'contact'])->name('contact');
Route::get('/about', [FrontController::class, 'about'])->name('about');
Route::get('/live', [FrontController::class, 'live'])->name('live');
Route::get('/calendar', [FrontController::class, 'calendar'])->name('calendar');
Route::get('/api/calendar-events', [FrontController::class, 'getEvents'])->name('calendar.events');

// Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'admin'])->name('home');
    Route::resource('events', App\Http\Controllers\Admin\EventController::class);
    Route::get('events/{event}/registrations', [App\Http\Controllers\Admin\EventRegistrationController::class, 'index'])->name('admin.event.registrations');
    Route::put('event-registrations/{registration}', [App\Http\Controllers\Admin\EventRegistrationController::class, 'updateStatus'])->name('admin.event.registrations.update');
    Route::delete('event-registrations/{registration}', [App\Http\Controllers\Admin\EventRegistrationController::class, 'destroy'])->name('admin.event.registrations.destroy');
    Route::resource('courses', App\Http\Controllers\Admin\CourseController::class);
    Route::resource('modules', App\Http\Controllers\Admin\ModuleController::class);
    Route::resource('lessons', App\Http\Controllers\Admin\LessonController::class);
    Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    Route::get('courses/{course}/content', [App\Http\Controllers\Admin\CourseController::class, 'content'])->name('courses.content');
    
    Route::get('/livestream', [App\Http\Controllers\Admin\LiveStreamController::class, 'index'])->name('livestream.index');
    Route::post('/livestream', [App\Http\Controllers\Admin\LiveStreamController::class, 'update'])->name('livestream.update');

    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings.index');
    Route::post('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('admin.settings.update');
    
    // Finance & Donations
    Route::get('/finance', [App\Http\Controllers\Admin\FinanceController::class, 'index'])->name('admin.finance.index');
    Route::get('/donations', [App\Http\Controllers\Admin\DonationController::class, 'index'])->name('admin.donations.index');
    Route::get('/donations/{donation}', [App\Http\Controllers\Admin\DonationController::class, 'show'])->name('admin.donations.show');
    
    // Digital Account Book (Ledger)
    Route::get('/finance/ledger', [App\Http\Controllers\Admin\FinancialRecordController::class, 'index'])->name('admin.finance.ledger');
    Route::get('/finance/ledger/create', [App\Http\Controllers\Admin\FinancialRecordController::class, 'create'])->name('admin.finance.ledger.create');
    Route::post('/finance/ledger', [App\Http\Controllers\Admin\FinancialRecordController::class, 'store'])->name('admin.finance.ledger.store');
    Route::delete('/finance/ledger/{record}', [App\Http\Controllers\Admin\FinancialRecordController::class, 'destroy'])->name('admin.finance.ledger.destroy');
    
    // Products & Books
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);
    Route::resource('books', App\Http\Controllers\Admin\BookController::class)->names([
        'index' => 'admin.books.index',
        'create' => 'admin.books.create',
        'store' => 'admin.books.store',
        'edit' => 'admin.books.edit',
        'update' => 'admin.books.update',
        'destroy' => 'admin.books.destroy',
    ]);

    // Chapters Management
    Route::post('books/{book}/chapters', [App\Http\Controllers\Admin\BookController::class, 'storeChapter'])->name('admin.books.chapters.store');
    Route::get('chapters/{chapter}', [App\Http\Controllers\Admin\BookController::class, 'getChapter'])->name('admin.books.chapters.show');
    Route::put('chapters/{chapter}', [App\Http\Controllers\Admin\BookController::class, 'updateChapter'])->name('admin.books.chapters.update');
    Route::delete('chapters/{chapter}', [App\Http\Controllers\Admin\BookController::class, 'deleteChapter'])->name('admin.books.chapters.destroy');
    Route::post('books/chapters/reorder', [App\Http\Controllers\Admin\BookController::class, 'reorderChapters'])->name('admin.books.chapters.reorder');

    // Library Settings
    Route::get('/library/settings', [App\Http\Controllers\Admin\BookController::class, 'settings'])->name('admin.library.settings');
    Route::post('/library/settings', [App\Http\Controllers\Admin\BookController::class, 'updateSettings'])->name('admin.library.settings.update');

    // Meeting Management
    Route::get('/meetings-management', [App\Http\Controllers\Admin\MeetingController::class, 'index'])->name('admin.meetings.index');
    Route::post('/meetings/{meeting}/end', [App\Http\Controllers\Admin\MeetingController::class, 'end'])->name('admin.meetings.end');
    Route::delete('/meetings/{meeting}', [App\Http\Controllers\Admin\MeetingController::class, 'destroy'])->name('admin.meetings.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/academy/dashboard', [App\Http\Controllers\StudentController::class, 'index'])->name('student.dashboard');
Route::get('/academy/schedule', [App\Http\Controllers\StudentController::class, 'schedule'])->name('student.schedule');
    Route::get('/course/{course}/learn', [App\Http\Controllers\StudentController::class, 'learn'])->name('student.course.learn');
    
    // Meeting Routes
    Route::get('/meetings', [App\Http\Controllers\MeetingController::class, 'index'])->name('meeting.index');
    Route::get('/meeting/create', [App\Http\Controllers\MeetingController::class, 'create'])->name('meeting.create');
    Route::post('/meeting', [App\Http\Controllers\MeetingController::class, 'store'])->name('meeting.store');
    Route::get('/meeting/{code}', [App\Http\Controllers\MeetingController::class, 'room'])->name('meeting.room');
    Route::post('/meeting/{meeting}/end', [App\Http\Controllers\MeetingController::class, 'end'])->name('meeting.end');
    
    // Booking Routes
    Route::get('/instructor/{id}', [App\Http\Controllers\StudentController::class, 'instructorProfile'])->name('instructor.profile');
    Route::post('/meeting/book', [App\Http\Controllers\MeetingController::class, 'book'])->name('meeting.book');
});

// Store Routes
Route::get('/store', [App\Http\Controllers\StoreController::class, 'index'])->name('store.index');
Route::get('/store/product/{slug}', [App\Http\Controllers\StoreController::class, 'show'])->name('store.show');
Route::get('/cart', [App\Http\Controllers\StoreController::class, 'cart'])->name('cart.index');
Route::post('/add-to-cart/{id}', [App\Http\Controllers\StoreController::class, 'addToCart'])->name('cart.add');
Route::get('/checkout', [App\Http\Controllers\StoreController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [App\Http\Controllers\StoreController::class, 'processCheckout'])->name('checkout.process');

// Library Routes
Route::get('/library', [App\Http\Controllers\LibraryController::class, 'index'])->name('library.index');
Route::get('/library/read/{slug}', [App\Http\Controllers\LibraryController::class, 'read'])->name('library.read');
Route::get('/library/chapter/{id}', [App\Http\Controllers\LibraryController::class, 'getChapterContent'])->name('library.chapter.show');
Route::post('/library/book/{book}/progress', [App\Http\Controllers\LibraryController::class, 'updateProgress'])->name('library.progress.update');

// Donation Routes
Route::get('/donate', [App\Http\Controllers\DonationController::class, 'index'])->name('donate');
Route::post('/donate', [App\Http\Controllers\DonationController::class, 'store'])->name('donate.store');
Route::get('/donate/thank-you', [App\Http\Controllers\DonationController::class, 'thankYou'])->name('donate.thank-you');

