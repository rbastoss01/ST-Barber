<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
class EsCliente
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->esCliente()) {
            abort(403);
        }

        return $next($request);
    }
}