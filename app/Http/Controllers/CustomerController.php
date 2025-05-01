<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;

class CustomerController
{
    public function __construct(protected CustomerService $service)
    {
    }

    public function getById(int $id): JsonResponse
    {
        return response()->json(['data' => $this->service->getById($id)]);
    }
}
