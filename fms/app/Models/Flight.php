<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Flight extends Model {
    protected $fillable = ['flight_number','airline','departure_airport_id','arrival_airport_id','departure_time','arrival_time','gate','capacity','base_fare','status'];
    protected $casts = ['departure_time'=>'datetime','arrival_time'=>'datetime'];
    public function departureAirport(){ return $this->belongsTo(Airport::class,'departure_airport_id')->withDefault(['city'=>'Unknown','code'=>'—']); }
    public function arrivalAirport(){ return $this->belongsTo(Airport::class,'arrival_airport_id')->withDefault(['city'=>'Unknown','code'=>'—']); }
    public function tickets(){ return $this->hasMany(Ticket::class); }
    public function shipments(){ return $this->hasMany(Shipment::class); }
    public function crewMembers(){ return $this->belongsToMany(CrewMember::class,'flight_crew_member'); }
    public function getJourneyAttribute():string { return $this->departureAirport->code.' → '.$this->arrivalAirport->code; }
    public function getBookedSeatsCountAttribute():int { return $this->tickets()->whereIn('status',['pending','confirmed'])->count(); }
    public function getSeatsAvailableAttribute():int { return max(0, $this->capacity - $this->booked_seats_count); }
    public function isPast():bool { return now()->gt($this->arrival_time); }
}
