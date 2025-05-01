<?php

namespace App\Services;

use App\Dtos\EmployeeDto;
use App\Dtos\EmployeeSettingsDto;
use App\Dtos\ScheduleDto;
use App\Events\ScheduleGenerateEvent;
use App\Events\ScheduleStoreEvent;
use App\Helpers\BreakingHelper;
use App\Models\Employee;
use App\Models\Schedule;
use App\Repositories\EmployeeRepository;
use App\Repositories\ScheduleRepository;
use Illuminate\Support\Facades\Event;

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
        $breakings = [];

        if (!empty($employeeSetting)) {
            $employeeSettingsDto = EmployeeSettingsDto::fromArray($employeeSetting->toArray());
            $settings = $employeeSettingsDto->toResponse($employeeSetting['id']) ?? [];

            $breakings = BreakingHelper::getBreakings($employeeSetting);
        }



        return [
            'employee' => $employeeDto->toResponse($employee['id']),
            'settings' => $settings,
            'breakings' => $breakings,
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

    public function generateSchedule(array $data): array
    {
        $schedule = $this->getSchedule($data['employee_id']);

        if (!empty($schedule)) {
            return $this->transformScheduleResponse($schedule);
        }

        $employee = $this->repository->findById($data['employee_id']);
        $settings = $employee->settings;

        if (empty($settings)) {
            return [];
        }

        $input = $settings->toArray();

        $input['breaks'] = BreakingHelper::getBreakings($settings);

        $input['recurrence'] = $data['recurrence'];

        $results = Event::dispatch(new ScheduleGenerateEvent($input));

        $times = $results[0] ?? [];

        if (empty($times)) {
            return [];
        }

        $schedule = Event::dispatch(new ScheduleStoreEvent($times, $employee->id));

        return $this->transformScheduleResponse($schedule[0]);
    }

    private function transformScheduleResponse(Schedule $schedule): array
    {
        $scheduleDto = new ScheduleDto($schedule->generated_schedule, $schedule->employee_id);

        return $scheduleDto->toResponse($schedule->id);
    }

    private function getSchedule(int $employeeId): ?Schedule
    {
        $scheduleRepository = new ScheduleRepository();
        return $scheduleRepository->getByEmployeeId($employeeId);
    }
}
