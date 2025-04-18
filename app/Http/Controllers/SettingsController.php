<?php

namespace App\Http\Controllers;

use App\Services\EmployeeSettingsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct(protected EmployeeSettingsService $service)
    {
    }

    public function getById(int $id): JsonResponse
    {
        return response()->json(['data' => $this->service->getById($id)]);
    }

    public function getByEmployeeId(int $employeeId): JsonResponse
    {
        return response()->json(['data' => $this->service->getByEmployeeId($employeeId)]);
    }

    public function create(Request $request): JsonResponse
    {
        return response()->json(['data' => $this->service->createSettings($request->all())]);
    }
}
