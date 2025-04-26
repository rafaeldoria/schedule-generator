<?php

namespace App\Enums;

enum StatusScheduleDetailsEnum: int
{
    case OPEN = 0;
    case SCHEDULED = 1;
    case CLOSED = 2;
}
