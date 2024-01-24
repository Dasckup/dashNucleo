<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateLastActivity implements ShouldQueue
{
    public function handle(UserLoggedIn $event)
    {
        $event->user->update(['last_activity' => now()]);
    }
}
