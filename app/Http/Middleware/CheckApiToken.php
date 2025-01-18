<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah token API ada di session
        if (!$request->session()->has('token')) {
            return redirect()->route('login.index')->withErrors('Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}
