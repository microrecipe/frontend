<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Navbar extends Component
{
    private $activePage;
    private $cartItemsCount;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $activePage = null, int $cartItemsCount = 0)
    {
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
        return view('components.navbar', ['activePage' => $this->activePage, 'cartItemsCount' => $this->cartItemsCount]);
    }
}
