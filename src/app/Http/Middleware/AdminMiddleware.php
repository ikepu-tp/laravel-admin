<?php

namespace ikepu_tp\LaravelAdmin\app\Http\Middleware;

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
        if (!$request->user(config("laravelAdmin.guard", "web"))->user_grants()->where('grant', 0)->exists()) abort(403);
        return $next($request);
    }
}
