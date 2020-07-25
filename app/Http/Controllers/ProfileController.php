<?php

namespace App\Http\Controllers;

use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function index()
    {
        return view('client.my-account');
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $user = $this->userRepo->getById($id);
        $this->userRepo->update($id, $data);

        if (Hash::check($request->oldPassword, $user->password)
            && $request->newPassword == $request->confirmPassword) {
            $data['password'] = Hash::make($request->newPassword);
            $this->userRepo->update($id, $data);
        }

        return redirect()->back()->with('result', trans('message.updated'));
    }
}
