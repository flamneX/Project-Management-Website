<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\ActivityController;


Route::view('/', 'welcome');
Auth::routes();
Route::get('/login/admin', [LoginController::class, 'showAdminLoginForm']);
Route::get('/login/author', [LoginController::class,'showAuthorLoginForm']);
Route::get('/register/admin', [RegisterController::class,'showAdminRegisterForm']);
Route::get('/register/author', [RegisterController::class,'showAuthorRegisterForm']);
Route::post('/login/admin', [LoginController::class,'adminLogin']);
Route::post('/login/author', [LoginController::class,'authorLogin']);
Route::post('/register/admin', [RegisterController::class,'createAdmin']);
Route::post('/register/author', [RegisterController::class,'createAuthor']);
Route::group(['middleware' => 'auth:author'], function () {
Route::view('/author', 'author');
});
Route::group(['middleware' => 'auth:admin'], function () {
Route::view('/admin', 'admin');
});
Route::get('logout', [LoginController::class,'logout']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
Route::post('/activities/{activity}/comments', [ActivityController::class, 'addComment'])->name('activities.comments.store');
Route::patch('/activities/{activity}/status', [ActivityController::class, 'updateStatus'])->name('activities.status');
Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');
