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
  public function index(Request $request)
  {
    try {
      $api = new Api($request->session()->get('access_token'), $request->session()->get('refresh_token'));

      $orders = $api->listOrder($request);

      return view('order/list_orders', ['orders' => $orders->json()]);
    } catch (UnauthorizedException $th) {
      return redirect()->route('auth.view.signin');
    } catch (\Exception $e) {
      Log::debug($e->getMessage());
      abort(400);
    }
  }
}
