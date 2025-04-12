<?php

namespace App\Providers;

use App\Events\ScheduleGenerateEvent;
use App\Events\ScheduleStoreEvent;
use App\Events\TesteEvent;
use App\Listeners\ScheduleGenerateProcessListener;
use App\Listeners\ScheduleStoreProcessListener;
use Carbon\Laravel\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Mockery\Adapter\Phpunit\TestListener;

class EventServiceProvider extends ServiceProvider
{
    protected array $listen = [
        ScheduleStoreEvent::class => [
            ScheduleStoreProcessListener::class
        ],
        ScheduleGenerateEvent::class => [
            ScheduleGenerateProcessListener::class
        ],
    ];

    public function boot(): void
    {
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
