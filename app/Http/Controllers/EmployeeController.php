<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct(protected EmployeeService $service)
    {
    }

    public function index(): JsonResponse
    {
        return response()->json(['data' => $this->service->getAll()]);
    }

    //pesquisar rotas antigas get by id
    public function show(int $id): JsonResponse
    {
        return response()->json(['data' => $this->service->getById($id)]);
    }

    public function create(Request $request): JsonResponse
    {
        return response()->json(['data' => $this->service->createEmployee($request->all())]);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        return response()->json(['data' => $this->service->updateEmployee($request->all(), $id)]);
    }

    public function generateSchedule(Request $request): JsonResponse
    {
        return response()->json(['data' => $this->service->generateSchedule($request->toArray())]);
    }
}
