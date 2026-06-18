<?php
namespace App\Http\Middleware;
use Closure; use Illuminate\Http\Request; use Illuminate\Support\Facades\Auth;
class RoleMiddleware {
    public function handle(Request $request, Closure $next, string ...$roles): mixed {
        if (!Auth::check()) {
            return redirect()->route(in_array('admin',$roles) ? 'admin.login' : 'login');
        }
        $user = Auth::user();
        if (!in_array($user->role, $roles)) abort(403, 'Unauthorized.');
        if (!$user->is_active) { Auth::logout(); return redirect()->route('login')->withErrors(['email'=>'Account deactivated.']); }
        return $next($request);
    }
}
