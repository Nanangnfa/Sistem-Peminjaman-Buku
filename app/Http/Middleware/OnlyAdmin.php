<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OnlyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // disini kita ngasih tau apa yg harus dilakukan kalo akun yg lagi login bukan admin
        if(Auth::user()->role_id != 1) {
            return redirect('/');
        }

        // apa yg dilakukan middleware ketika yg login admin?
        return $next($request);
    }
}
