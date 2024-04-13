<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\LogController;



Route::get('/', function () {
    return view('dashboard');
});

Route::get('/users', [UserController::class, 'index'])
    ->middleware('auth')
    ->name('users.index');

Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
Route::post('/users/{id}',  [UserController::class, 'store'])->name('users.store');

// Добавим маршрут для успешной авторизации
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/register', [AuthenticatedSessionController::class, 'showRegistrationForm'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [AuthenticatedSessionController::class, 'register'])
    ->middleware('guest');

Route::get('/reviews', [ReviewController::class, 'index'])
    ->middleware('auth')
    ->name('reviews.index');

Route::get('/chats', [UserController::class, 'myChats'])
    ->middleware('auth')
    ->name('users.my_chats');

    Route::post('/requests', [RequestController::class, 'store'])
    ->middleware('auth')
    ->name('requests.store');



Route::get('/requests', [RequestController::class, 'index'])
    ->middleware('auth')
    ->name('requests.index');

    Route::get('/requests/create', [RequestController::class, 'create'])
    ->middleware('auth')
    ->name('requests.create');

Route::get('/requests/user', [RequestController::class, 'userRequests'])
    ->middleware('auth')
    ->name('requests.user_index');

    Route::get('/manager-requests', [RequestController::class, 'managerRequests'])
    ->middleware('auth')
    ->name('manager-requests');

    Route::get('/account', [UserController::class, 'account'])
    ->middleware('auth')
    ->name('account');

    Route::get('/backup', [BackupController::class, 'backup'])
    ->middleware('auth')
    ->name('backup');

    Route::post('/backup/create', [BackupController::class, 'backup'])
    ->middleware('auth')
    ->name('backup.create');

    Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index')->middleware('auth');
    Route::get('/logs', [LogController::class, 'index'])
    ->middleware('auth')
    ->name('logs.index');