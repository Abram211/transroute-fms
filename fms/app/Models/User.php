<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable {
    use HasFactory, Notifiable;
    protected $fillable = ['name','email','phone','password','role','is_active'];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['password'=>'hashed','is_active'=>'boolean'];
    public function isAdmin():bool { return $this->role === 'admin'; }
    public function isPassenger():bool { return $this->role === 'passenger'; }
    public function tickets(){ return $this->hasMany(Ticket::class); }
    public function flightNotifications(){ return $this->hasMany(FlightNotification::class)->latest(); }
    public function getDashboardRoute():string { return match($this->role){'admin'=>'admin.dashboard','passenger'=>'passenger.dashboard',default=>'login'}; }
}
