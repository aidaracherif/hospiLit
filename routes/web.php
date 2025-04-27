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


//Patient Routes
Route::get('/patients', [App\Http\Controllers\PatientController::class, 'index'])->name('patients.index');
Route::get('/patients/create', [App\Http\Controllers\PatientController::class, 'create'])->name('patients.create');
Route::get('/patients/{patient}', [App\Http\Controllers\PatientController::class, 'show'])->name('patients.show');
Route::post('/patients', [App\Http\Controllers\PatientController::class, 'store'])->name('patients.store');
Route::put('/patients/{patient}', [App\Http\Controllers\PatientController::class, 'update'])->name('patients.update');
Route::get('/patients/{patient}/edit', [App\Http\Controllers\PatientController::class, 'edit'])->name('patients.edit');
Route::delete('/patients/{patient}/delete', [App\Http\Controllers\PatientController::class, 'destroy'])->name('patients.destroy');

//Lit Routes
Route::get('/lits', [App\Http\Controllers\LitController::class, 'index'])->name('lits.index');
Route::get('/lits/create', [App\Http\Controllers\LitController::class, 'create'])->name('lits.create');
Route::get('/lits/{lit}', [App\Http\Controllers\LitController::class, 'show'])->name('lits.show');
Route::post('/lits', [App\Http\Controllers\LitController::class, 'store'])->name('lits.store');
Route::put('/lits/{lit}', [App\Http\Controllers\LitController::class, 'update'])->name('lits.update');
Route::get('/lits/{lit}/edit', [App\Http\Controllers\LitController::class, 'edit'])->name('lits.edit');
Route::delete('/lits/{lit}/delete', [App\Http\Controllers\LitController::class, 'destroy'])->name('lits.destroy');



