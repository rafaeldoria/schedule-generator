<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository
{
    public function all(): array
    {
        return Employee::all()->toArray();
    }

    public function findById(int $id): ?Employee
    {
        return Employee::query()
            ->where('id', $id)
            ->first();
    }

    public function create(array $data): Employee
    {
        return Employee::query()->create($data);
    }

    public function update(array $data, int $id): bool
    {
        return Employee::query()
            ->where('id', $id)
            ->update($data);
    }
}
