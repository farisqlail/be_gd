<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Customer;

class TokenAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization'); // Ambil token dari header

        if (!$token || !Customer::where('api_token', $token)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        return $next($request);
    }
}
