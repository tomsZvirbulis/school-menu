<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\RecepiesController;
use Illuminate\Support\Facades\Route;

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

Route::get('/home', function () {
    return view('home');
});

//  USER routes
Route::get('user/{caterer_id}', [WorkerController::class, 'data']);
Route::post('/createworker', [WorkerController::class, 'createWorker'])->name('createWorker');
Route::post('/createschool', [WorkerController::class, 'createSchool'])->name('createSchool');

// RECEPIE routes
Route::get('/recepies', [RecepiesController::class, 'getRecepies']);
Route::post('/createrecepie', [RecepiesController::class, 'createRecepies'])->name('createRecepie');
