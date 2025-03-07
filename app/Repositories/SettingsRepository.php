<?php

namespace App\Repositories;

use App\Models\Settings;

class SettingsRepository
{
    public function findById(int $id): ?Settings
    {
        return Settings::query()
            ->where('id', $id)
            ->first();
    }

    public function findByEmployeeId(int $employeeId): ?Settings
    {
        return Settings::query()
            ->where('employee_id', $employeeId)
            ->first();
    }

    public function create(array $data)
    {
        return Settings::query()->create($data);
    }

    public function update(array $data, int $id): bool
    {
        return Settings::query()
            ->where('id', $id)
            ->update($data);
    }
}
