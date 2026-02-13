<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\InstructorStudentController;
use App\Http\Controllers\QuizController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Reconstructed based on Controller methods and previous functionality.
|
*/

// Auth Routes - Explicit Definition
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Other auth routes are usually register, password reset, etc.
// For now let's just make sure login works.
if (class_exists(App\Http\Controllers\Auth\RegisterController::class)) {
    Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
}

// Password Reset Routes
if (class_exists(App\Http\Controllers\Auth\ForgotPasswordController::class)) {
    Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
}

// Email Verification Routes
if (class_exists(App\Http\Controllers\Auth\VerificationController::class)) {
    Route::get('email/verify', [App\Http\Controllers\Auth\VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [App\Http\Controllers\Auth\VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])->name('verification.resend');
}

// Social Auth Routes
if (class_exists(App\Http\Controllers\Auth\SocialAuthController::class)) {
    Route::get('auth/google', [App\Http\Controllers\Auth\SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [App\Http\Controllers\Auth\SocialAuthController::class, 'handleGoogleCallback']);
}


// Public Routes
Route::controller(FrontController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/events', 'events')->name('events.index');
    Route::get('/events/{id}', 'eventSingle')->name('event.single');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/about', 'about')->name('about');
    Route::get('/live', 'live')->name('live');
    Route::get('/calendar', 'calendar')->name('calendar');
    Route::get('/events/get', 'getEvents')->name('events.get');
});

// Store Routes
Route::controller(App\Http\Controllers\StoreController::class)->group(function () {
    Route::get('/store', 'index')->name('store.index');
    Route::get('/store/cart', 'cart')->name('store.cart');
    Route::post('/store/cart/add/{id}', 'addToCart')->name('store.cart.add');
    Route::get('/store/checkout', 'checkout')->name('store.checkout');
    Route::post('/store/checkout', 'processCheckout')->name('store.checkout.process');
    Route::get('/store/{slug}', 'show')->name('store.show');
});

// Donation Routes
Route::controller(App\Http\Controllers\DonationController::class)->group(function () {
    Route::get('/donate', 'index')->name('donate');
    Route::post('/donate', 'store')->name('donate.store');
    Route::get('/donate/thank-you', 'thankYou')->name('donate.thank-you');
});


// Library Routes (Public for index, Auth for specific actions likely)
Route::controller(LibraryController::class)->group(function () {
    Route::get('/library', 'index')->name('library.index');
    Route::get('/read/{slug}', 'read')->name('library.read');
    Route::post('/library/progress/{book}', 'updateProgress')->name('library.progress');
    Route::get('/chapter/{id}', 'getChapterContent')->name('library.chapter');
});

// Auth Middleware Group
Route::middleware([
    'auth',
    'verified',
])->group(function () {
    
    Route::get('/dashboard', [StudentController::class, 'index'])->name('student.dashboard');

    // Student Routes
    Route::controller(StudentController::class)->group(function () {
        Route::get('/schedule', 'schedule')->name('student.schedule');
        Route::get('/learn/{id}', 'learn')->name('student.course.learn');
        Route::get('/catalog', 'catalog')->name('student.catalog');
        Route::get('/course/{id}/{slug?}', 'courseShow')->name('student.course.show');
        Route::post('/course/{id}/enroll', 'enroll')->name('student.course.enroll');
        Route::get('/course/{id}/checkout', 'courseCheckout')->name('student.course.checkout');
        Route::post('/course/{id}/process-payment', 'processCoursePayment')->name('student.course.payment');
        
        Route::post('/book-meeting', 'bookMeeting')->name('student.book.meeting');
        Route::get('/my-bookings', 'myBookings')->name('student.bookings');
        Route::get('/session/booked/{id}', 'sessionBooked')->name('student.session.booked');
        
        Route::get('/my-learning', 'myLearning')->name('student.learning');
        Route::get('/profile', 'profile')->name('student.profile');
        
        Route::get('/settings', 'settings')->name('student.settings');
        Route::post('/settings/update', 'updateSettings')->name('student.settings.update');
        Route::post('/password/update', 'updatePassword')->name('student.password.update');
        
        Route::post('/quiz/{id}/submit', 'submitQuiz')->name('student.quiz.submit');
    });

    // Meeting Routes
    Route::controller(MeetingController::class)->prefix('meeting')->name('meeting.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/room/{code}', 'room')->name('room');
        Route::post('/{meeting}/end', 'end')->name('end');
        Route::post('/book', 'book')->name('book');
    });

    // Instructor Routes
    Route::middleware(['role:instructor'])->prefix('instructor')->name('instructor.')->group(function () {
        Route::get('/dashboard', [InstructorController::class, 'index'])->name('dashboard');
        
         // Students Management
        Route::get('/students', [InstructorStudentController::class, 'index'])->name('students.index');
        Route::get('/students/export', [InstructorStudentController::class, 'export'])->name('students.export');

        // Quiz Management
        Route::controller(QuizController::class)->prefix('quizzes')->name('quizzes.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::get('/builder', 'create')->name('create_step1'); // Builder view
            Route::post('/', 'store')->name('store');
            Route::get('/{quiz}/edit', 'edit')->name('edit');
            Route::put('/{quiz}', 'update')->name('update');
            Route::delete('/{quiz}', 'destroy')->name('destroy');
        });
        
        // Course Management
        Route::controller(App\Http\Controllers\InstructorCourseController::class)->group(function () {
            Route::get('/courses', 'index')->name('courses.index');
            Route::get('/courses/create', 'create')->name('courses.create');
            Route::post('/courses', 'store')->name('courses.store');
            Route::get('/courses/{course}/edit', 'edit')->name('courses.edit');
            Route::put('/courses/{course}', 'update')->name('courses.update');
            Route::get('/courses/{course}/content', 'content')->name('courses.content');
            Route::delete('/courses/{course}', 'destroy')->name('courses.destroy');
        });

        // Module Management
        Route::post('/modules', [InstructorModuleController::class, 'store'])->name('modules.store');
        Route::delete('/modules/{module}', [InstructorModuleController::class, 'destroy'])->name('modules.destroy');

        // Lesson Management
        Route::post('/lessons', [InstructorLessonController::class, 'store'])->name('lessons.store');
        Route::delete('/lessons/{lesson}', [InstructorLessonController::class, 'destroy'])->name('lessons.destroy');
    });

    // Student Instructor View Routes (Moved down to avoid shadowing instructor/dashboard)
    Route::controller(StudentController::class)->group(function () {
        Route::get('/instructors', 'instructors')->name('student.instructors');
        Route::get('/instructor/{id}', 'instructorProfile')->name('student.instructor.profile');
        Route::get('/book-session/{id}', 'bookSession')->name('student.book.session');
    });

    // Admin Placeholders
    Route::get('/admin/livestream', function() { return 'Livestream Control'; })->name('livestream.index');
    Route::get('/admin/users', function() { return 'User Management'; })->name('users.index');
});
