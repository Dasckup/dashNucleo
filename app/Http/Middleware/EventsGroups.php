<?php
namespace App\Http\Middleware;

use App\Models\EventsGroups as ModelsEventsGroups;

class EventsGroups{

    static public function get(){

        $groupsEvents = ModelsEventsGroups::where('active', true)->get();

        return $groupsEvents;
    }
}
