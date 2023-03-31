<?php

use App\Http\Controllers\TextController;
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

Route::get('/', [TextController::class, 'index']);
Route::get('/telegraph/edit{telegraph}', [TextController::class, 'edit'])->name('editor');
Route::get('/telegraph', [TextController::class, 'index'])->name('index');

Route::post('/telegraph', [TextController::class, 'store'])->name('create');
Route::patch('/telegraph/{telegraph}', [TextController::class, 'update'])->name('update');
Route::delete('/telegraph/{id}', [TextController::class, 'destroy'])->name('delete');
