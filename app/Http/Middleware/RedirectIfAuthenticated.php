<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->role === 'superadmin') {
                return redirect()->route('superadmin.dashboard');
            }

            if ($user->role === 'admin polda') {
                return redirect()->route('admin.polda.dashboard');
            }
            if ($user->role === 'admin polsek') {
                return redirect()->route('admin.polsek.dashboard');
            }
            if ($user->role === 'admin polres') {
                return redirect()->route('admin.polres.dashboard');
            }
            
            if ($user->role === 'pimpinan') {
                return redirect()->route('pimpinan.dashboard');
            }

            if ($user->role === 'user') {
                return redirect()->route('user.dashboard');
            }

            return redirect('/'); // default
        }

        return $next($request);
    }
}
