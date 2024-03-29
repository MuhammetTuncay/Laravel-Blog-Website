<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;


class isAdmin
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
        if (!Auth::check()) {
            return  redirect()->route('admin.login'); // giriş olup olmadığını kontrol eder giriş yoksa geri login sayfasına atar
        }
        return $next($request);
    }
}
