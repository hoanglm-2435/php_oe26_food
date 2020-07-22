<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Repositories\User\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Repositories\User\UserRepositoryInterface;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $users = $this->userRepository->showList(
            'created_at',
            'DESC',
            config('paginates.pagination')
        );

        return view('admin.user_management.show_user', compact('users'));
    }

    public function create()
    {
        return view('admin.user_management.create_user');
    }

    public function store(UserRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
        ];
        $this->userRepository->create($data);

        return redirect()->route('users.index')
            ->with('success', trans('message.created'));
    }

    public function edit($id)
    {
        $user = $this->userRepository->getById($id);

        return view('admin.user_management.update_user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        try {
            $this->userRepository->update($id, $data);

            return redirect()->route('users.index')
                ->with('success', trans('message.updated'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('users.index')
                ->with('error', trans('message.updated'));
        }

    }

    public function destroy($id)
    {
        try {
            $this->userRepository->delete($id);

            return redirect()->route('users.index')
                ->with('success', trans('message.deleted'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('users.index')
                ->with('error', trans('message.updated'));
        }
    }
}
