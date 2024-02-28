<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Auth\Authenticatable;

class UserLoggedIn
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
    }
}
