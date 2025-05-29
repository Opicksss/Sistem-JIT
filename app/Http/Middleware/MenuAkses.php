<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MenuAkses
{
    public function handle(Request $request, Closure $next, $menuName)
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return $next($request);
        }

        if ($user->menus->pluck('name')->contains($menuName)) {
            return $next($request);
        }

        return redirect()->back()->with('error', 'No Akses!');
    }
}
