<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class StudentMiddleware
{
    protected  $auth;


    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }


    public function handle($request, Closure $next)
    {
        if (!$this->auth->guest()) {
            if($this->auth->user()->type == "student"){
                if($this->auth->user()->status == 'waiting'){
                    return redirect()->back()->withErrors(['username' => '관리자에게 수강상태 확인요청 바랍니다']);
                }

                return $next($request);
            }else{
                return redirect()->guest('/')->withErrors(['username' => '관리자에게 수강상태 확인요청 바랍니다']);
            }
        }
    }
}
