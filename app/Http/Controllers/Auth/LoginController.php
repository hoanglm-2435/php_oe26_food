<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = 'homepage';

    protected function redirectTo()
    {
        if (auth()->user()->role_id == config('roles.admin')) {

            return route('dashboard');
        }

        return route('homepage');
    }

    public function showLoginForm()
    {
        if (Auth::check() && auth()->user()->role_id == config('roles.admin')) {

            return view('admin.dashboard');
        } elseif (Auth::check() && auth()->user()->role_id == config('roles.customer')) {

            return view('client.homepage');
        } else {

            return view('login');
        }
    }

    public function login(Request $request)
    {
        $loginAdmin = [
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => config('roles.admin')
        ];
        $loginUser = [
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => config('roles.customer')
        ];

        if ($request->has('remember_me')) {
            $remember = true;
        } else {
            $remember = false;
        }
        if (Auth::attempt($loginAdmin, $remember)) {

            return redirect()->route('dashboard');
        } elseif (Auth::attempt($loginUser, $remember)) {

            return redirect()->route('homepage')->with('result', trans('client.login_success'));
        } else {

            return redirect()->back()->with('error', trans('message.login_failed'));
        }
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
