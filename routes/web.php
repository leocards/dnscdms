<?php

use App\Http\Controllers\AccreditationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstituteController;
use App\Http\Controllers\InstrumentController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [AuthController::class, 'index'])->name('login'); 
Route::post('/login', [AuthController::class, 'authenticateUser']);
Route::get('/logout', [AuthController::class, 'logoutUser']);
Route::post('/forgot', [AuthController::class, 'forgotPassword']);

Route::inertia('/dashboard', 'index')->middleware('loggedUser')->name('dashboard');

/* **** Institute Routes **** */
Route::get('/institute', [InstituteController::class, 'index'])->middleware('loggedUser')->name('institute');
Route::post('/institute', [InstituteController::class, 'store']);
Route::post('/institute/update/{id}', [InstituteController::class, 'update']);

/* **** Program Routes **** */
Route::get('/program', [ProgramController::class, 'index'])->middleware('loggedUser')->name('program');
//opening a program
Route::get('/program/accred/{program}/{id?}', [ProgramController::class, 'show']);
Route::post('/program', [ProgramController::class, 'store']);
Route::post('/program/update/{id}', [ProgramController::class, 'update']);
Route::get('/program/search-user/{search}', [ProgramController::class, 'search']);
Route::post('/program/assignUser', [ProgramController::class, 'assignUser']);
Route::get('/program/view/{id}', [ProgramController::class, 'showProgram']);
Route::get('/program/allProgram', [ProgramController::class, 'allProgram']);
Route::get('/program/assign/user/{program}/{institute}', [ProgramController::class, 'getUserToAssign']);
Route::get('/program/getAssignedMember/{userId}/{area}', [ProgramController::class, 'getAssignedMember']);
Route::get('/program/search/{userId}/{search}', [ProgramController::class, 'searchMemberToAssign']);
Route::post('/program/assign/member', [ProgramController::class, 'assignMember']);


/* **** Accreditation && Instruments Routes **** */
Route::get('/accreditation/get/{id?}', [AccreditationController::class, 'index'])->middleware('loggedUser')->name('accreditation');
Route::get('/accreditation/get-intruments', [AccreditationController::class, 'getInstruments']);
Route::get('/accreditation/edit/{id}', [AccreditationController::class, 'edit']);
Route::post('/accreditation-create', [AccreditationController::class, 'store']);
Route::post('/accreditation-update/{id}', [AccreditationController::class, 'update']);

Route::get('/accreditation/instrument/{child?}', [InstrumentController::class, 'index'])->middleware('loggedUser')->name('instrument');
Route::get('/accreditation/instrument-remove/{id}', [InstrumentController::class, 'destroy']);
Route::post('/accreditation/instrument/update/{id}', [InstrumentController::class, 'update']);

//Create Instrument
Route::post('/instrument/create', [InstrumentController::class, 'store']);

/* **** User Routes **** */
Route::get('/user', [UserController::class, 'index'])->middleware('loggedUser')->name('user');
Route::post('/user/create', [UserController::class, 'store']);
Route::post('/user/edit/{id}', [UserController::class, 'update']);
Route::get('/user-view-info/{id}', [UserController::class, 'show']);

Route::post('/user/create-designation', [UserController::class, 'store_designation']);
Route::post('/user/update-designation/{id}', [UserController::class, 'update_designation']);

/* **** Task Routes **** */
Route::get('/task/{name?}/{id?}', [TaskController::class, 'index'])->middleware('loggedUser')->name('task');


/* **** Shared Routes **** */
Route::inertia('/shared', 'shared')->middleware('loggedUser')->name('shared');


/* **** Survey Routes **** */
Route::inertia('/survey', 'survey')->name('survey');

