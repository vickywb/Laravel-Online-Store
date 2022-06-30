<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{   
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function renderLogin()
    {
        return view('admin.auth.login');
    }

    public function login(LoginRequest $request)
    {
        $user = $this->userRepository->findByColumn($request->email, 'email');

        if (!$user) {
            return redirect()->back()->withErrors([
                'message' => 'Username and Password did not match.'
            ]);
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors([
                'message' => 'Username and Password did not match.'
            ]);
        }

        if ($user->role != 1) {
            return redirect()->back()->withErrors([
                'message' => 'Admin Area.'
            ]);
        }

        Auth::login($user, true);

        return redirect()->route('admin-dashboard');
    }

    public function logout()
    {
        auth()->logout();

        return redirect()->route('login.admin');
    }
}
