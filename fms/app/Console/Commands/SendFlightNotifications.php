<?php
namespace App\Console\Commands;
use App\Models\{Flight,Ticket,FlightNotification};
use App\Services\NotificationService;
use Illuminate\Console\Command;

class SendFlightNotifications extends Command {
    protected $signature = 'flights:notify';
    protected $description = 'Send 30-min-before-takeoff and arrival notifications to ticketed passengers';

    public function handle(NotificationService $service){
        $now = now();

        // 30 minutes before takeoff
        $upcoming = Flight::whereIn('status',['scheduled','boarding','delayed'])
            ->whereBetween('departure_time', [$now->copy()->addMinutes(29), $now->copy()->addMinutes(31)])
            ->get();
        foreach ($upcoming as $flight) {
            $tickets = $flight->tickets()->where('status','confirmed')->get();
            foreach ($tickets as $ticket) {
                $exists = FlightNotification::where('ticket_id',$ticket->id)->where('type','pre_takeoff')->exists();
                if (!$exists) $service->notifyPreTakeoff($ticket);
            }
        }

        // Arrival notifications
        $arrived = Flight::where('status','arrived')
            ->whereBetween('arrival_time', [$now->copy()->subMinutes(10), $now])
            ->get();
        foreach ($arrived as $flight) {
            $tickets = $flight->tickets()->whereIn('status',['confirmed','completed'])->get();
            foreach ($tickets as $ticket) {
                $exists = FlightNotification::where('ticket_id',$ticket->id)->where('type','arrival')->exists();
                if (!$exists) $service->notifyArrival($ticket);
            }
        }

        $this->info('Flight notifications processed.');
    }
}
