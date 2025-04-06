<?php

namespace App\Http\Middleware;

use App\Trait\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,$role): Response
    {
        $user = Auth::user();
        if (!$user) {
            return $this->errorResponse('error', 401);
        }
        if (!$user->hasRole($role))
        {
            return  $this->errorResponse('you dont have a Permission',401 );
        }
        return $next($request);
    }
}
