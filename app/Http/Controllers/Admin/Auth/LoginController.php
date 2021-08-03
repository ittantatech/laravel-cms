<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/administrator/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }    
    /**
     * Extend default login layout and set new layout
     *
     * @return New layout
     */
    public function showLoginForm()
    {
      return view('admin.auth.login');
    }    
    /**
     * logout
     *
     * @param  mixed $request
     * @@return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect(route('admin.login'));
    }
    
    /**
     * Extend default login guard and set Admin guard for admin access
     *
     * @return Admin Guard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }
    
    /**
     * Inherit loggedout function and set new logic for redirection
     *
     * @param  mixed $request
     * @@return \Illuminate\Http\Response
     */
    protected function loggedOut(Request $request)
    {
        return redirect(route('admin.login'));
    }
}
