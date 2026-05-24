<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
class EsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->esAdmin()) {
            abort(403);
        }

        return $next($request);
    }
}