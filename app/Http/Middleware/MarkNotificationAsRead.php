<?php

namespace App\Http\Middleware;

use Closure;

class MarkNotificationAsRead
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
        if($request->has('n')) {
            if($request->user()->notifications()->whereId($request->n)->first()){
                $request->user()->notifications()->whereId($request->n)->first()->markAsRead();
            }
        }

        return $next($request);
    }
}
