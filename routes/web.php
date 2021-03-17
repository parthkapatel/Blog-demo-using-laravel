<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogVoteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\NestedCommentController;
use App\Models\Blog;
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

Route::get("blogs",[BlogController::class, "index"]);
Route::get("blogs/{blog_id}",[BlogController::class,"show"]);
Route::get("blog/{blog_id}/edit",[BlogController::class,"edit"]);
Route::post("blog/{blog_id}/update",[BlogController::class,"update"]);
Route::get("blog/{blog_id}/delete",[BlogController::class,"destroy"]);
Route::get("view-your-blogs",[BlogController::class,"userBlogs"]);
Route::get("upload/blog",[BlogController::class,"create"]);
Route::put("upload/blog",[BlogController::class,"store"]);

Route::put("/blog/{blog_id}/comment",[CommentController::class,"store"]);
Route::get("/blog/{blog_id}/getCountValues",[BlogController::class,"getCountValues"]);
Route::get("/blog/{blog_id}/{str}",[BlogVoteController::class,"update"]);

Route::get("/blog/{blog_id}/{comment_id}/nested-comment",[NestedCommentController::class,"index"]);
Route::post("/blog/{blog_id}/{comment_id}/reply",[NestedCommentController::class,"store"]);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

