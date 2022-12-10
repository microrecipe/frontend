<?php

namespace App;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Api
{
  private $accessToken;

  private $refreshToken;

  private $orderBaseUrl;

  public function __construct($accessToken, $refreshToken)
  {
    $this->accessToken = $accessToken;
    $this->refreshToken = $refreshToken;
    $this->orderBaseUrl = "http://" . env('ORDER_HOST', 'order') . ":" . env('ORDER_REST_PORT', '80') . "/orders";
  }

  private function refreshToken()
  {

  }

  public function listOrder()
  {
    $orders = Http::withToken($this->accessToken)->get($this->orderBaseUrl . "/");

    if ($orders->failed()) {
      Log::debug($orders->json('message'));
      exit;
    }

    return $orders->json();
    ;
  }
}
