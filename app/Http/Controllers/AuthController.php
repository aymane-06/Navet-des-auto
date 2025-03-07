<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(Request $request)
    {
        $ValidateRequest=$request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);
        if(auth()->attempt($ValidateRequest)){
            return redirect('/');
        }
        return back()->withErrors([
            'email'=>'incorrect credentials',
        ]);
    }
    public function logout(){
        auth()->logout();
        return redirect('/');
    }
    
    public function register(Request $request)
    {
        // dd($request->all());
        $ValidateRequest=$request->validate([
            'name'=>'required',
            'email'=>'required|email',
            "role_id"=>'required',
            'password'=>'required|confirmed'
        ]);
        $ValidateRequest['password']=bcrypt($ValidateRequest['password']);
        $user= new User();
        $user->name=$ValidateRequest['name'];
        $user->email=$ValidateRequest['email'];
        $user->role_id=$ValidateRequest['role_id'];
        $user->password=$ValidateRequest['password'];
        $user->save();
        auth()->login($user);
        return redirect('/');
    }


   
}
