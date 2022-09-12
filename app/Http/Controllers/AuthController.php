<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function index()
    {
        return Inertia::render('authUser/Login');
    }

    public function authenticateUser(Request $request)
    {
        $request->validate([
            'email'=> 'required|email',
            'password'=> 'required|min:8'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            return redirect()->back()->withErrors('Email does not exist');
        }else{
            $user = User::where('password', $request->password)->where('email', $request->email)->first();
            if(!$user){
                return redirect()->back()->withErrors('Invalid password');
            }else{
                session()->put('userId', $user->id);
                session()->put('user', $user->fname.' '.$user->lname);

                return redirect()->route('dashboard');
            }
        }
    }

    public function logoutUser()
    {
        session()->pull('userId');
        session()->pull('user');
        
        return redirect()->route('login');
    }
}