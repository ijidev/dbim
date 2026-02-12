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

// Library Routes (Public for index, Auth for specific actions likely)
Route::controller(LibraryController::class)->group(function () {
    Route::get('/library', 'index')->name('library.index');
    Route::get('/read/{slug}', 'read')->name('library.read');
    Route::post('/library/progress/{book}', 'updateProgress')->name('library.progress');
    Route::get('/chapter/{id}', 'getChapterContent')->name('library.chapter');
});

// Auth Middleware Group
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    Route::get('/dashboard', [StudentController::class, 'index'])->name('dashboard');

    // Student Routes
    Route::controller(StudentController::class)->group(function () {
        Route::get('/schedule', 'schedule')->name('student.schedule');
        Route::get('/learn/{id}', 'learn')->name('student.learn');
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
        
        Route::get('/instructors', 'instructors')->name('student.instructors');
        Route::get('/instructor/{id}', 'instructorProfile')->name('student.instructor.profile');
        Route::get('/book-session/{id}', 'bookSession')->name('student.book.session');
        
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
        
        // Course Management (Placeholder based on sidebar)
        Route::get('/courses', function() { return 'Courses Index'; })->name('courses.index');
    });
});
