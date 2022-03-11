<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        //  三个判断
        //  1.如果用户已经登陆
        //  2.并且还未认证 Email
        //  3.并且访问的不是 Email 验证相关的 URL 或者退出的 URL。
        if($request->user() &&
        ! $request->user()->hasVerifiedEmail() &&
        ! $request->is('email/*','logout')){

            //  根据客户端返回对应的内容
            return $request->expectsJson()
                ? abort(403,'Your email address is not verified')
                : redirect()->route('verification.notice');
        }

        return $next($request);
    }
}
