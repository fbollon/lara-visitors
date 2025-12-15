<?php

namespace Fbollon\LaraVisitors\Http\Middleware;

use Closure;

class LaraVisitorsAccess
{
    public function handle($request, Closure $next)
    {
        // Simple example: access restricted to authenticated users with admin role
        if (!auth()->check() || !auth()->user()->hasRole('admin')) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}