<?php

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CampusAdviserController;
use App\Http\Controllers\OrganizationController;
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



 


Route::middleware('guest')->group(function () {
    Route::get('/', function () {       

        return Inertia::render('login');
    })->name('login');
    Route::get('login', function () {
        return Inertia::render('login');
    })->name('login');
    Route::get('register', function () {
        return Inertia::render('register',);
    });

    Route::post('user/login', [AuthController::class, 'login']);
    Route::post('user/create', [AuthController::class, 'create']);


    Route::get('/authorize/{provider}/redirect', [GoogleController::class, 'redirectToProvider']);
    Route::get('/authorize/{provider}/callback', [GoogleController::class, 'handleProviderCallback']);
});





Route::group(['middleware' => ['auth',]], function () {
    Route::get('dashboard', function () {

            if(Auth::user()->hasRole('osas')){
                return redirect()->route('schoolyear.index');
            }
        return Inertia::render('dashboard');



    })->name('dashboard'); //name goes here
    Route::post('logout', [AuthController::class, 'logout']);

    // Route::get('page1', function () {  


    //      return Inertia::render('sample/page1', [
    //         'users'=> User::query()
    //         ->when(Request::input('search'), function($query, $search){
    //                 $query->where('first_name', 'like', "%{$search}%");
    //             })
    //             ->paginate(20)
    //             ->withQueryString()
    //             ->through(fn($user)=>[
    //                 'id'=> $user->id,
    //                 'first_name'=> $user->first_name,
    //                 'email'=> $user->email,
    //             ]),
    //         'filters'=>Request::only(['search'])
    //      ]);

    //     })->name('users');




    Route::get('year',  [SchoolYearController::class, 'index'])->name('schoolyear.index');
    Route::post('year/create', [SchoolYearController::class, 'create']);
    Route::post('year/delete-selected', [SchoolYearController::class, 'deleteSelected'])->name('delete-selected');




    Route::get('user/account', [AccountController::class, 'index'])->name('account.index');
    Route::get('user/account/passwords', [AccountController::class, 'userPasswordIndex'])->name('account.userpassword.index');
    Route::post('user/account/password/update', [AccountController::class, 'userPasswordUpdate'])->name('account.userpassword.update');
   
    Route::get('user/account/campus-advisers', [CampusAdviserController::class, 'index'])->name('campusadviser.index');
    Route::post('user/account/campus-advisers/create', [CampusAdviserController::class, 'create'])->name('campusadviser.create');
    Route::post('user/account/campus-advisers/delete-selected', [CampusAdviserController::class, 'deleteSelected'])->name('campusadviser.deleteselected');
    
    Route::get('campus-and-organizations', function(){
        return Inertia::render('osas/campusandorganization');
    })->name('campusandorganization.index');

    Route::get('campus-and-organizations/campus', [CampusController::class, 'index'])->name('campus.index');
    Route::post('campus-and-organizations/campus/create', [CampusController::class, 'create'])->name('campus.create');
    Route::post('campus-and-organizations/campus/update', [CampusController::class, 'update'])->name('campus.update');
    Route::post('campus-and-organizations/campus/delete-selected', [CampusController::class, 'deleteSelected'])->name('campus.deleteSelected');
    
    Route::get('campus-and-organizations/organization', [OrganizationController::class, 'index'])->name('organization.index');
    Route::post('campus-and-organizations/organization/create', [OrganizationController::class, 'create'])->name('organization.create');
    Route::post('campus-and-organizations/organization/update', [OrganizationController::class, 'update'])->name('organization.update');
    Route::post('campus-and-organizations/organization/delete-selected', [OrganizationController::class, 'deleteSelected'])->name('organization.deleteSelected');
    

});
