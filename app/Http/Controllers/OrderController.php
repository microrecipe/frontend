<?php

namespace App\Http\Controllers;

use App\Api;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

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

      return view('order/list_orders', ['orders' => $orders->json(), 'isLoggedIn' => $this->getAccessToken($request)]);
    } catch (UnauthorizedException $th) {
      return redirect()->route('auth.view.signin');
    } catch (\Exception $e) {
      Log::debug($e->getMessage());
      abort(400);
    }
  }
}
