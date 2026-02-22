<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\AccessPermissionMiddleware;
use Illuminate\Support\Str;

/* Login */
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.auth');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
Route::put('changePassword', [AuthController::class, 'changePassword'])->name('changePassword');

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
	Route::put('user/update', [UserController::class, 'update'])->name('user.update.post');
	Route::delete('user/delete/{id}', [UserController::class, 'delete'])->name('user.delete.post');

	/* 身份管理 */
	Route::get('role', [RoleController::class, 'list'])->name('role');
	Route::get('role/list', [RoleController::class, 'list'])->name('role.list');
	Route::get('role/create', [RoleController::class, 'showCreate'])->name('role.create.get');
	Route::post('role/create', [RoleController::class, 'create'])->name('role.create.post');
	Route::get('role/update/{id}', [RoleController::class, 'showUpdate'])->name('role.update.get');
	Route::post('role/update', [RoleController::class, 'update'])->name('role.update.post');
	Route::post('role/delete/{id}', [RoleController::class, 'delete'])->name('role.delete.post');
	
	/* Generate Password */
	Route::get('password/generate', function(){
		return Str::password(10, TRUE, TRUE, FALSE, FALSE);
	});
	
	/* 產品管理 */
	Route::get('product', [ProductController::class, 'list'])->name('product');
	Route::get('product/list', [ProductController::class, 'list'])->name('product.list');
	Route::post('product/search', [ProductController::class, 'search'])->name('product.search');
	Route::get('product/create', [ProductController::class, 'showCreate'])->name('product.create.get');
	Route::post('product/create', [ProductController::class, 'create'])->name('product.create.post');
	Route::get('product/update/{id}', [ProductController::class, 'showUpdate'])->name('product.update.get');
	Route::post('product/update', [ProductController::class, 'update'])->name('product.update.post');
	Route::post('product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete.post');
});

/* Route::Resource
動詞 (Verb) 	路徑 (URI)			方法 (Method)	路由名稱 (Name)	用途 (Purpose)
GET			/users				ndex			users.index		顯示所有資料清單
GET			/users/create		create			users.create	顯示新增表單
POST		/users				store			users.store		儲存新資料
GET			/users/{user}		show			users.show		顯示單一資料
GET			/users/{user}/edit	edit			users.edit		顯示編輯表單
PUT/PATCH	/users/{user}		update			users.update	更新資料
DELETE		/users/{user}		destroy			users.destroy	刪除資料
*/