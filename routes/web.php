<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;

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
    return Inertia::render('login');
})->name('login');
Route::get('/login', function () {
    return Inertia::render('login');
})->name('login');
Route::get('/register', function () {
    return Inertia::render('register', );
});

Route::post('user/login', [AuthController::class , 'login']);
Route::post('user/create', [AuthController::class , 'create']);

Route::get('/authorize/{provider}/redirect', [GoogleController::class, 'redirectToProvider']);
Route::get('/authorize/{provider}/callback', [GoogleController::class, 'handleProviderCallback']);



Route::group(['middleware' => ['auth' ,]], function () {
    Route::get('/dashboard', function () { return Inertia::render('dashboard');})->name('dashboard'); //name goes here
    Route::post('/logout', [AuthController::class , 'logout']);
    
});
