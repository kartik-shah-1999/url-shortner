<?php

namespace App\Http\Middleware;

use App\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UrlshortnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $loggedInUser = auth()->user()->roles[0]->pivot->user_role;
        if($loggedInUser === RoleEnum::SUPERADMIN){
            abort(403);
        }
        if($loggedInUser === RoleEnum::ADMIN || $loggedInUser === RoleEnum::MEMBER){
            if(is_null(auth()->user()->company)){
                abort(403);
            }
        }
        return $next($request);
    }
}
