<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
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
Route::get('/', [ReportController::class, 'index'])->name('reports.index');
//ファーストビュー画面に表示される内容を記述

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// 町民
 Route::resource('reports', ReportController::class)
     ->only(['show', 'create', 'store']);
 
 // 職員(一般・管理者)
 Route::resource('reports', ReportController::class)
     ->only(['edit', 'update'])
     ->middleware(['auth']);
 
 // 職員(管理者)
 Route::resource('users', UserController::class)
     ->only(['index', 'edit', 'update'])
     ->middleware(['auth', 'can:admin']);
