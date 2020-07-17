<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('client.my-account');
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());

        if (Hash::check($request->oldPassword, $user->password)
            && $request->newPassword == $request->confirmPassword) {
            $user->update([
                'password' => Hash::make($request->newPassword)
            ]);
        }

        return redirect()->back()->with('result', trans('message.updated'));
    }
}
