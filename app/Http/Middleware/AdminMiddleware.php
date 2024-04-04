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
        if (($request->user()->role->id == 1 || $request->ip() != '192.168.1.2')|| ($request->user()->role->id == 3 || $request->ip() == '192.168.1.2')){
            return redirect()->route('loginView');
        }

        return $next($request);
    }
}
