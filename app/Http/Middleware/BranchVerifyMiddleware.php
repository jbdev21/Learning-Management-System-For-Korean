<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\BranchService;

class BranchVerifyMiddleware
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
        if((new BranchService)->branchFromRequest()){
            return $next($request);
        }

        return abort(config('branch.undefined_status_code'));
    }
}
