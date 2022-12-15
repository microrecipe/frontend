<?php

namespace App\Http\Controllers;

use App\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;

class IngredientController extends Controller
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
            $api = new Api();

            $ingredients = $api->listIngredients();

            return view('ingredient.list_ingredients', ['alert' => null, 'ingredients' => $ingredients]);
        } catch (UnauthorizedException $th) {
            return redirect()->route('auth.view.signin');
        } catch (\Exception $e) {
            Log::debug($e);
            abort($e->getCode());
        }
    }
}
