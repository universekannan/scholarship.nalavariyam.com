<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class LoginController extends Controller
{
 
 
  use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
	
    public function login(Request $request){
    $message = "";
    $username = array("username" => $request->username, "password" => $request->password);
    if(Auth::attempt($username)) {
        Auth::loginUsingId(Auth::user()->id);
        return redirect('/dashboard');
      }else{
        $message = 'Login Failed';
        return redirect('/')->with('message',$message);
      }
      
    }
}