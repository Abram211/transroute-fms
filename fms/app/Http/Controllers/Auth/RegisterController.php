<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth,Hash};

class RegisterController extends Controller {
    public function showRegistrationForm(){
        return view('auth.register');
    }
    public function register(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|email|unique:users',
            'phone'=>'nullable|string|max:20',
            'password'=>'required|min:8|confirmed',
        ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>Hash::make($request->password),
            'role'=>'passenger',
            'is_active'=>true,
        ]);
        Auth::login($user);
        return redirect()->route('passenger.dashboard')->with('success','Welcome to TransRoute! Your account has been created.');
    }
}
