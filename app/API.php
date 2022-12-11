<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;

class Api
{
  private $accessToken;

  private $refreshToken;

  private $orderBaseUrl;

  private $authBaseUrl;

  private $recipeBaseUrl;

  public function __construct($accessToken, $refreshToken)
  {
    $this->accessToken = $accessToken;
    $this->refreshToken = $refreshToken;
    $this->orderBaseUrl = "http://" . env('ORDER_HOST', 'order') . ":" . env('ORDER_REST_PORT', '80') . "/orders";
    $this->authBaseUrl = "http://" . env('AUTH_HOST', 'auth') . ":" . env('AUTH_REST_PORT', '80') . "/auth";
    $this->recipeBaseUrl = "http://" . env('RECIPE_HOST', 'recipe') . ":" . env('RECIPE_REST_PORT', '80') . "/recipes";
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

  // Orders API

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

  // Recipe API

  public function listRecipes()
  {
    return Http::get($this->recipeBaseUrl);
  }
}
