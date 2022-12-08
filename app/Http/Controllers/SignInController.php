<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SignInController extends Controller
{
    public function index()
    {
        Log::debug("message");

        return view('auth/sign_in');
    }

    public function signIn(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $response = Http::post("http://" . env('AUTH_HOST', 'auth') . ":" . env('AUTH_REST_PORT', '80') . "/auth/sign-in", [
            'email' => $email,
            'password' => $password
        ]);

        return $response;
    }
}
