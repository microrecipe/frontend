<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth/sign_in', ['loginError' => false]);
    }
    /**
     * Summary of signIn
     * @param Request $request
     * @return mixed
     */
    public function signIn(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $authServiceResponse = Http::post("http://" . env('AUTH_HOST', 'auth') . ":" . env('AUTH_REST_PORT', '80') . "/auth/sign-in", [
            'email' => $email,
            'password' => $password
        ]);

        if ($authServiceResponse->clientError()) {
            return view('auth.sign_in', ['loginError' => $authServiceResponse->json('message')]);
        }

        $request->session()->put('access_token', $authServiceResponse->json('access_token'));
        $request->session()->put('refresh_token', $authServiceResponse->json('refresh_token'));

        // auth('api')->login(auth('api')->setToken($response->json('access_token'))->user());

        return redirect()->route('home');
    }

    /**
     * Summary of signOut
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function signOut(Request $request)
    {
        $request->session()->forget('access_token');

        return redirect()->route('home');
    }
}
