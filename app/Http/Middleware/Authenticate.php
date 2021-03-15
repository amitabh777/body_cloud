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
            dd('tesrf');
            //Check if request is from backend/super admin
            if (strpos($request->url(), 'admin') !== false) {
                return route('admin.login.index');
            }
            return route('/');
        }
    }

    /**
     * Get the path the user should be redirected to.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    // protected function redirectTo($request)
    // {
    //     // return route('login');
    // }

    public function handle($request, Closure $next, ...$guards)
    {
        //handle api request
        if (!empty($guards) && $guards[0] == 'api') {
            return $this->handleApiGuard($request, $next);
        }
        //handle web request/guard
        if (Auth::guard('web')->guest()) {
            return $this->handleWebGuard($request, $next);
        }
        return $next($request);
    }

    /**
     * handle Api requests if access_token valid or not
     *
     * @param Request $request
     * @return mixed 
     */
    public function handleApiGuard($request, $next)
    {
        if (Auth::guard('api')->guest()) {
            $response = [
                'status' => 400,
                'message' => 'Unauthorized: invalid api_token'
            ];
            return Response::json($response);
        }
        //setting api guard for authenticated api user 
        Auth::shouldUse('api');
        return $next($request);
    }

    /**
     * Handle web guard
     *
     * @param Request $request
     * @param $next
     * @return void
     */
    public function handleWebGuard($request, $next)
    {
        //handle if user is unauthorized
        if ($request->ajax() || $request->wantsJson()) {
            return response('Unauthorized.', 401);
        }
        //redirect to login if admin is unauthorized
        if ($request->route()->getprefix() == '/admin') {
           // return redirect()->route('login');
        }

        return $next($request);
    }
}
