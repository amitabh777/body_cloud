<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class RoleCheck
{

    protected $userModel;
    public function __construct(User $user){
        $this->userModel = $user;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {;
        if($request->input('RoleSlug','')!=null){
           
            $inputRole = $request->input('RoleSlug');
            $user = Auth::user();            
            $userRole = $user->userRole();                       
            $role = $userRole->role;
           if($role->RoleSlug!=$inputRole){
            return response()->json(['message'=>'Logged in user role not matched with provided role:'.$inputRole,'status'=>400]);
           }
        }
        return $next($request);
    }
}
