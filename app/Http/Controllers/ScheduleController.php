<?php

namespace App\Http\Controllers;

use App\Services\ScheduleService;
use Illuminate\Http\JsonResponse;

class ScheduleController
{
    public function __construct(protected ScheduleService $service)
    {
    }

    public function getByEmployeeId(int $employeeId): JsonResponse
    {
        return response()->json(['data' => $this->service->getByEmployee($employeeId)]);
    }
}
