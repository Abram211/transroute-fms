<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Luggage extends Model {
    protected $fillable = ['luggage_code','ticket_id','item_type','description','weight','fee','status'];
    public function ticket(){ return $this->belongsTo(Ticket::class); }
}
