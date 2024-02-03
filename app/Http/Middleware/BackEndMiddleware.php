<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class BackEndMiddleware
{
    protected  $auth;


    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    

    public function handle($request, Closure $next)
    {
        if (!$this->auth->guest()) {
            if($this->auth->user()->type == "teacher" || $this->auth->user()->type == "sub-administrator" || $this->auth->user()->type == "administrator"){
                return $next($request);
            }else{
                return redirect()->guest('/');
            }
        }
    }
}
