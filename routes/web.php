<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AdminController;

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

Route::get('/', [PostController::class, 'index']);

Route::resources([
    'category' => CategoryController::class,
    'tag' => TagController::class,
    'post' => PostController::class,
]);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', AdminController::class)->name('dashboard');

Route::get('/blog', [PostController::class, 'index']);
