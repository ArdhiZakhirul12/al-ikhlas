<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check() || ! Auth::user()->is_admin || ! $request->session()->get('admin_logged_in')) {
            return redirect()->route('admin.login')->withErrors([
                'password' => 'Silakan login admin terlebih dahulu.',
            ]);
        }

        return $next($request);
    }
}
