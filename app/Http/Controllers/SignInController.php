<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SignInController extends Controller
{
    public function index()
    {
        return view('auth/sign_in');
    }

    public function signIn(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6']
        ]);

        $response = Http::post('http://auth:80/sign-up', [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ]);

        return $response;
    }
}
