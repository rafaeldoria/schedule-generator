<?php

namespace App\Services;

use AllowDynamicProperties;
use App\Enums\DayOfWeekEnum;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

#[AllowDynamicProperties] class ScheduleGeneratorService
{
    public function __construct(Request $request)
    {
        $this->input = $request->all();
        $this->prepareDates();
    }

    public function handle(): void
    {
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

        if ($this->input['recurrence'] == 1) {
            $this->times[$this->today->format('Y-m-d')] = [
                'totalTimes' => $this->total,
                'times' => $this->time,
            ];
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

            $this->resetDailyTimes();
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

        $endWeek = isset($this->input['saturdayOff']) && $this->input['saturdayOff']
            ? DayOfWeekEnum::FRIDAY->value
            : DayOfWeekEnum::SATURDAY->value;

        $this->lastDayWeek = Carbon::now()->next($endWeek);

        $this->lastDayOfMonth = $this->today->copy()->endOfMonth();

        $this->resetDailyTimes();
    }

    private function resetDailyTimes(): void
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
