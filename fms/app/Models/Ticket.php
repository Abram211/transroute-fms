<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Ticket extends Model {
    protected $fillable = ['ticket_no','user_id','flight_id','seat_no','fare','status','checked_in_at'];
    protected $casts = ['checked_in_at'=>'datetime'];
    public function passenger(){ return $this->belongsTo(User::class,'user_id'); }
    public function flight(){ return $this->belongsTo(Flight::class); }
    public function luggages(){ return $this->hasMany(Luggage::class); }
    public function shipments(){ return $this->hasMany(Shipment::class); }
    public function notifications(){ return $this->hasMany(FlightNotification::class); }
    public function isCancellable():bool { return in_array($this->status,['pending','confirmed']) && now()->lt($this->flight->departure_time); }
}
