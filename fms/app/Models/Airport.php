<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Airport extends Model {
    protected $fillable = ['code','name','city','country'];
    public function departingFlights(){ return $this->hasMany(Flight::class,'departure_airport_id'); }
    public function arrivingFlights(){ return $this->hasMany(Flight::class,'arrival_airport_id'); }
    public function getLabelAttribute():string { return "{$this->city} ({$this->code})"; }
}
