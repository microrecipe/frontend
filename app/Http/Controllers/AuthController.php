<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Summary of signIn
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function signIn(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $response = Http::post("http://" . env('AUTH_HOST', 'auth') . ":" . env('AUTH_REST_PORT', '80') . "/auth/sign-in", [
            'email' => $email,
            'password' => $password
        ]);

        $request->session()->put('access_token', $response->json('access_token'));
        $request->session()->put('refresh_token', $response->json('refresh_token'));

        Log::debug($request->session()->get('access_token'));

        // auth('api')->login(auth('api')->setToken($response->json('access_token'))->user());

        return redirect('/');
    }

    /**
     * Summary of signOut
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function signOut(Request $request)
    {
        $request->session()->forget('access_token');

        return redirect('/');
    }
}
