<?php

namespace App\Listeners;

use App\Events\ScheduleGenerateEvent;
use App\Services\ScheduleGeneratorService;

class ScheduleGenerateProcessListener
{
    public function __construct()
    {
    }

    public function handle(ScheduleGenerateEvent $event): array
    {
        $service = new ScheduleGeneratorService($event->settings);
        $service->handle();

        return $service->times;
    }
}
