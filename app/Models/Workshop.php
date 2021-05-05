<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class Workshop extends Model
{

    public function getEventsWithWorkshops()
    {
        $workshops = DB::table('workshops')->get();
        $events = DB::table('events')->get();

        foreach ($events as &$event) {
            $event->workshops = [];
            foreach ($workshops as $ws) {
                if ($ws->event_id == $event->id) {
                    $event->workshops[] = $ws;
                }
            }
        }

        return $events;
    }
}
