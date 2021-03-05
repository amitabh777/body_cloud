<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
    }

   public function handle($request, Closure $next, ...$guards)
   {
    if (Auth::guard('api')->guest()) {
        if ($request->ajax() || $request->wantsJson()) {
            return response('Unauthorized.', 401);
        } else {
            $response = [
                'status' => 401,
                'message' => 'Unauthorized'
            ];
            return Response::json($response);
        }
    }
    // $user = User::where('api_token',$request->api_token)->first();
    // Auth::loginUsingId($user->UserID);
    // Log::info($request->api_token);

    return $next($request);
   }
}
