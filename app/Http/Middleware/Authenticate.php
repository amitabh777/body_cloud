<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
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
        dd('fdshfgdshjgfhj');
        if (!$request->expectsJson()) {
            //Check if request is from backend/super admin
            if (strpos($request->url(), 'admin') !== false) {
                return route('admin.login.index');
            }
            return route('/');
        }
    }   

    public function handle($request, Closure $next, ...$guards)
    {
        if ( (!empty($guards) && $guards[0] == 'web') || (empty($guards))) {
            if (Auth::guard('web')->guest()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response('Unauthorized.', 401);
                } else {
                    // $response = [
                    //     'status' => 401,
                    //     'message' => 'Unauthorized: api_token required'
                    // ];
                    // return Response::json($response);
                    //Check if request is from backend/super admin
                    if (strpos($request->url(), 'admin') !== false) {
                        return redirect()->route('admin.login.index');
                    }
                    return redirect('/');
                }
            }
        }

        if ($guards[0] == 'api') {
            if (Auth::guard('api')->guest()) {

                if ($request->ajax() || $request->wantsJson()) {
                    return response('Unauthorized.', 401);
                } else {
                    $response = [
                        'status' => 401,
                        'message' => 'Unauthorized: api_token required'
                    ];
                    return Response::json($response);
                }
            }

            $user = User::where('api_token', $request->api_token)->first();
            Auth::login($user);
        }


        return $next($request);
    }
}
