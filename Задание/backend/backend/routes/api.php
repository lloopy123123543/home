<?php

use App\Http\Controllers\StudentsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::prefix('password')->group(function () {
    Route::post('create', [StudentsController::class, 'createPassword']);
});


Route::prefix('user')->group(function () {
    Route::post('login', [StudentsController::class, 'login']);
    Route::post('create', [StudentsController::class, 'createUser']);
    Route::post('login/user', [StudentsController::class, 'User_login']);

});

Route::prefix('student')->group(function () {
    Route::get('info', [StudentsController::class, 'student']);
    Route::get('all', [StudentsController::class, 'show_all']);
    Route::post('change', [StudentsController::class, 'changeDataStudent']);
    Route::post('delete', [StudentsController::class, 'deleteStudent']);

});


Route::prefix('turniket')->group(function () {
    Route::get('info', [StudentsController::class, 'showGroupTurniket']);
});

Route::prefix('polzovatel')->group(function () {
    Route::get('show/all', [StudentsController::class, 'showAllPolzovatels']);
});


