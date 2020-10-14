<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\UserController;
use Symfony\Component\HttpFoundation\Request;

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
    'contact' => ContactController::class,
    'user' => UserController::class,
    ]);
    
Route::get('/dashboard', [AdminController::class, 'index'])->middleware(['auth:sanctum', 'verified'])->name('dashboard');

Route::get('/blog', [PostController::class, 'index']);

Route::get('/search', [PostController::class, 'search']);

Route::get('/contact-us', function ()
{
    return view('contact');
});

Route::post('/mark-as-read', [AdminController::class,'markNotification'])->name('markNotification');
