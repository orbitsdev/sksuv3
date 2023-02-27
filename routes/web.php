<?php

use App\Models\User;
use Inertia\Inertia;
use App\Events\ApproveNotfication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VpaController;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\CampusController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ApproveController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\GenerateController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\RequirementController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\CampusAdviserController;
use App\Http\Controllers\CampusDirectorController;
use App\Http\Controllers\VpaOrganizationController;
use App\Http\Controllers\ApplyApplicationController;
use App\Http\Controllers\OsasOrganizationController;
use App\Http\Controllers\DirectorOrganizationController;
use App\Http\Controllers\CampusAdviserOrganizationController;

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



Route::post('file/upload', [FileController::class, 'uploadToTemporaryStorage'])->name('uploadtolocal');
Route::delete('file/delete', [FileController::class, 'deleteFromLocalStorage'])->name('deletefromlocal');



Route::get('/event', function () {
    $array = ['name' => 'Ekpono Ambrose']; //data we want to pass
    event(new ApproveNotfication($array));
    
    return 'done';
});


Route::middleware('guest')->group(function () {

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

    
Route::get('/', function () {
    return redirect()->route('dashboard');
});


    Route::get('dashboard', function () {

        if (Auth::user()->hasRole('osas')) {
            return redirect()->route('schoolyear.index');
        }
        if (Auth::user()->hasRole('sbo-adviser')) {
            return redirect()->route('campusadviser.organization.index');
        }
        if (Auth::user()->hasRole('sbo-student')) {
            return redirect()->route('application.index');
        }
        if (Auth::user()->hasRole('campus-director')) {
                
            return redirect()->route('director.organization.index');
        }
        if (Auth::user()->hasRole('vpaa')) {
                
            return redirect()->route('vpa.organization.index');
        }
       
        return Inertia::render('dashboard');
    })->name('dashboard'); //name goes here
    Route::post('logout', [AuthController::class, 'logout']);

    Route::group([
        'middleware'=> [
            'can:is-osas'
        ],
        'prefix' => 'school-year',
        'as' => 'schoolyear.'
    ], function () {

        Route::get('/',  [SchoolYearController::class, 'index'])->name('index');
        Route::post('create', [SchoolYearController::class, 'create'])->name('create');
        Route::post('delete-selected', [SchoolYearController::class, 'deleteSelected'])->name('delete-selected');
    });


    Route::group([
        'middleware'=> [
            'can:is-osas'
        ],
        'prefix' => 'user/acount',
        'as' => 'account.'
    ], function () {

        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::get('passwords', [AccountController::class, 'userPasswordIndex'])->name('userpassword.index');
        Route::post('password/update', [AccountController::class, 'userPasswordUpdate'])->name('userpassword.update');
    });


    Route::group([
        'middleware'=> [
            'can:is-osas'
        ],
        'prefix' => 'user/acount/campus-adviser',
        'as' => 'campusadviser.'
    ], function () {

        Route::get('/', [CampusAdviserController::class, 'index'])->name('index');
        Route::post('create', [CampusAdviserController::class, 'create'])->name('create');
        Route::post('delete-selected', [CampusAdviserController::class, 'deleteSelected'])->name('deleteselected');
    });


    Route::group([
        'middleware'=> [
            'can:is-osas'
        ],
        'prefix' => 'user/acount/campus-directors',
        'as' => 'campusdirector.'
    ], function () {

        Route::get('/', [CampusDirectorController::class, 'index'])->name('index');
        Route::post('create', [CampusDirectorController::class, 'create'])->name('create');
        Route::post('update', [CampusDirectorController::class, 'update'])->name('update');
        Route::post('delete-selected', [CampusDirectorController::class, 'deleteSelected'])->name('deleteselected');
    });


    Route::group([
        'middleware'=> [
            'can:is-osas'
        ],
        'prefix' => 'user/acount/vpa',
        'as' => 'vpa.'
    ], function () {

        Route::get('/', [VpaController::class, 'index'])->name('index');
        Route::post('create', [VpaController::class, 'create'])->name('create');
        Route::post('update', [VpaController::class, 'update'])->name('update');
        Route::post('delete-selected', [VpaController::class, 'deleteSelected'])->name('deleteselected');
    });




    Route::group([

        'prefix' => 'campus-and-organizations',
        'as' => 'campusandorganization.'
    ], function () {

        Route::get('/', function () {
            return Inertia::render('osas/campusandorganization');
        })->name('index');
    });



    Route::group([
        'middleware'=> [
            'can:is-osas'
        ],
        'prefix' => 'campus-and-organizations',
        'as' => 'campus.'
    ], function () {

        Route::get('campus', [CampusController::class, 'index'])->name('index');
        Route::post('campus/create', [CampusController::class, 'create'])->name('create');
        Route::post('campus/update', [CampusController::class, 'update'])->name('update');
        Route::post('campus/delete-selected', [CampusController::class, 'deleteSelected'])->name('deleteSelected');
    });

    // Route::group([

    //     'prefix' => 'campus-and-organizations',
    //     'as' => 'organization.'
    // ], function () {

    //     Route::get('organization', [OrganizationController::class, 'index'])->name('index');
    //     Route::post('organization/create', [OrganizationController::class, 'create'])->name('create');
    //     Route::post('organization/update', [OrganizationController::class, 'update'])->name('update');
    //     Route::post('organization/delete-selected', [OrganizationController::class, 'deleteSelected'])->name('deleteSelected');
    // });



    Route::group([
        'middleware'=> [
            'can:is-osas'
        ],
        'prefix' => 'requirements',
        'as' => 'requirement.'
    ], function () {

        Route::get('/', [RequirementController::class, 'index'])->name('index');
        Route::post('create', [RequirementController::class, 'create'])->name('create');
        Route::post('update', [RequirementController::class, 'update'])->name('update');
        Route::post('delete-selected', [RequirementController::class, 'deleteSelected'])->name('deleteselected');
    });


    Route::group([
        'middleware'=> [
            'can:is-osas'
        ],
        'prefix' => 'osas/organization',
        'as' => 'osas.organization.'
    ], function () {

        Route::get('/', [OsasOrganizationController::class, 'index'])->name('index');
    });
    Route::group([
        'middleware'=> [
            'can:is-osas'
        ],
        'prefix' => 'osas/certifcate',
        'as' => 'osas.generatecerticate.'
    ], function () {
        Route::get('/', [ GenerateController::class, 'index'])->name('index');
    });


    Route::group([
        'middleware'=> [
            'can:is-adviser'
        ],
        'prefix' => 'officers',
        'as' => 'officers.'
    ], function () {

        Route::get('/', [OfficerController::class, 'index'])->name('index');
        Route::get('/{campus}/manage', [OfficerController::class, 'manageIndex'])->name('manageindex');
        Route::post('create', [OfficerController::class, 'create'])->name('create');
        Route::post('update', [OfficerController::class, 'update'])->name('update');
        Route::post('delete-selected', [OfficerController::class, 'deleteSelected'])->name('deleteselected');
    
    });
    Route::group([
        'middleware'=> [
            'can:is-adviser'
        ],
        'prefix' => 'adviser/organizations',
        'as' => 'campusadviser.organization.'
    ], function () {

        Route::get('/', [CampusAdviserOrganizationController::class, 'index'])->name('index');
        // Route::post('/approve', [CampusAdviserOrganizationController::class, 'approve'])->name('approve');
        // Route::post('/deny', [CampusAdviserOrganizationController::class, 'deny'])->name('deny');
      
    
    });
    Route::group([
        'middleware'=> [
            'can:is-director'
        ],
        'prefix' => 'director/organizations',
        'as' => 'director.organization.'
    ], function () {

        Route::get('/', [DirectorOrganizationController::class, 'index'])->name('index');

      
    
    });
    Route::group([
        'middleware'=> [
            'can:is-vpa'
        ],
        'prefix' => 'vpa/organizations',
        'as' => 'vpa.organization.'
    ], function () {

        Route::get('/', [VpaOrganizationController::class, 'index'])->name('index');

      
    
    });


    
    Route::group([
        'middleware'=> [
            'can:is-student'
        ],
        'prefix' => 'applications',
        'as' => 'application.'

    ], function () {

        Route::get('/', [ApplyApplicationController::class, 'index'])->name('index');
        Route::post('create', [ApplyApplicationController::class, 'create'])->name('create');
        Route::post('update', [ApplyApplicationController::class, 'update'])->name('update');
        Route::post('delete-selected', [ApplyApplicationController::class, 'deleteSelected'])->name('deleteselected');
        Route::post('delete-file', [ApplyApplicationController::class, 'deleteFile'])->name('deletefile');
    
    });

    Route::group([
        'middleware'=> [

        ],
        'prefix' => 'organizations',
        'as' => 'organization.application.'
    ], function () {

        Route::post('/approve', [ApproveController::class, 'approve'])->name('approve');
        Route::post('/deny', [ApproveController::class, 'deny'])->name('deny');
      
    
    });


    Route::get('notification', [NotificationController::class, 'index'])->name('nottification.index');
    



   
});
