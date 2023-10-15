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
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/post', PostController::class)->parameters([
        'post' => 'post:slug'
    ])->except('index', 'show');
    Route::get('/post/list', [PostController::class, 'userPosts'])->name('post.user.list');
    Route::resource('/task', TaskController::class);
});

Route::resource('/post', PostController::class)->parameters([
    'post' => 'post:slug'
])->only('index', 'show');

require __DIR__ . '/auth.php';
