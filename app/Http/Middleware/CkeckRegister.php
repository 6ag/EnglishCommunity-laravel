<?php

namespace App\Http\Middleware;

use App\Http\Model\Option;
use Closure;

class CkeckRegister
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
        $option = Option::where('name', 'is_allow_register')->first();
        if ($option->content == '0') {
            return redirect()->route('admin.login')->with('errors', '管理员注册已经关闭');
        }
        return $next($request);
    }
}
