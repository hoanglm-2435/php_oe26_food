<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    protected function redirectTo()
    {
        if (auth()->user()->role_id == config('roles.admin')) {
            return route('dashboard');
        }
        return '/home';
    }

    public function showLoginForm()
    {
        if (Auth::check() && auth()->user()->role_id == config('roles.admin')) {
            return view('admin.dashboard');
        }
        else {
            return view('login');
        }
    }

    public function login(Request $request)
    {
        $login = [
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => config('roles.admin')
        ];

        if ($request->has('remember_me')) {
            $rememberMe = true;
        } else {
            $rememberMe = false;
        }
        if (Auth::attempt($login, $rememberMe)) {
            return redirect()->route('dashboard');
        }
        else {
            return redirect()->back()->with('error', trans('login_failed'));
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
