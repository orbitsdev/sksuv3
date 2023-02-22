<?php

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\SchoolYearController;

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
Route::get('login', function () {
    return Inertia::render('login');
})->name('login');
Route::get('register', function () {    return Inertia::render('register', );});


Route::post('user/login', [AuthController::class , 'login']);
Route::post('user/create', [AuthController::class , 'create']);



Route::get('/authorize/{provider}/redirect', [GoogleController::class, 'redirectToProvider']);
Route::get('/authorize/{provider}/callback', [GoogleController::class, 'handleProviderCallback']);

Route::group(['middleware' => ['auth' ,]], function () {
    Route::get('dashboard', function () { return Inertia::render('dashboard');})->name('dashboard'); //name goes here
    Route::post('logout', [AuthController::class , 'logout']);    
 


    Route::get('page1', function () {  
        
        
         return Inertia::render('sample/page1', [
            'users'=> User::query()
            ->when(Request::input('search'), function($query, $search){
                    $query->where('first_name', 'like', "%{$search}%");
                })
                ->paginate(20)
                ->withQueryString()
                ->through(fn($user)=>[
                    'id'=> $user->id,
                    'first_name'=> $user->first_name,
                    'email'=> $user->email,
                ]),
            'filters'=>Request::only(['search'])
         ]);

        })->name('users');

        

    Route::get('page2', function () {    return Inertia::render('sample/page2', );});   
    Route::get('page3', function () {    return Inertia::render('sample/page3', );});

    Route::get('year',  [SchoolYearController::class, 'index'])->name('yearindex');
    Route::post('year/create', [SchoolYearController::class , 'create']);        
    Route::post('year/delete-selected', [SchoolYearController::class , 'deleteSelected'])->name('delete-selected');        
});


