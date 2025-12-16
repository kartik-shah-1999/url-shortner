<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function signupView(){
        return view ('signup');
    }

    public function signup(SignupRequest $request){
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('pass1'))
        ]);
        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function loginView(){
        return view('login');
    }

    public function login(LoginRequest $request){
        $creds = $request->only('email','password');
        if(!Auth::attempt($creds)){
            return back()->with('error', 'Invalid credentials');
        }
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['redirectUrl' => '/login']);
    }

    public function dashboard(){
        return view('dashboard');
    }
}
