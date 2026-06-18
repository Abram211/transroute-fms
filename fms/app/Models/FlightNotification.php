<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class FlightNotification extends Model {
    protected $table = 'flight_notifications';
    protected $fillable = ['user_id','ticket_id','type','title','message','is_read','sent_at'];
    protected $casts = ['is_read'=>'boolean','sent_at'=>'datetime'];
    public function user(){ return $this->belongsTo(User::class); }
    public function ticket(){ return $this->belongsTo(Ticket::class); }
}
