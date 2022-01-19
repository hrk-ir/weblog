<?php

namespace Modules\Dashboard\Http\Middleware;

use Modules\User\Entities\User;
use Closure;
use Illuminate\Http\Request;

class RedirectIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth('api')->user()->role == User::ROLE_ADMIN) {
            return $next($request);
        }
        return response()->json('unauthorized');
    }
}
