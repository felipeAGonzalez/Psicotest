<?php

namespace App\Http\Middleware;

use App\Helpers\Lang;
use App\Helpers\Response;
use Closure;
use Exception;

class IsRootMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if (! $request->user->is_root) {
                return Response::json(Lang::get('api.user_no_is_root'), 401);
            }

            return $next($request);
        } catch (Exception $e) {
            return Response::json($e);
        }
    }
}
