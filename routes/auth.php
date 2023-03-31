<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ManagerController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
    Route::name('manager.')->group(function () {
        Route::get('/manager', function () {
            return view('manager.dashboard')->with(['users'=>null,'search'=>null]);
        })->middleware('manager')->name('dashboard');
        /**
         * Путь до страницы с таблицей пользователей
         */
        Route::post('/manager', 
        [ManagerController::class, 'saveUserTable']
        )->middleware('manager')->name('saveUsers');
        /**
         * Поиск пользователей
         */
        Route::post('/manager/search', 
        [ManagerController::class, 'search']
        )->middleware('manager')->name('searchUsers');
        /**
         * Путь до страницы с расписанием
         */
        Route::get('/manager/timetable',
        function(){
            return view('manager.timetable');
        })->middleware('manager')->name('timetable');
        /**
         * Путь до страницы с новостями
         */
        Route::get('/manager/news',
        function(){
            return view('manager.news');
        })->middleware('manager')->name('news');
        /**
         * Создание новостей и акций
         * 
         */
        Route::get('/manager/news/create',
        function(){
            return view('manager.news-create');
        })->middleware('manager')->name('newsCreate');
        Route::post('/manager/news',[ManagerController::class,'createNewsAndStocks'])->middleware('manager')->name('newsStocks');

        /** 
         * Изменение новостей и акций
         */
        Route::get('/manager/{type}/edit/{id}',[ManagerController::class,'editNewsStocksPage'])->middleware('manager')->name('editNewsStocksPage');
        Route::post('/manager/{type}/edit/{id}',[ManagerController::class,'editNewsStocks'])->middleware('manager')->name('editNewsStocks');
        /**
         * Отключение новостей и акций
         */
        Route::post('/manager/{type}/delete/{id}',[ManagerController::class,'deleteNewsStocks'])->middleware('manager')->name('deleteNewsStocks');
        /**
         * Отключение новостей и акций
         */
        Route::post('/manager/{type}/restore/{id}',[ManagerController::class,'restoreNewsStocks'])->middleware('manager')->name('restoreNewsStocks');
    });
    
});
