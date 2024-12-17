<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        try {
            return $next($request);
        } catch (QueryException $e) {
            // Log the error for further analysis
            Log::error('Database connection error', ['exception' => $e]);

            // Redirect to the login page with an error message
            return redirect('/login')->with('error', 'Connection Problem: Unable to connect to the database.');
        } catch (\Throwable $th) {
            // Log other types of errors
            Log::error('Error in middleware handle method', ['exception' => $th]);

            // Redirect to the login page with a general error message
            return redirect('/login')->with('error', 'Connection Problem');
        }
    }
}
