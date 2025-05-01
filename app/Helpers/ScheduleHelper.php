<?php

namespace App\Helpers;

use Carbon\Carbon;

class ScheduleHelper
{
    public static function validateLastDateSchedule(string $generated_schedule): bool
    {
        $lastDateSchedule = Carbon::parse(array_key_last(json_decode($generated_schedule, true)));

        return $lastDateSchedule->lt(Carbon::today());
    }
}
