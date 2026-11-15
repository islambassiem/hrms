<?php

namespace App\Http\Middleware;

use App\Models\Employee\Employee;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureDepartmentHead
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $head = $request->user()?->employee;

        abort_unless($head instanceof Employee, 403);

        $request->attributes->set('head', $head);

        return $next($request);
    }
}
