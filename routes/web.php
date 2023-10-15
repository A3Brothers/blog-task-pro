<?php

use App\Http\Controllers\Blog\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Task\TaskController;
use Illuminate\Support\Facades\Route;

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
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Post route for authenticated users
    Route::resource('/post', PostController::class)->parameters([
        'post' => 'post:slug'
    ])->except('index', 'show');

    Route::get('/post/list', [PostController::class, 'userPosts'])->name('post.user.list');

    // Task route for authenticated users
    Route::resource('/task', TaskController::class);
});

// Post route for guest users
Route::resource('/post', PostController::class)->parameters([
    'post' => 'post:slug'
])->only('index', 'show');

require __DIR__ . '/auth.php';
