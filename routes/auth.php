<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
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
        /**
         * Личный кабинет менеджера с пользователями
         */
        Route::get('/manager', function () {
            return view('manager.dashboard')->with(['users'=>null,'search'=>null]);
        })->middleware(['manager', 'verified'])->name('dashboard');
        /**
         * Редактирование пользовательских данных
         */
        Route::post('/manager', 
        [ManagerController::class, 'saveUserTable']
        )->middleware(['manager', 'verified'])->name('saveUsers');
        /**
         * Форма Редактирования данных доктора
         */
        Route::get('/manager/doctor/{id}', 
        [ManagerController::class, 'doctorEdit']
        )->middleware(['manager', 'verified'])->name('doctorEdit');
        /**
         * Редактирование данных доктора
         */
        Route::post('/manager/doctor/{id}', 
        [ManagerController::class, 'doctorEditForm']
        )->middleware(['manager', 'verified'])->name('doctorEditForm');
        /**
         * Поиск пользователей
         */
        Route::post('/manager/search', 
        [ManagerController::class, 'search']
        )->middleware(['manager', 'verified'])->name('searchUsers');
        /**
         * Путь до страницы с расписанием
         */
        Route::get('/manager/timetable',
        function(){
            return view('manager.timetable');
        })->middleware(['manager', 'verified'])->name('timetable');
        /**
         * Список новостей/акций (менеджер) 
         */
        Route::get('/manager/news',
        function(){
            return view('manager.news');
        })->middleware(['manager', 'verified'])->name('news');
        /**
         * Форма создания новостей/акций (менеджер) 
         */
        Route::get('/manager/news/create',
        function(){
            return view('manager.news-create');
        })->middleware(['manager', 'verified'])->name('newsCreate');
        /**
         * Создание новостей/акций (менеджер) 
         */
        Route::post('/manager/news',[ManagerController::class,'createNewsAndStocks'])->middleware(['manager', 'verified'])->name('newsStocks');
        /** 
         * Форма изменений новостей/акций (менеджер) 
         */
        Route::get('/manager/{type}/edit/{id}',[ManagerController::class,'editNewsStocksPage'])->middleware(['manager', 'verified'])->name('editNewsStocksPage');
        /**
         * Сохранение изменний новостей/акций (менеджер) 
         */
        Route::post('/manager/{type}/edit/{id}',[ManagerController::class,'editNewsStocks'])->middleware(['manager', 'verified'])->name('editNewsStocks');
        /**
         * Отключение новостей/акций  (менеджер) 
         */
        Route::post('/manager/{type}/delete/{id}',[ManagerController::class,'deleteNewsStocks'])->middleware(['manager', 'verified'])->name('deleteNewsStocks');
        /**
         * Восстановние новостей/акций (менеджер) 
         */
        Route::post('/manager/{type}/restore/{id}',[ManagerController::class,'restoreNewsStocks'])->middleware(['manager', 'verified'])->name('restoreNewsStocks');
    });

    Route::name('user.')->group(function () {        
         /**
         * Личный кабинет пользователя
         */
        Route::get('/user', function () {return redirect()->route('user.animals');})->middleware(['user', 'verified'])->name('user');
        /**
         * Страница с животными
         */
        Route::get('/user/animals', [UserController::class,'animalsPage'])->middleware(['user', 'verified'])->name('animals');
        /**
         * Форма создания нового животного
         */
        Route::get('/user/animals/create', [UserController::class,'animalsCreatePage'])->middleware(['user', 'verified'])->name('animalsCreatePage');
        /**
         * Создание нового животного
         */
        Route::post('/user/animals/create', [UserController::class,'animalCreate'])->middleware(['user', 'verified'])->name('animalsCreate');
        /**
         * Просмотр всех своих записей
         */
        Route::get('/user/events', [UserController::class,'eventsPage'])->middleware(['user', 'verified'])->name('events');
        /**
         * Форма Создания записи
         */
        Route::get('/user/event/new', [UserController::class,'createEventPage'])->middleware(['user', 'verified'])->name('createEventPage');        
       /**
        * Получение расписания врачей
        */
        Route::post('/user/event/new/doctor', [UserController::class,'getDoctorsParameters'])->middleware(['user', 'verified'])->name('getDoctorsParameters'); 
         /**
         * Создание записи
         */    
        Route::post('/user/event/new', [UserController::class,'createEvent'])->middleware(['user', 'verified'])->name('createEvent');        
        /**
         * Создание карточки животного в pdf
         */
        Route::post('/user/download', [UserController::class,'download'])->middleware(['user', 'verified'])->name('download');        
    });
    Route::name('doctor.')->group(function () {
        /**
         * Личный кабинет доктора
         */
        Route::get('/doctor', function () {return view('dashboard');})->middleware(['doctor', 'verified'])->name('doctor');
        /**
         * Просмотр всех своих записей
         */
        Route::get('/doctor/timeboard', [DoctorController::class,'timeboard'])->middleware(['doctor', 'verified'])->name('timeboard');
        /**
         * Текущий приём
         */
        Route::get('/doctor/event/now', [DoctorController::class,'eventNow'])->middleware(['doctor', 'verified'])->name('eventNow');
        /**
         * Создание новой записи для текущего приёма
         */
        Route::post('/doctor/event/now', [DoctorController::class,'currentEvent'])->middleware(['doctor', 'verified'])->name('currentEvent');  
        /**
         * Получить данные о докторе
         *  */      
        Route::post('/doctor/event/new/doctor', [DoctorController::class,'getDoctorsParameters'])->middleware(['doctor', 'verified'])->name('getDoctorsParameters');     
    });
    
});
