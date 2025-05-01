<?php

namespace App\Services;

use App\Dtos\CustomerDto;
use App\Dtos\ScheduleDetailsDto;
use App\Models\Customer;
use App\Models\Schedule;
use App\Repositories\CustomerRepository;
use App\Repositories\ScheduleDetailsRepository;
use App\Repositories\ScheduleRepository;

class ScheduleDetailsService
{
    private Schedule $schedule;
    private array $generatedSchedules = [];
    private array $time = [];
    private Customer $customer;
    private int $timeKey;

    public function __construct(
        protected ScheduleDetailsRepository $scheduleDetailsRepository,
        protected array $request
    ) {
    }

    public function getById(int $id): array
    {
        $schedulteDetails = $this->scheduleDetailsRepository->getById($id);

        if (empty($schedulteDetails)) {
            return [];
        }

        $schedulteDetailsDto = new ScheduleDetailsDto(
            $schedulteDetails->date,
            $schedulteDetails->time,
            $schedulteDetails->schedule_id,
            $schedulteDetails->customer_id,
            $schedulteDetails->status,
        );

        return $schedulteDetailsDto->toResponse($schedulteDetails->id);
    }

    public function store(): array
    {
        $this->setSchedule();

        if (empty($this->schedule)) {
            return [];
        }

        if (!$this->validatedSchedule()) {
            return [];
        }

        $this->createCustomer();

        $scheduleDetailsDto = new ScheduleDetailsDto(
            $this->request['date'],
            $this->request['time'],
            $this->request['schedule_id'],
            $this->customer->id,
        );

        if (isset($this->time['scheduleDetailsId'])) {
            $scheduleDetails = $this->scheduleDetailsRepository->update(
                $scheduleDetailsDto->toArray(),
                $this->time['scheduleDetailsId']
            );

            $this->updateSchedule($scheduleDetailsDto->status, $scheduleDetails->id);

            return $scheduleDetailsDto->toResponse($scheduleDetailsDto->scheduleId) ?? [];
        }

        $scheduleDetails = $this->scheduleDetailsRepository->store($scheduleDetailsDto->toArray());

        $this->updateSchedule($scheduleDetailsDto->status, $scheduleDetails->id);

        return $scheduleDetailsDto->toResponse($scheduleDetailsDto->scheduleId) ?? [];
    }

    private function setSchedule(): void
    {
        $scheduleRepository = new ScheduleRepository();
        $this->schedule = $scheduleRepository->getById($this->request['schedule_id']);
    }

    private function createCustomer(): void
    {
        $customerRepository = new CustomerRepository();
        $customerDto = new CustomerDto(
            $this->request['full_name'],
            $this->request['email'],
            $this->request['cellphone'],
        );
        $this->customer = $customerRepository->store($customerDto->toArray());
    }

    private function validatedSchedule(): bool
    {
        $this->generatedSchedules = json_decode($this->schedule->generated_schedule, true);

        if (!isset($this->generatedSchedules[$this->request['date']])) {
            return false;
        }

        foreach ($this->generatedSchedules[$this->request['date']]['times'] as $key => $timeEntry) {
            if ($timeEntry['time'] === $this->request['time']) {
                $this->time = $timeEntry;
                $this->timeKey = $key;

                return true;
            }
        }

        return false;
    }

    private function updateSchedule(string $status, int $scheduleDetailsId): void
    {
        $this->time['status'] = $status;
        $this->time['scheduleDetailsId'] = $scheduleDetailsId;

        $this->generatedSchedules[$this->request['date']]['times'][$this->timeKey] = $this->time;

        $this->schedule->generated_schedule = json_encode($this->generatedSchedules);
        $this->schedule->save();
    }
}
