<?php
namespace App\Services;
use App\Models\{Ticket,Flight,FlightNotification};

class NotificationService {
    public function notifyBookingConfirmed(Ticket $ticket): void {
        FlightNotification::create([
            'user_id'=>$ticket->user_id,
            'ticket_id'=>$ticket->id,
            'type'=>'booking_confirmed',
            'title'=>'Booking Confirmed',
            'message'=>"Your booking for flight {$ticket->flight->flight_number} ({$ticket->flight->journey}) has been confirmed.",
            'sent_at'=>now(),
        ]);
    }

    public function notifyBookingCancelled(Ticket $ticket): void {
        FlightNotification::create([
            'user_id'=>$ticket->user_id,
            'ticket_id'=>$ticket->id,
            'type'=>'booking_cancelled',
            'title'=>'Booking Cancelled',
            'message'=>"Your booking {$ticket->ticket_no} for flight {$ticket->flight->flight_number} has been cancelled.",
            'sent_at'=>now(),
        ]);
    }

    public function notifyFlightDelayed(Flight $flight): void {
        foreach ($flight->tickets()->whereIn('status',['pending','confirmed'])->get() as $ticket) {
            FlightNotification::create([
                'user_id'=>$ticket->user_id,
                'ticket_id'=>$ticket->id,
                'type'=>'flight_delayed',
                'title'=>'Flight Delayed',
                'message'=>"Flight {$flight->flight_number} ({$flight->journey}) has been delayed. New departure: {$flight->departure_time->format('M d, h:i A')}.",
                'sent_at'=>now(),
            ]);
        }
    }

    public function notifyPreTakeoff(Ticket $ticket): void {
        FlightNotification::create([
            'user_id'=>$ticket->user_id,
            'ticket_id'=>$ticket->id,
            'type'=>'pre_takeoff',
            'title'=>'30 Minutes Before Takeoff',
            'message'=>"Flight {$ticket->flight->flight_number} is boarding soon. Proceed to Gate {$ticket->flight->gate}.",
            'sent_at'=>now(),
        ]);
    }

    public function notifyArrival(Ticket $ticket): void {
        FlightNotification::create([
            'user_id'=>$ticket->user_id,
            'ticket_id'=>$ticket->id,
            'type'=>'arrival',
            'title'=>'Arrival Confirmed',
            'message'=>"Flight {$ticket->flight->flight_number} has landed at {$ticket->flight->arrivalAirport->city}.",
            'sent_at'=>now(),
        ]);
    }
}
