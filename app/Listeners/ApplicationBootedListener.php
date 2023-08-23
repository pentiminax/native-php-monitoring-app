<?php

namespace App\Listeners;

use Native\Laravel\Events\App\ApplicationBooted;
use Native\Laravel\Notification;


class ApplicationBootedListener
{
    public function handle(ApplicationBooted $event): void
    {
        Notification::new()
            ->title('Welcome back, artisan!')
            ->message('Hello from Laravel')
            ->show();
    }
}
