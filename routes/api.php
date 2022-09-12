<?php

use App\Http\Controllers\InstrumentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\UserController;

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

Route::get('/program/institute/', [ProgramController::class, 'getInstitute']);
Route::get('/instruments/{id}', [InstrumentController::class, 'getInstruments']);
Route::get('/user/edit/{id}', [UserController::class, 'edit']);
Route::get('/accreditation/instrument/edit/{id}', [InstrumentController::class, 'edit']);