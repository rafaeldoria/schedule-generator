<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ScheduleGeneratorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
        'middleware' => 'auth:sanctum',
    ],
    function () {
        Route::post('/generate', [ScheduleGeneratorController::class, 'generate']);
        Route::get('/employee', [EmployeeController::class, 'index']);
        Route::get('/employee/{id}', [EmployeeController::class, 'show']);
        Route::post('/employee', [EmployeeController::class, 'create']);
        Route::put('/employee/{id}', [EmployeeController::class, 'update']);
        Route::get('/user', function (Request $request) {
            return $request->user();
        });
        Route::post('/logout', [AuthController::class, 'logout']);
    }
);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/documentation', [DocumentationController::class, 'index']);
