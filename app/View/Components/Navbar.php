<?php

namespace App\View\Components;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;

class Navbar extends Component
{
    private $isLoggedIn;
    private $activePage;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($isLoggedIn, $activePage = null)
    {
        $this->isLoggedIn = $isLoggedIn;
        $this->activePage = $activePage;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.navbar', ['isLoggedIn' => $this->isLoggedIn, 'activePage' => $this->activePage]);
    }
}
