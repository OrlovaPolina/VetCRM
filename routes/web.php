<?php

use App\Http\Controllers\ProfileController;
use App\Http\Middleware\UserRoleManager;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Stocks;
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
    $content = News::all()->take(5);
    foreach($content as $item){            
        $item->images_urls = json_decode($item->images_urls); 
    }
    $stocks = Stocks::all()->take(4);
    foreach($stocks as $item){            
        $item->images_urls = json_decode($item->images_urls); 
    }
    return view('index')->with(['title'=>'Главная','content'=>$content,'type'=>'news','stocks'=>$stocks,'user_sub' => true]);
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   
});

Route::get('/news',[Controller::class, 'news'])->name('news');
Route::get('/stocks',[Controller::class, 'stocks'])->name('stocks');
Route::get('/detail/{type}/{id}',[Controller::class, 'detail'])->name('NSdetail');
Route::get('/about',[Controller::class, 'about'])->name('about');

Route::get('/test',function(){
   echo '<pre>' . print_r(Config::getAll(2), 1) . '</pre>';
});

require __DIR__.'/auth.php';
