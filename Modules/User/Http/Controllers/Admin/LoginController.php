<?php

namespace Modules\User\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\User\Http\Requests\Admin\LoginRequest;
use Modules\User\Repositories\UserRepository;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $userRepo;
public function __construct(UserRepository $userRepo){
    $this->userRepo = $userRepo;
}

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    // public function getUsernameType($val)
    // {
    //     $val = str_replace('+', '', $val);
    //     $type = (filter_var($val, FILTER_VALIDATE_EMAIL)==false) && filter_var($val, FILTER_VALIDATE_INT)? 'phone' : 'email';
    //     return $type;
    // }

public function index(){
  
   return view('user::admin.login');
}

    /**
     * handle login request
     * @return Renderable
     */
    public function login(LoginRequest $request)
    {
       $auth = Auth::attempt(['Email' => $request->Email, 'password' => $request->Password]);
       if($auth){
        return redirect()->route('admin.dashboard')->with('status','success');
       } 
       return view('user::admin.login');
    }


}
