<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    // Passenger login
    public function showLoginForm(){
        if (Auth::check()) return redirect()->route(Auth::user()->getDashboardRoute());
        return view('auth.login');
    }
    public function login(Request $request){
        $creds = $request->validate(['email'=>'required|email','password'=>'required']);
        if (Auth::attempt($creds, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->role !== 'passenger') { Auth::logout(); return back()->withErrors(['email'=>'Please use the admin login page.']); }
            if (!$user->is_active) { Auth::logout(); return back()->withErrors(['email'=>'Account deactivated. Contact admin.']); }
            return redirect()->route('passenger.dashboard');
        }
        return back()->withErrors(['email'=>'These credentials do not match our records.'])->onlyInput('email');
    }

    // Admin login (separate page)
    public function showAdminLoginForm(){
        if (Auth::check() && Auth::user()->isAdmin()) return redirect()->route('admin.dashboard');
        return view('auth.admin-login');
    }
    public function adminLogin(Request $request){
        $creds = $request->validate(['email'=>'required|email','password'=>'required']);
        if (Auth::attempt($creds, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();
            if ($user->role !== 'admin') { Auth::logout(); return back()->withErrors(['email'=>'This portal is for administrators only.']); }
            if (!$user->is_active) { Auth::logout(); return back()->withErrors(['email'=>'Account deactivated.']); }
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors(['email'=>'These credentials do not match our records.'])->onlyInput('email');
    }

    public function logout(Request $request){
        $wasAdmin = Auth::check() && Auth::user()->isAdmin();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route($wasAdmin ? 'admin.login' : 'login')->with('success','Logged out successfully.');
    }
}
