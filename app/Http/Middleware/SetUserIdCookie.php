<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetUserIdCookie
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!isset($_COOKIE['user_id'])){
            setcookie('user_id', uniqid(), time() + (86400 * 30), "/");
        }

        if(isset($_COOKIE['user_id'])){
            return $next($request);
        }else{
            return redirect()->route('home');
        }
    }
}
