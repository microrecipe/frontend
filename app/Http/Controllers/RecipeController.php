<?php

namespace App\Http\Controllers;

use App\Api;
use Illuminate\Http\Request;

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
}
