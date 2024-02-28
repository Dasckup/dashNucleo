<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventsLog extends Model
{
    use HasFactory;

    protected $table = "events_log";


    public function messages_sended(){
        return $this->hasMany(EventsLogMessageSended::class, 'log', 'id');
    }
}
