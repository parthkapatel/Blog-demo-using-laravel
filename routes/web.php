<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get("about",function (){
    return view("about");
});

Route::get("gallery",function (){
    return view("gallery");
});

Route::get("contact",[ContactController::class,"index"]);
Route::put("contact",[ContactController::class,"store"]);

Route::get("upload/blog",[BlogController::class,"index"]);
Route::put("upload/blog",[BlogController::class,"store"]);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

