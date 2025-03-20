<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\TestController;
use App\Models\Product;

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

// Route::get('/list', [App\Http\Controllers\TestController::class, 'showListProduct'])->name('list');
// Route::get('/list2', [App\Http\Controllers\TestController::class, 'showListCompany'])->name('list2');
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/submit', [App\Http\Controllers\TestController::class, 'showRegistForm'])->name('show.regist');
Route::get('/detail/{id}', [App\Http\Controllers\TestController::class, 'showListDetail'])->name('show.detail');
Route::delete('/destroy/{id}', [App\Http\Controllers\TestController::class, 'destroy'])->name('id.destroy');
Route::get('/products', [App\Http\Controllers\TestController::class, 'testView'])->name('show.test');
//Route::get('/productregister', [App\Http\Controllers\TestController::class, 'showRegister'])->name('show.register');
Route::post('/products', [App\Http\Controllers\TestController::class, 'addition'])->name('show.addition');
Route::get('/edit/{id}',[App\Http\Controllers\TestController::class, 'edit'])->name('show.edit');
Route::get('/productregister', [App\Http\Controllers\TestController::class, 'create'])->name('show.register');
Route::put('/products/{id}',[App\Http\Controllers\TestController::class, 'update'])->name('show.update');
Route::post('/productregister',[App\Http\Controllers\TestController::class, 'imageRegist'])->name('regist');
