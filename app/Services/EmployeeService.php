<?php

namespace App\Services;

use App\Dtos\EmployeeDto;
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

        return $employeeDto->toResponse($employee['id']);
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
