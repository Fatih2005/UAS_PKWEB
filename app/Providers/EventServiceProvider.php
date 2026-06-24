<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // Event logging bisa di-add nanti untuk audit log
    ];

    public function boot(): void
    {
        //
    }
}
