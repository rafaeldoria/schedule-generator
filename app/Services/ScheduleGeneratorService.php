<?php

namespace App\Services;

use AllowDynamicProperties;
use App\Enums\DayOfWeekEnum;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;

/**
 * @property array $input
 * @property array $time
 * @property bool $breaks
 * @property int $total
 * @property int $totalBreaks
 * @property Carbon $day
 * @property Carbon $lastDayWeek
 * @property Carbon $lastDayOfMonth
 * @property Carbon $startTime
 * @property Carbon $endTime
 * @property array $times
 * @property Carbon $firstDay
 * @property string $endWeek
 */

#[AllowDynamicProperties] class ScheduleGeneratorService
{
    public function __construct(Request $request)
    {
        $this->breaks = false;
        $this->time = [];
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
                    $startBrake = Carbon::createFromTimeString($break['startTime']);
                    $endBrake = Carbon::createFromTimeString($break['endTime']);

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
            $this->times[$this->day->format('Y-m-d')] = [
                'totalTimes' => $this->total,
                'times' => $this->time,
            ];
        }
    }

    private function generateWeek(): void
    {
        $count = 1;
        while ($this->day->lte($this->lastDayWeek)) {
            if ($this->day->gte($this->lastDayOfMonth) && $this->input['recurrence'] >= 3) {
                $this->day->addDay();
                continue;
            }

            $this->time = [];

            $this->resetDailyTimes();
            $this->generateDaily();
            $this->times[$this->day->format('Y-m-d')] = [
                'totalTimes' => $this->total,
                'times' => $this->time,
            ];

            $this->day->addDay();
        }

        $addDaysEndWeek = $this->endWeek == DayOfWeekEnum::FRIDAY->value ? 2 : 1;
        $this->day->addDays($addDaysEndWeek);
    }

    private function generateMonth(): void
    {
        while ($this->day->lte($this->lastDayOfMonth)) {
            $this->generateWeek();
            $this->lastDayWeek = (clone $this->day)->next($this->endWeek);
        }
    }

    private function prepareDates(): void
    {
        if (isset($this->input['break'])) {
            $this->breaks = true;
        }

        $this->firstDay = Carbon::now();
        $this->setDayOne();

        $this->endWeek = isset($this->input['saturdayOff']) && $this->input['saturdayOff']
            ? DayOfWeekEnum::SATURDAY->value
            : DayOfWeekEnum::FRIDAY->value;

        $this->lastDayWeek = $this->day->isSameDay(Carbon::parse($this->endWeek))
            ? $this->day->copy()
            : $this->day->copy()->next($this->endWeek);

        $this->lastDayOfMonth = $this->day->copy()->endOfMonth();

        $this->resetDailyTimes();
    }

    private function resetDailyTimes(): void
    {
        $this->startTime = Carbon::parse($this->day->toDateString() . ' ' . $this->input['startTime']);
        $this->endTime = Carbon::parse($this->day->toDateString() . ' ' . $this->input['endTime']);

        if ($this->firstDay->gt($this->startTime)) {
            $this->startTime = $this->firstDay;
        }
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

    private function setDayOne():void
    {
        $this->day = Carbon::today();

        if ($this->day->isFriday() || $this->day->isSaturday() || $this->day->isSunday()) {
            $this->day->next(CarbonInterface::MONDAY);
        }
    }
}
