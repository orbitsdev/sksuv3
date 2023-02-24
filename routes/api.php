<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('public/school-year', [PublicController::class, 'getSchoolYear'])->name('public.schoolyear');
Route::get('public/school-year-with-campus', [PublicController::class, 'getCampus'])->name('public.campus');
Route::get('public/guest-users', [PublicController::class, 'getGuestUsers'])->name('public.guestusers');