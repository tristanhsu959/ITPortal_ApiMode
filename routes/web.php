<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Middleware\AccessPermissionMiddleware;
use Illuminate\Support\Str;

/* Login */
Route::get('/', [AuthController::class, 'showSignin'])->name('signin');
Route::get('signin', [AuthController::class, 'showSignin'])->name('signin.get');
Route::post('signin', [AuthController::class, 'signin'])->name('signin.post');
Route::get('signout', [AuthController::class, 'signout'])->name('signout');

Route::middleware([AccessPermissionMiddleware::class])->group(function(){
	/* Home */
	Route::get('home', [HomeController::class, 'index'])->name('home');

	/* 帳號管理 */
	Route::get('user', [UserController::class, 'list'])->name('user');
	Route::get('user/list', [UserController::class, 'list'])->name('user.list');
	Route::post('user/search', [UserController::class, 'search'])->name('user.search');
	Route::get('user/create', [UserController::class, 'showCreate'])->name('user.create.get');
	Route::post('user/create', [UserController::class, 'create'])->name('user.create.post');
	Route::get('user/update/{id}', [UserController::class, 'showUpdate'])->name('user.update.get');
	Route::post('user/update', [UserController::class, 'update'])->name('user.update.post');
	Route::post('user/delete/{id}', [UserController::class, 'delete'])->name('user.delete.post');

	/* 身份管理 */
	Route::get('role', [RoleController::class, 'list'])->name('role');
	Route::get('role/list', [RoleController::class, 'list'])->name('role.list');
	Route::get('role/create', [RoleController::class, 'showCreate'])->name('role.create.get');
	Route::post('role/create', [RoleController::class, 'create'])->name('role.create.post');
	Route::get('role/update/{id}', [RoleController::class, 'showUpdate'])->name('role.update.get');
	Route::post('role/update', [RoleController::class, 'update'])->name('role.update.post');
	Route::post('role/delete/{id}', [RoleController::class, 'delete'])->name('role.delete.post');
	
	/* Password */
	Route::get('password/generate', function(){
		return Str::password(10, TRUE, TRUE, FALSE, FALSE);
	});
});
