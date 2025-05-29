<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            // Redirect or return response if user is not authenticated
            return redirect('/login');
        }

        foreach ($roles as $role) {
            if ($user->role == $role) {
                return $next($request);
            }
        }

        // Redirect or return response if user does not have the required role
        return redirect('/unauthorized');
    }
}
