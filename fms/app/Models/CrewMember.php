<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CrewMember extends Model {
    protected $fillable = ['name','role','phone','email','salary','status'];
    public function flights(){ return $this->belongsToMany(Flight::class,'flight_crew_member'); }
}
