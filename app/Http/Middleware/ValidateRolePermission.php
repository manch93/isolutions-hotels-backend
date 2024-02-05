<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ValidateRolePermission
{
    public function handle(Request $request, Closure $next): Response
    {
        $route = $request->route()->getName();
        $permission = 'view.' . $route;

        if(!Auth::user()->can($permission)) {
            throw new HttpResponseException(response()->json([
                'code' => 403,
                'message' => 'You do not have permission.'
            ], 403));
        }

        return $next($request);
    }
}

