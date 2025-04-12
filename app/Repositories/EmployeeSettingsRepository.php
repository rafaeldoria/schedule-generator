<?php

namespace App\Repositories;

use App\Models\EmployeeSettings;

class EmployeeSettingsRepository
{
    public function findById(int $id): ?EmployeeSettings
    {
        return EmployeeSettings::query()
            ->where('id', $id)
            ->first();
    }

    public function findByEmployeeId(int $employeeId): ?EmployeeSettings
    {
        return EmployeeSettings::query()
            ->where('employee_id', $employeeId)
            ->first();
    }

    public function create(array $data): EmployeeSettings
    {
        return EmployeeSettings::query()->updateOrCreate([
            'employee_id' => $data['employee_id'],
        ], $data);
    }
}
