<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\UserController;


Route::redirect('/', '/home');
Auth::routes();
Route::get('/login/admin', [LoginController::class, 'showAdminLoginForm']);
Route::get('/register/admin', [RegisterController::class,'showAdminRegisterForm']);
Route::post('/login/admin', [LoginController::class,'adminLogin']);
Route::post('/register/admin', [RegisterController::class,'createAdmin']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => 'auth:admin'], function () {
Route::view('/admin', 'admin');
});
Route::get('logout', [LoginController::class,'logout']);

Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/activities/create', [ActivityController::class, 'create'])->name('activities.create');
Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
Route::get('/activities/{activity}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
Route::put('/activities/{activity}', [ActivityController::class, 'update'])->name('activities.update');
Route::post('/activities/{activity}/comments', [ActivityController::class, 'addComment'])->name('activities.comments.store');
Route::patch('/activities/{activity}/status', [ActivityController::class, 'updateStatus'])->name('activities.status');
Route::delete('/activities/{activity}', [ActivityController::class, 'destroy'])->name('activities.destroy');

Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{oUser}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{oUser}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{oUser}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/users/{oUser}/updatePassword', [UserController::class, 'updatePassword'])->name('users.updatePassword');
Route::put('/users/{oUser}/savePassword', [UserController::class, 'savePassword'])->name('users.savePassword');