<?php

use App\Actions\Fortify\CreateNewUser;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('/', [PostController::class, 'welcome'])->name('welcome');
    Route::post('/', [PostController::class, 'create'])->name('post.create')->middleware([HandlePrecognitiveRequests::class]);
    Route::get('/{user}', [PostController::class, 'user'])->name('user');
});
