<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScheduleGeneratorController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SettingsBreakingController;
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
        Route::post('/employee/generate-schedule', [EmployeeController::class, 'generateSchedule']);
        Route::get('/settings/{id}', [SettingsController::class, 'getById']);
        Route::get('/settings/employee/{employee_id}', [SettingsController::class, 'getByEmployeeId']);
        Route::post('/settings', [SettingsController::class, 'create']);
        Route::delete('/breaking/{breaking}', [SettingsBreakingController::class, 'delete']);
        Route::get('/schedule/employee/{employeeId}', [ScheduleController::class, 'getByEmployeeId']);
        Route::post('/logout', [AuthController::class, 'logout']);
    }
);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/documentation', [DocumentationController::class, 'index']);
