<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    // Login v1
    public function login_v1()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-login-v1', ['pageConfigs' => $pageConfigs]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $utente = DB::table('users')
            ->where('email', '=', $credentials["email"]);

        $getUtente = $utente->get();

        if(strlen($credentials["password"]) > 5){
            if(count($getUtente) > 0 && $getUtente[0]->password === null){
                $utente->update([
                    'password' => Hash::make($request->password)
                ]);
            }
        }
        else{
            if(count($getUtente) > 0 && $getUtente[0]->password === null && strlen($credentials["password"]) === 0){

                return redirect()->route('login')->with('newUser', 'Nuovo utente inserisci la password per crearla!');
            }
            return redirect()->route('login')->with('error', 'Password deve essere almeno di 6 caratteri');
        }

        if($credentials["email"])
        if (Auth::attempt($credentials)) {
            // if success login

            return redirect('/');
        }
        // if failed login
        return redirect()->route('login')->with('error', 'Utente o password non corretti.');
    }


    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
    // Login v2
    public function login_v2()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-login-v2', ['pageConfigs' => $pageConfigs]);
    }

    // Register v1
    public function register_v1()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-register-v1', ['pageConfigs' => $pageConfigs]);
    }

    // Register v2
    public function register_v2()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-register-v2', ['pageConfigs' => $pageConfigs]);
    }

    // Forgot Password v1
    public function forgot_password_v1()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-forgot-password-v1', ['pageConfigs' => $pageConfigs]);
    }

    // Forgot Password v2
    public function forgot_password_v2()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-forgot-password-v2', ['pageConfigs' => $pageConfigs]);
    }

    // Reset Password
    public function reset_password_v1()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-reset-password-v1', ['pageConfigs' => $pageConfigs]);
    }

    // Reset Password
    public function reset_password_v2()
    {
        $pageConfigs = ['blankPage' => true];

        return view('/content/authentication/auth-reset-password-v2', ['pageConfigs' => $pageConfigs]);
    }
}
