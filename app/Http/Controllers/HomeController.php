<?php

namespace App\Http\Controllers;

use App\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;

class HomeController extends Controller
{
    private function getAccessToken(Request $request)
    {
        return $request->session()->get('access_token', null);
    }

    private function getRefreshToken(Request $request)
    {
        return $request->session()->get('refresh_token', null);
    }
    public function index(Request $request)
    {
        $api = new Api($this->getAccessToken($request), $this->getRefreshToken($request));

        $itemsInCart = 0;

        if (!is_null($this->getAccessToken($request))) {
            try {
                $itemsInCart = $api->countItemsIncart($request);
            } catch (UnauthorizedException $err) {
                return redirect()->route('auth.view.signin');
            } catch (\Exception $e) {
                Log::debug($e);
                abort($e->getCode());
            }
        }

        return view('home', ['cartItemsCount' => $itemsInCart]);
    }
}
