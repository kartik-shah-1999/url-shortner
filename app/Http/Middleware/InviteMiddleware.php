<?php

namespace App\Http\Middleware;

use App\RoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InviteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $loggedInUserRole = auth()->user()->roles[0]->pivot->user_role;
        if($loggedInUserRole === RoleEnum::MEMBER){
            abort('405');
        }
        return $next($request);
    }
}
