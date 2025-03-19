<?php

namespace App\Services;

use App\Dtos\EmployeeDto;
use App\Dtos\EmployeeSettingsDto;
use App\Models\Employee;
use App\Repositories\EmployeeRepository;

class EmployeeService
{
    private const AVAILABLE_DEFAULT = true;

    public function __construct(protected EmployeeRepository $repository)
    {
    }

    public function getAll(): array
    {
        return $this->repository->all();
    }

    public function getById(int $id): array
    {
        $employee = $this->repository->findById($id);

        if (empty($employee)) {
            return [];
        }

        $employeeDto = EmployeeDto::fromArray($employee->toArray());
        $employeeSetting = $employee->settings;

        $settings = [];

        if (!empty($employeeSetting)) {
            $employeeSettingsDto = EmployeeSettingsDto::fromArray($employeeSetting->toArray());
            $settings = $employeeSettingsDto->toResponse($employeeSetting['id']) ?? [];
        }

        return [
            'employee' => $employeeDto->toResponse($employee['id']),
            'settings' => $settings,
        ];
    }

    public function createEmployee(array $data): Employee
    {
        $employeeDto = new EmployeeDto(
            $data['full_name'],
            $data['email'],
            $data['function'],
            self::AVAILABLE_DEFAULT,
        );

        return $this->repository->create($employeeDto->toArray());
    }

    public function updateEmployee(array $data, int $id): bool
    {
        $employeeDto = new EmployeeDto(
            $data['full_name'],
            $data['email'],
            $data['function'],
            $data['available']
        );

        return $this->repository->update($employeeDto->toArray(), $id);
    }
}
