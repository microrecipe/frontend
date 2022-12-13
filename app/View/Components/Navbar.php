<?php

namespace App\View\Components;

use App\Api;
use Illuminate\View\Component;

class Navbar extends Component
{
    private $accessToken;
    private $refreshToken;
    private $activePage;
    private $cartItemsCount;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $accessToken = null, string $refreshToken = null, string $activePage = null, int $cartItemsCount = 0)
    {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
        $this->activePage = $activePage;
        $this->cartItemsCount = $cartItemsCount;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $api = new Api($this->accessToken, $this->refreshToken);

        return view('components.navbar', ['isLoggedIn' => !is_null($this->accessToken), 'activePage' => $this->activePage, 'cartItemsCount' => $this->cartItemsCount]);
    }
}
