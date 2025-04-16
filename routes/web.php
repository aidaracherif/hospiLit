<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/hello', function (){
    return view('hello');
});
Auth::routes();



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



Route::get('/services', [ServiceController::class,'index'])->name('services.index');
Route::get('/services/create', [ServiceController::class,'create'])->name('services.create');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');
Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
Route::delete('/services/{service}/delete', [ServiceController::class, 'destroy'])->name('services.destroy');



