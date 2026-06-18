<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Shipment extends Model {
    protected $fillable = ['shipment_no','flight_id','ticket_id','sender_name','sender_phone','receiver_name','receiver_phone','description','weight','fee','status'];
    public function flight(){ return $this->belongsTo(Flight::class); }
    public function ticket(){ return $this->belongsTo(Ticket::class); }
}
