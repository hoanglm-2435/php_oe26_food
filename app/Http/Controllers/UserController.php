<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(config('paginates.pagination'));

        return view('admin.user_management.show_user', compact('users'));
    }

    public function create()
    {
        return view('admin.user_management.create_user');
    }

    public function store(UserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('users.index')->with('success', trans('message.created'));
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.user_management.update_user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('users.index')->with('success', trans('message.updated'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', trans('message.deleted'));
    }
}
