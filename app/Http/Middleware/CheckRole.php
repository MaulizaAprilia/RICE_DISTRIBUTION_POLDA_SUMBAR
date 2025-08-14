<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Anda harus login atau mendaftar dulu sebelum mengakses halaman ini.',
            ]);
        }
    
        $user = Auth::user();
    
        if ($user->role !== $role) {
            return redirect()->back()
            ->with('alert', [
                'type' => 'error',
                'title' => 'Gagal',
                'text' => 'Anda tidak memiliki izin untuk mengakses halaman ini',
            ]);
                
        }
    
        return $next($request);
    }
}
