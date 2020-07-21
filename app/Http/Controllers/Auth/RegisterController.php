<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
            'phone' => ['required', 'string', 'max:10'],
            'address' => ['required', 'string', 'max:100'],
        ]);
    }

    public function register(UserRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'role_id' => config('roles.customer'),
        ];

        if ($request->password == $request->password_confirmation) {
            User::create($data);

            return redirect()->route('login')
                ->with('success', trans('message.register_success'));
        } else {
            return redirect()->back()
                ->with('error', trans('message.register_failed'));
        }
    }

    public function showRegistrationForm()
    {
        return view('register');
    }
}
