<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    protected $table = 'events';

    public function groups(){
        return $this->hasOne(EventsGroups::class, 'id', 'to');
    }

    public function events_business_hours(){
        return $this->hasOne(EventsBusinessHours::class, 'events', 'id');
    }

    public function intentions(){
        return $this->hasOne(EventsIntentionSubmition::class, 'events', 'id');
    }

    public function log(){
        return $this->hasMany(EventsLog::class, 'events', 'id')->with('messages_sended')->orderBy('created_at', 'desc');
    }

    public function log_updates(){
        return $this->hasMany(EventsLogUpdates::class, 'events', 'id')->orderBy('created_at', 'desc');
    }
}
