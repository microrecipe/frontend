<?php

namespace App\Http\Controllers;

use App\Api;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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

        return view('recipe.list_recipes', ['isLoggedIn' => $this->getAccessToken($request), 'recipes' => $recipes]);
    }

    public function viewAddRecipe(Request $request)
    {
        $api = new Api($this->getAccessToken($request), $this->getRefreshToken($request));

        $ingredients = $api->listIngredients();

        return view('recipe.add_recipe', ['isLoggedIn' => $this->getAccessToken($request), 'ingredients' => $ingredients, 'noIngredientSelected' => false]);
    }

    public function addRecipe(Request $request)
    {
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

            return view('recipe.add_recipe', ['isLoggedIn' => $this->getAccessToken($request), 'ingredients' => $ingredients, 'noIngredientSelected' => true]);
        }

        $api->addRecipe($request, $name, $ingredientsInput);

        return redirect()->route('recipes.view.recipes');
    }
}
