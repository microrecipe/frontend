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

            return view('ingredient.list_ingredients', ['alert' => session('alert', null), 'ingredients' => $ingredients]);
        } catch (UnauthorizedException $th) {
            return redirect()->route('auth.view.signin');
        } catch (\Exception $e) {
            Log::debug($e);
            abort($e->getCode());
        }
    }

    public function viewAddIngredient(Request $request)
    {
        try {
            $api = new Api();

            $nutritions = $api->listNutritions();

            return view('ingredient.add_ingredient', ['alert' => session('alert', null), 'nutritions' => $nutritions]);
        } catch (UnauthorizedException $th) {
            return redirect()->route('auth.view.signin');
        } catch (\Exception $e) {
            Log::debug($e);
            abort($e->getCode());
        }
    }

    public function addIngredient(Request $request)
    {
        try {
            $api = new Api($this->getAccessToken($request), $this->getRefreshToken($request));

            $inputs = $request->input();
            $name = $request->input('name');
            $unit = $request->input('unit');
            $price = $request->input('price');

            $nutritionsInput = array();

            foreach ($inputs as $key => $perGram) {
                if (gettype($key) === 'integer') {
                    if ($perGram) {
                        array_push($nutritionsInput, ['id' => $key, 'per_gram' => $perGram]);
                    }
                }
            }

            if (count($nutritionsInput) < 1) {
                return redirect(route('ingredients.view.add_ingredient'))->with(
                    [
                        'alert' => [
                            'type' => 'danger',
                            'message' => 'One or more nutrition is required.'
                        ]
                    ]
                );
            }

            $api->addIngredient($request, $name, $unit, +$price, $nutritionsInput);

            return redirect(route('ingredients.view.list_ingredients'))->with([
                'alert' => [
                    'type' => 'success',
                    'message' => 'Ingredient added.'
                ]
            ]);
        } catch (UnauthorizedException $th) {
            return redirect()->route('auth.view.signin');
        } catch (\Exception $e) {
            Log::debug($e);
            abort($e->getCode());
        }
    }

    public function deleteIngredient(Request $request, $ingredientId)
    {
        try {
            $api = new Api($this->getAccessToken($request), $this->getRefreshToken($request));

            $api->deleteIngredient($request, $ingredientId);

            return redirect(route('ingredients.view.list_ingredients'))->with([
                'alert' => [
                    'type' => 'success',
                    'message' => 'Ingredient deleted.'
                ]
            ]);
        } catch (UnauthorizedException $th) {
            return redirect()->route('auth.view.signin');
        } catch (\Exception $e) {
            Log::debug($e);
            abort($e->getCode());
        }
    }
}
