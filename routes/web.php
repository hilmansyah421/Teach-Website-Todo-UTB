<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\TodoListController;

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

Route::get('/about', function () {
    return view('about');
});

Route::resource('users', UserController::class);
Route::get('user/login', [UserController::class, 'login'])->name('login');
Route::post('user/login', [UserController::class, 'loginAuth']);
Route::get('user/register', [UserController::class, 'register']);
Route::post('user/register', [UserController::class, 'storeRegister']);
Route::get('user/profile', [UserController::class, 'profile'])->middleware('auth');
Route::post('user/logout', [UserController::class, 'logout'])->name('logout');

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index']);
});

Route::prefix('todo')->group(function () {
    Route::get('/', [TodoController::class, 'index']);
    Route::get('/create', [TodoController::class, 'create']);
    Route::get('/edit/{id}', [TodoController::class, 'edit']);
    Route::get('/delete/{id}', [TodoController::class, 'destroy']);
    Route::post('/store', [TodoController::class, 'store']);
    Route::post('/update/{id}', [TodoController::class, 'update']);
});

Route::prefix('todolist')->group(function () {
    Route::get('/', [TodoListController::class, 'index']);
    Route::get('/delete/{id}', [TodoListController::class, 'destroy']);
    Route::post('/store', [TodoListController::class, 'store']);
    Route::post('/update/{id}', [TodoListController::class, 'update']);
});

Route::resource('todo-categories', 'TodoCategoryController');
