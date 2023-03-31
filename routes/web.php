<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\UserRoleManager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   
});

Route::get('/news',[Controller::class, 'news'])->name('news');
Route::get('/stock',[Controller::class, 'stock'])->name('stock');
Route::get('/about',[Controller::class, 'about'])->name('about');

Route::get('/test',function(){
   echo "<img src=\"".asset('storage\uploads\news\1680231697-vetpng.png') ."\">";
});

require __DIR__.'/auth.php';
