<?php

namespace App\Http\Controllers;

use App\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;

class RecipeController extends Controller
{
    /**
     * Summary of getAccessToken
     * @param Request $request
     * @return string|null
     */
    private function getAccessToken(Request $request)
    {
        return $request->session()->get('access_token', null);
    }

    /**
     * Summary of getRefreshToken
     * @param Request $request
     * @return string|null
     */
    private function getRefreshToken(Request $request)
    {
        return $request->session()->get('refresh_token', null);
    }

    /**
     * Summary of index
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $api = new Api($this->getAccessToken($request), $this->getRefreshToken($request));

        $recipes = $api->listRecipes();
        $itemsInCart = 0;

        if (!is_null($this->getAccessToken($request))) {
            try {
                $itemsInCart = $api->countItemsIncart($request);
            } catch (UnauthorizedException $err) {
                return redirect()->route('auth.view.signin');
            } catch (\Exception $e) {
                Log::debug($e);
                abort($e->getCode());
            }
        }

        return view('recipe.list_recipes', ['accessToken' => $this->getAccessToken($request), 'refreshToken' => $this->getRefreshToken($request), 'recipes' => $recipes, 'cartItemsCount' => $itemsInCart, 'addToCartAlert' => null]);
    }

    public function viewAddRecipe(Request $request)
    {
        try {
            $api = new Api($this->getAccessToken($request), $this->getRefreshToken($request));

            $ingredients = $api->listIngredients();
            $itemsInCart = $api->countItemsIncart($request);

            return view('recipe.add_recipe', ['accessToken' => $this->getAccessToken($request), 'refreshToken' => $this->getRefreshToken($request), 'ingredients' => $ingredients, 'noIngredientSelected' => false, 'cartItemsCount' => $itemsInCart]);
        } catch (UnauthorizedException $err) {
            return redirect()->route('auth.view.signin');
        } catch (\Exception $e) {
            Log::debug($e);
            abort($e->getCode());
        }
    }

    public function addRecipe(Request $request)
    {
        try {
            $api = new Api($this->getAccessToken($request), $this->getRefreshToken($request));

            $inputs = $request->input();
            $name = $request->input('name');
            $ingredientsInput = array();

            foreach ($inputs as $key => $quantity) {
                if (gettype($key) === 'integer') {
                    if (+$quantity > 0) {
                        array_push($ingredientsInput, ['id' => $key, 'quantity' => $quantity]);
                    }
                }
            }

            if (count($ingredientsInput) < 1) {
                $ingredients = $api->listIngredients();

                return view('recipe.add_recipe', ['accessToken' => $this->getAccessToken($request), 'refreshToken' => $this->getRefreshToken($request), 'ingredients' => $ingredients, 'noIngredientSelected' => true]);
            }

            $api->addRecipe($request, $name, $ingredientsInput);

            return redirect()->route('recipes.view.recipes');
        } catch (UnauthorizedException $err) {
            return redirect()->route('auth.view.signin');
        } catch (\Exception $e) {
            Log::debug($e);
            abort($e->getCode());
        }
    }

    public function addIngredientsToCart(Request $request, $recipeId)
    {
        try {
            $api = new Api($this->getAccessToken($request), $this->getRefreshToken($request));

            $api->addIngredientsToCart($request, $recipeId);

            $recipes = $api->listRecipes();
            $itemsInCart = 0;

            if (!is_null($this->getAccessToken($request))) {
                try {
                    $itemsInCart = $api->countItemsIncart($request);
                } catch (UnauthorizedException $err) {
                    return redirect()->route('auth.view.signin');
                } catch (\Exception $e) {
                    Log::debug($e);
                    abort($e->getCode());
                }
            }

            return view('recipe.list_recipes', ['accessToken' => $this->getAccessToken($request), 'refreshToken' => $this->getRefreshToken($request), 'recipes' => $recipes, 'cartItemsCount' => $itemsInCart, 'addToCartAlert' => 'success']);
        } catch (UnauthorizedException $err) {
            return redirect()->route('auth.view.signin');
        } catch (\Exception $e) {
            Log::debug($e);
            abort($e->getCode());
        }
    }
}
