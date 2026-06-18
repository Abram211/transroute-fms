<?php
namespace App\Http\Middleware;
use Closure; use Illuminate\Http\Request; use Illuminate\Support\Facades\Auth;
class RedirectIfAuthenticated {
    public function handle(Request $request, Closure $next, string ...$guards): mixed {
        if (Auth::check()) return redirect()->route(Auth::user()->getDashboardRoute());
        return $next($request);
    }
}
