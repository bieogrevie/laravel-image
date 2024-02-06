<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/image', [ImageController::class, 'index'])->name('image.index');
Route::get('/image/create', [ImageController::class, 'create'])->name('image.create');
Route::get('/image/create_multiple', [ImageController::class, 'create_multiple'])->name('image.create_multiple');
Route::post('/image/store', [ImageController::class, 'store'])->name('image.store');
Route::post('/image/store_multiple', [ImageController::class, 'store_multiple'])->name('image.store_multiple');
Route::post('/image/destroy/{id}', [ImageController::class, 'destroy'])->name('image.destroy');
