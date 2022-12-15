<?php

namespace App\Http\Controllers;

use App\Api;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.sign_in', ['loginError' => false]);
    }
    public function signIn(Request $request)
    {
        $request->validate([
            'email' => ['email', 'required'],
            'password' => ['required', 'min:8']
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $api = new Api();

        $user = $api->signIn($email, $password);

        $request->session()->put('access_token', $user['access_token']);
        $request->session()->put('refresh_token', $user['refresh_token']);
        $request->session()->put('is_admin', $user['user']['is_admin']);

        return redirect()->route('home');
    }

    public function signOut(Request $request)
    {
        $request->session()->forget('access_token');
        $request->session()->forget('refresh_token');
        $request->session()->forget('is_admin');

        return redirect()->route('home');
    }
}
