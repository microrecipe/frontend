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

  private $ingredientBaseUrl;

  private $nutritionBaseUrl;

  private $paymentBaseUrl;

  private $deliveryBaseUrl;

  public function __construct($accessToken = null, $refreshToken = null)
  {
    $this->accessToken = $accessToken;
    $this->refreshToken = $refreshToken;
    $this->orderBaseUrl = "http://" . env('ORDER_HOST', 'order') . ":" . env('ORDER_REST_PORT', '80') . "/orders";
    $this->authBaseUrl = "http://" . env('AUTH_HOST', 'auth') . ":" . env('AUTH_REST_PORT', '80') . "/auth";
    $this->recipeBaseUrl = "http://" . env('RECIPE_HOST', 'recipe') . ":" . env('RECIPE_REST_PORT', '80') . "/recipes";
    $this->ingredientBaseUrl = "http://" . env('INGREDIENT_HOST', 'ingredient') . ":" . env('INGREDIENT_REST_PORT', '80') . "/ingredients";
    $this->nutritionBaseUrl = "http://" . env('NUTRITION_HOST', 'nutrition') . ":" . env('NUTRITION_REST_PORT', '80') . "/nutritions";
    $this->paymentBaseUrl = "http://" . env('PAYMENT_HOST', 'payment') . ":" . env('PAYMENT_REST_PORT', '80') . "/payments";
    $this->deliveryBaseUrl = "http://" . env('DELIVERY_HOST', 'delivery') . ":" . env('DELIVERY_REST_PORT', '80') . "/deliveries";
  }

  // Auth API

  private function refreshAccessToken(Request $request)
  {

    $refresh = Http::post($this->authBaseUrl . "/refresh-token", [
      'refresh_token' => $this->refreshToken
    ]);

    if ($refresh->failed()) {
      Log::debug($refresh);

      $request->session()->forget('access_token');
      $request->session()->forget('refresh_token');
      $request->session()->forget('is_admin');
      throw new UnauthorizedException('error');
    }

    $request->session()->put('access_token', $refresh->json('access_token'));
    $this->accessToken = $refresh->json('access_token');
  }

  public function signIn($email, $password)
  {
    $apiResponse = Http::post($this->authBaseUrl . "/sign-in", ['email' => $email, 'password' => $password]);

    abort_if($apiResponse->failed(), $apiResponse->status());

    return $apiResponse->json();
  }

  // Orders API

  public function listOrder(Request $request)
  {
    $apiResponse = Http::withToken($this->accessToken)->get($this->orderBaseUrl . "/");

    if ($apiResponse->failed()) {
      if ($apiResponse->json('message') == 'Token expired') {
        $this->refreshAccessToken($request);
        return $this->listOrder($request);
      } else {
        Log::debug($apiResponse->json('message'));
        exit;
      }
    }

    return $apiResponse;
  }

  public function listItemsInCart(Request $request)
  {
    $apiResponse = Http::withToken($this->accessToken)->get($this->orderBaseUrl . "/carts");

    if ($apiResponse->failed()) {
      if ($apiResponse->json('message') == 'Token expired') {
        $this->refreshAccessToken($request);
        return $this->listItemsInCart($request);
      } else {
        abort($apiResponse->failed(), $apiResponse->status());
      }
    }

    return $apiResponse->json();
  }

  public function countItemsIncart(Request $request)
  {
    $apiResponse = Http::withToken($this->accessToken)->get($this->orderBaseUrl . "/carts/count");

    if ($apiResponse->failed()) {
      if ($apiResponse->json('message') == 'Token expired') {
        $this->refreshAccessToken($request);
        return $this->countItemsIncart($request);
      } else {
        abort($apiResponse->failed(), $apiResponse->status());
      }
    }

    return $apiResponse->json();
  }

  public function addIngredientsToCart(Request $request, $recipeId)
  {
    $apiResponse = Http::withToken($this->accessToken)->post($this->orderBaseUrl . "/carts/recipes/" . $recipeId);

    if ($apiResponse->failed()) {
      if ($apiResponse->json('message') == 'Token expired') {
        $this->refreshAccessToken($request);
        return $this->addIngredientsToCart($request, $recipeId);
      } else {
        abort($apiResponse->failed(), $apiResponse->status());
      }
    }

    return $apiResponse->json();
  }

  public function removeItemFromCart(Request $request, $itemId)
  {
    $apiResponse = Http::withToken($this->accessToken)->delete($this->orderBaseUrl . "/carts" . "/" . $itemId);

    if ($apiResponse->failed()) {
      if ($apiResponse->json('message') == 'Token expired') {
        $this->refreshAccessToken($request);
        return $this->removeItemFromCart($request, $itemId);
      } else {
        abort($apiResponse->failed(), $apiResponse->status());
      }
    }

    return $apiResponse->json();
  }

  public function checkout(Request $request, $address, $paymentId, $courierId)
  {
    $apiResponse = Http::withToken($this->accessToken)->post($this->orderBaseUrl . "/checkout", ['address' => $address, 'payment_id' => $paymentId, 'delivery_courier_id' => $courierId]);

    if ($apiResponse->failed()) {
      if ($apiResponse->json('message') == 'Token expired') {
        $this->refreshAccessToken($request);
        return $this->checkout($request, $address, $paymentId, $courierId);
      } else {
        abort($apiResponse->failed(), $apiResponse->status());
      }
    }

    return $apiResponse->json();
  }

  // Recipe API

  public function listRecipes()
  {
    $apiResponse = Http::get($this->recipeBaseUrl);

    abort_if($apiResponse->failed(), $apiResponse->status());

    return $apiResponse->json();
  }

  public function addRecipe(Request $request, $name, $ingredients)
  {
    $apiResponse = Http::withToken($this->accessToken)->post($this->recipeBaseUrl, [
      'name' => $name,
      'ingredients' => $ingredients
    ]);

    if ($apiResponse->failed()) {
      if ($apiResponse->json('message') == 'Token expired') {
        $this->refreshAccessToken($request);
        return $this->addRecipe($request, $name, $ingredients);
      } else {
        abort($apiResponse->failed(), $apiResponse->status());
      }
    }

    return $apiResponse->json();
  }

  // Ingredient API

  public function listIngredients()
  {
    $apiResponse = Http::get($this->ingredientBaseUrl);

    abort_if($apiResponse->failed(), $apiResponse->status());

    return $apiResponse->json();
  }

  public function addIngredient(Request $request, $name, $unit, $price, $nutritions)
  {
    $apiResponse = Http::withToken($this->accessToken)->post($this->ingredientBaseUrl, [
      'name' => $name,
      'unit' => $unit,
      'price' => $price,
      'nutritions' => $nutritions
    ]);

    if ($apiResponse->failed()) {
      Log::debug($apiResponse->json());
      if ($apiResponse->json('message') == 'Token expired') {
        $this->refreshAccessToken($request);
        return $this->addIngredient($request, $name, $unit, $price, $nutritions);
      } else {
        abort($apiResponse->failed(), $apiResponse->status());
      }
    }

    return $apiResponse->json();
  }

  // Nutrition API

  public function listNutritions()
  {
    $apiResponse = Http::get($this->nutritionBaseUrl);

    abort_if($apiResponse->failed(), $apiResponse->status());

    return $apiResponse->json();
  }

  // Delivery API

  public function listDeliveryCouriers()
  {
    $apiResponse = Http::get($this->deliveryBaseUrl . "/couriers");

    abort_if($apiResponse->failed(), $apiResponse->status());

    return $apiResponse->json();
  }

  // Payment API

  public function listPaymentMethods()
  {
    $apiResponse = Http::get($this->paymentBaseUrl . "/payment-methods");

    abort_if($apiResponse->failed(), $apiResponse->status());

    return $apiResponse->json();
  }
}
