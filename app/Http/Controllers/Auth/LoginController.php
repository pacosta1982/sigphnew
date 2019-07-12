<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /*public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }



    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
    }*/

    /*protected function attemptLogin(Request $request)
    {
        //$this->guard()->login($user, true);
        //return view();
        //return redirect()->route($this->$redirectTo);
        $credentials = $request->only('username', 'password');
        $username = $credentials['username'];
        $password = bcrypt($credentials['password']);
        
        $user = \App\User::where('username', $username)
                                ->where('password', $password)
                                ->first();
        if ($user) {
            $this->guard()->login($user, true);
            return true;
        }else{
            return true;
        }
        

        
    }*/
}
