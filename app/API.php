<?php

namespace App;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class Api
{
  private $accessToken;

  private $refreshToken;

  private $orderBaseUrl;

  private $authBaseUrl;

  public function __construct($accessToken, $refreshToken)
  {
    $this->accessToken = $accessToken;
    $this->refreshToken = $refreshToken;
    $this->orderBaseUrl = "http://" . env('ORDER_HOST', 'order') . ":" . env('ORDER_REST_PORT', '80') . "/orders";
    $this->authBaseUrl = "http://" . env('AUTH_HOST', 'auth') . ":" . env('AUTH_REST_PORT', '80') . "/auth";
  }

  private function refreshAccessToken(Request $request)
  {

    $refresh = Http::post($this->authBaseUrl . "/refresh-token", [
      'refresh_token' => $this->refreshToken
    ]);

    if ($refresh->failed()) {
      throw new UnauthorizedException('error');
    }

    $request->session()->put('access_token', $refresh->json('access_token'));
    $this->accessToken = $refresh->json('access_token');
  }

  public function listOrder(Request $request)
  {
    $orders = Http::withToken($this->accessToken)->get($this->orderBaseUrl . "/");

    if ($orders->failed()) {
      if ($orders->json('message') == 'Token expired') {
        $this->refreshAccessToken($request);
        return $this->listOrder($request);
      } else {
        Log::debug($orders->json('message'));
        exit;
      }
    }

    return $orders;
  }
}
