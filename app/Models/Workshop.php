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

    public function getFutureEventsWithWorkshops()
    {
        $workshops = DB::table('workshops')->get();
        $events = DB::table('events')
            ->join('workshops', 'workshops.event_id', '=', 'events.id')
            ->where('workshops.start', '>', date('Y-m-d'))
            ->limit(3)
            ->get();

        foreach ($events as $key => &$event) {
            $event->workshops = [];
            foreach ($workshops as $ws) {
                if ($ws->event_id == $event->id) {
                    $event->workshops[] = $ws;
                }
            }

            if (empty($event->workshops)) {
                unset($events[$key]);
            }
        }

        return $events;
    }
}
