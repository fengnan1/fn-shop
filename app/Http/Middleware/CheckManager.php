<?php

namespace App\Http\Middleware;

use Closure;

class CheckManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$params)
    {
//        dd(auth()->check());
        if (!(auth('admin')->check())){
//            dd($params);
            return redirect(route('admin.login'))->withErrors(['error'=>'请先登录']);
        }
        return $next($request);
    }
}
