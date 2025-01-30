<?php

namespace Tests\Unit;

use App\Services\ScheduleGeneratorService;
use Illuminate\Http\Request;
use Tests\TestCase;
use Carbon\Carbon;

class ScheduleGeneratorServiceTest extends TestCase
{
    public function testGenerateDailyWithoutBreaks()
    {
        $request = new Request([
            'recurrence' => '1',
            'startTime' => '08:00:00',
            'endTime' => '10:00:00',
            'duration' => 30,
            'interval' => 10,
        ]);

        $service = new ScheduleGeneratorService($request);
        $service->handle();

        $this->assertArrayHasKey(Carbon::today()->format('Y-m-d'), $service->times);
        $this->assertNotEmpty($service->times[Carbon::today()->format('Y-m-d')]['times']);
    }

    public function testGenerateDailyWithBreaks()
    {
        $request = new Request([
            'recurrence' => '1',
            'startTime' => '08:00:00',
            'endTime' => '12:00:00',
            'duration' => 30,
            'interval' => 10,
            'break' => [
                ['startBrake' => '09:00:00', 'endBrake' => '09:30:00'],
                ['startBrake' => '10:30:00', 'endBrake' => '11:00:00'],
            ],
        ]);

        $service = new ScheduleGeneratorService($request);
        $service->handle();

        $this->assertArrayHasKey(Carbon::today()->format('Y-m-d'), $service->times);
        $times = $service->times[Carbon::today()->format('Y-m-d')]['times'];
        $this->assertNotEmpty($times);
        $this->assertFalse(in_array(['time' => '09:00:00', 'status' => 1], $times));
        $this->assertFalse(in_array(['time' => '10:30:00', 'status' => 1], $times));
    }

    public function testGenerateWeek()
    {
        $request = new Request([
            'recurrence' => '2',
            'startTime' => '08:00:00',
            'endTime' => '10:00:00',
            'duration' => 30,
            'interval' => 10,
        ]);

        $service = new ScheduleGeneratorService($request);
        $service->handle();

        $this->assertNotEmpty($service->times);
        $this->assertGreaterThan(1, count($service->times));
    }

    public function testGenerateMonth()
    {
        $request = new Request([
            'recurrence' => '3',
            'startTime' => '08:00:00',
            'endTime' => '10:00:00',
            'duration' => 30,
            'interval' => 10,
        ]);

        $service = new ScheduleGeneratorService($request);
        $service->handle();

        $this->assertNotEmpty($service->times);
        $this->assertGreaterThan(1, count($service->times));
    }
}
