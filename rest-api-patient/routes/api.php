<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;

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

# membuat route untuk register dan login
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);



# ROUTES PATIENT (UTS)
Route::middleware(['auth:sanctum'])->group(function () {

    # method get all resource
    Route::get('/patients', [PatientController::class, 'index']);

    # method add resource
    Route::post('/patients', [PatientController::class, 'store']);

    # method get detail resource
    Route::get('/patients/{id}', [PatientController::class, 'show']);

    # method edit resource
    Route::put('/patients/{id}', [PatientController::class, 'update']);

    # method delete resource
    Route::delete('/patients/{id}', [PatientController::class, 'destroy']);

    # method search resource by name
    Route::get('/patients/search/{name}', [PatientController::class, 'search']);

    # method get positive resource
    Route::get('/patients/status/positive', [PatientController::class, 'positive']);

    # method get recovered resource
    Route::get('/patients/status/recovered', [PatientController::class, 'recovered']);

    # method get dead resource
    Route::get('/patients/status/dead', [PatientController::class, 'dead']);

});

