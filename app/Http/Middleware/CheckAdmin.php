<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('user_id')) {

            return redirect()->route('login')->with('error', 'Please Login First');
        }


        if (session('role') !== 'admin') {

            return redirect()->route('login')->with('error', 'Your are Not Admin');
        }
        return $next($request);
    }
}
