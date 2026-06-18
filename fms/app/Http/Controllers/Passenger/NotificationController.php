<?php
namespace App\Http\Controllers\Passenger;
use App\Http\Controllers\Controller;
use App\Models\FlightNotification;
use Illuminate\Support\Facades\Auth;
class NotificationController extends Controller {
    public function markRead(FlightNotification $notification){
        abort_unless($notification->user_id === Auth::id(), 403);
        $notification->update(['is_read'=>true]);
        return back();
    }
}
