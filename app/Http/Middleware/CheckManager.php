<?php

namespace App\Http\Middleware;

use Closure;

class CheckManager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $params)
    {
//        dd(auth()->check());
        if (!(auth('admin')->check())) {
//            dd($params);
            return redirect(route('admin.login'))->withErrors(['error' => '请先登录']);
        }
        if (auth('admin')->user()->username!=config('rbac.super')){
            //当前用户拥有的权限  清空 合并
            $auth=array_merge(array_filter(session('admin.node')),config('rbac.allow_route'));
            //当前访问的权限
            $currentRoute = $request->route()->getName();
            if (!in_array($currentRoute,$auth)){
                exit('你没有权限');
            }

        }

//dd($auth);


//        dd($currentRoute);

        return $next($request);
    }
}
