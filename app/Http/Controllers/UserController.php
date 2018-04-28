<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getDashboard()
    {
        return view('dashboard');
    }

    public  function getLogin(){
        return view('auth.login');
    }

    public  function getRegister(){
        return view('auth.register');
    }

    public function postSignUp(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:120',
            'email' => 'email|unique:users',
            'password' => 'required|min:4'
        ]);
    	$name = $request['name'];
    	$email = $request['email'];
    	$password = bcrypt($request['password']);

    	$user = new User();
    	$user->name = $name;
    	$user->email = $email;
    	$user->password = $password;

        Auth::login($user);    
    	$user->save();

    	return redirect()->route('dashboard');
    }

    public function postSignIn(Request $request)
    {
        $this->validate($request,[
            'email' => 'required',
            'password' => 'required'
        ]);
        if( Auth::attempt(['email' => $request['email'], 'password' => $request['password']])){
            return redirect()->route('dashboard');
        }
        return redirect()->back()->with('messageLogin','Incorrect email or password!');
    }
    public function logout(Request $request) {
        Auth::logout();
        return redirect('/');
    }
}
