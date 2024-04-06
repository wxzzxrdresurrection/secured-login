<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (($request->user()->role_id == 1 || $request->ip() != '10.8.20.29')
            || ($request->user()->role_id == 3 || $request->ip() == '10.8.20.29')) {
            return redirect()->route('loginView');
        }

        return $next($request);
    }
}
