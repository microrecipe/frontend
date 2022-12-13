<?php

namespace App\Http\Controllers;

use App\Api;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;

class OrderController extends Controller
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
    try {
      $api = new Api($this->getAccessToken($request), $this->getRefreshToken($request));

      $orders = $api->listOrder($request);
      $itemsInCart = $api->countItemsIncart($request);

      return view('order', ['orders' => $orders->json(), 'accessToken' => $this->getAccessToken($request), 'refreshToken' => $this->getRefreshToken($request), 'cartItemsCount' => $itemsInCart]);
    } catch (UnauthorizedException $th) {
      return redirect()->route('auth.view.signin');
    } catch (\Exception $e) {
      Log::debug($e->getMessage());
      abort(400);
    }
  }

  public function listItemsInCart(Request $request)
  {
    try {
      $api = new Api($this->getAccessToken($request), $this->getRefreshToken($request));

      $cartItems = $api->listItemsInCart($request);
      $itemsInCart = $api->countItemsIncart($request);

      return view('order.cart', ['accessToken' => $this->getAccessToken($request), 'refreshToken' => $this->getRefreshToken($request), 'cartItemsCount' => $itemsInCart, 'cartItems' => $cartItems]);
    } catch (UnauthorizedException $th) {
      return redirect()->route('auth.view.signin');
    } catch (\Exception $e) {
      Log::debug($e->getMessage());
      abort(400);
    }
  }
}
