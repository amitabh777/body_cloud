<?php

namespace Modules\User\Http\Controllers\Admin;

use App\Providers\RouteServiceProvider;
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
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
    }

  

    // public function getUsernameType($val)
    // {
    //     $val = str_replace('+', '', $val);
    //     $type = (filter_var($val, FILTER_VALIDATE_EMAIL)==false) && filter_var($val, FILTER_VALIDATE_INT)? 'phone' : 'email';
    //     return $type;
    // }

    public function index()
    {
        return view('user::admin.login');
    }

     /* The user has been authenticated.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  mixed  $user
    * @return mixed
    */
   protected function authenticated(Request $request, $user)
   {
    //    dd('tefsjdljflksjdlkfjl');
    //    return response([
    //        ''
    //    ]);
   }
   public function username()
   {
       return 'Email';
   }

    /**
     * handle login request
     * @return Renderable
     */
    public function login(LoginRequest $request)
    {
        $this->redirectTo = route('admin.dashboard.index');       
        $auth = Auth::attempt(['Email' => $request->Email, 'password' => $request->Password]);
        if ($auth) {
            return $this->sendLoginResponse($request);
           // return redirect()->route('admin.dashboard.index')->with('status', 'success');
        }
        return $this->sendFailedLoginResponse($request);
      //  return redirect()->back();
    }

    public function logout(Request $request){
       Auth::logout();
    
       return redirect()->route('admin.login.index');
    }
}
