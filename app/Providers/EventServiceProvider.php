<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\SomeEvent;
use App\Listeners\SomeListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SomeEvent::class => [
            SomeListener::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
