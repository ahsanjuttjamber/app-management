<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ShopAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('shop_logged_in')) {
            return redirect('/shop-login');
        }
        return $next($request);
    }
}
