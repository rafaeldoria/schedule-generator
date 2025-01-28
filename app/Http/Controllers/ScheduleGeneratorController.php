<?php

namespace App\Http\Controllers;

use AllowDynamicProperties;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @property array $input
 * @property array $time
 * @property bool $breaks
 * @property int $total
 * @property int $totalBreaks
 * @property Carbon $today
 * @property Carbon $lastDayWeek
 * @property Carbon $lastDayOfMonth
 * @property Carbon $startTime
 * @property Carbon $endTime
 * @property array $times
 */

#[AllowDynamicProperties] class ScheduleGeneratorController
{
    public function index(Request $request): JsonResponse
    {
        $this->input = $request->all();

        $this->prepareDates();

        switch ($this->input['recurrence']) {
            case '2' :
                $this->generateWeek();
                break;
            case '3' :
                $this->generateMonth();
                break;
            case '1':
            default :
                $this->generateDaily();
                break;
        }

        if ($this->input['recurrence'] === 1) {
            $this->times[$this->today->format('Y-m-d')] = [
                'totalTimes' => $this->total,
                'times' => $this->time,
            ];
        }

        return response()->json([
            'data' => $this->times
        ]);
    }

    private function generateDaily(): void
    {
        $this->setTotalBreaks();
        $this->resetTotal();

        while ($this->startTime->lt($this->endTime)) {
            $this->total ++;

            if ($this->breaks && $this->totalBreaks > 0) {
                foreach ($this->input['break'] as $break) {
                    $startBrake = Carbon::createFromTimeString($break['startBrake']);
                    $endBrake = Carbon::createFromTimeString($break['endBrake']);

                    if ($this->startTime->gte($startBrake) && $this->startTime->lt($endBrake)) {
                        $minutesDiff = $startBrake->diffInMinutes($endBrake);
                        $this->startTime->addMinutes($minutesDiff);
                        $this->totalBreaks --;
                        break;
                    }
                }
            }

            $this->time[] = [
                'time' => $this->startTime->format('H:i:s'),
                'status' => 1,
            ];

            $this->startTime->addMinutes($this->input['duration'] + $this->input['interval']);
        }
    }

    private function generateWeek(): void
    {
        while ($this->today->lte($this->lastDayWeek)) {
            if ($this->today->gte($this->lastDayOfMonth) && $this->input['recurrence'] >= 3) {
                $this->today->addDay();
                continue;
            }

            $this->time = [];

            $this->resetDailyTime();
            $this->generateDaily();
            $this->times[$this->today->format('Y-m-d')] = [
                'totalTimes' => $this->total,
                'times' => $this->time,
            ];
            $this->today->addDay();
        }
    }

    private function generateMonth(): void
    {
        while ($this->today->lte($this->lastDayOfMonth)) {
            $this->generateWeek();
        }
    }

    private function prepareDates(): void
    {
        if (isset($this->input['break'])) {
            $this->breaks = true;
        }

        $this->today = Carbon::today();

        $endWeek = isset($this->input['saturdayOff']) && $this->input['saturdayOff'] ? 'Friday' : 'Saturday';
        $this->lastDayWeek = Carbon::now()->next($endWeek);

        $this->lastDayOfMonth = $this->today->copy()->endOfMonth();

        $this->resetDailyTime();
    }

    private function resetDailyTime(): void
    {
        $this->startTime = Carbon::createFromTimeString($this->input['startTime']);
        $this->endTime = Carbon::createFromTimeString($this->input['endTime']);
    }

    private function resetTotal(): void
    {
        $this->total = 0;
    }

    private function setTotalBreaks():void
    {
        if ($this->breaks) {
            $this->totalBreaks = count($this->input['break']);
        }
    }
}
