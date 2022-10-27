<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Console\Input\Input;
use Log;

class LoginController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'name' => ['required','min:5','max:100'],
            'email' => ['required','email','unique:users'],
            'password' => ['required','min:6'],
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        Auth::login($user);

        return  redirect(route('home'));

    }

    public function login(Request $request){

        $request->validate([
            'username' => ['required',],
            'password' => ['required',],
        ]);

        $credenciales = [
            "username" => $request->username,
            "password" => $request->password,
        ];

        $remember = ($request->has('remember') ? true : false );

        if(Auth::attempt($credenciales,$remember)){
            $request->session()->regenerate();
            return redirect()->intended(route('empresas'));
        }
        
        $errors = new MessageBag(['username' => ['Estas credenciales no coinciden con nuestros registros.']]);
        return Redirect::back()->withErrors($errors);
    
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
