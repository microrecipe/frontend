<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;

class Navbar extends Component
{
    public $isLoggedIn;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($isLoggedIn)
    {
        $this->isLoggedIn = $isLoggedIn;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.navbar', ['isLoggedIn' => $this->isLoggedIn]);
    }
}
