<?php

namespace App\Http\Controllers;

use App\Api;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends Controller
{
  public function index(Request $request)
  {
    $api = new Api($request->session()->get('access_token'), $request->session()->get('refresh_token'));

    $orders = $api->listOrder();

    return view('order/list_orders', ['orders' => $orders]);
  }
}
