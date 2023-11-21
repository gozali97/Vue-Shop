<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminAuthController extends Controller
{

    public function showLoginForm()
    {
        return Inertia::render('Admin/Auth/Login');
    }

    public function login(Request $request)
    {

        if (Auth::attempt(['email'=> $request->email, 'password' => $request->password, 'isAdmin' => true])){
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('admin.login')->with('error', 'Invalid credentials');
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();

        return redirect()->route('admin.login');
    }
}
