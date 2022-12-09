<?php

use App\Http\Controllers\MenuController;
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
Route::get('user', [UserController::class, 'data']);
Route::post('/addclass', [UserController::class, 'addClass'])->name('addClass');
Route::post('/createworker', [WorkerController::class, 'createWorker'])->name('createWorker');
Route::post('/createschool', [WorkerController::class, 'createSchool'])->name('createSchool');
Route::post('/addrestriction', [WorkerController::class, 'addRestriction'])->name('addRestriction');

// RECEPIE routes
Route::get('/recepies', [RecepiesController::class, 'getRecepies']);
Route::post('/createrecepie', [RecepiesController::class, 'createRecepies'])->name('createRecepie');
Route::delete('/delete/{id}', [RecepiesController::class, 'delete'])->name('deleteRecepie');
Route::get('/recepie/{id}', [RecepiesController::class, 'getRecepie']);

// MENU routes
Route::get('/menu', [MenuController::class, 'index']);
Route::get('/getlocalmenu', [MenuController::class, 'getLocal'])->name('getLocal');