<?php

namespace App\Listeners;

use App\Events\ScheduleStoreEvent;
use App\Models\Schedule;
use App\Services\ScheduleService;

readonly class ScheduleStoreProcessListener
{
    public function __construct(
        private ScheduleService $scheduleDetailsService
    ) {
    }

    public function handle(ScheduleStoreEvent $event): Schedule
    {
        return $this->scheduleDetailsService->store($event->times, $event->employeeId);
    }
}
