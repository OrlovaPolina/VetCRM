<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NSDetail extends Component
{
    protected $detail;
    /**
     * Create a new component instance.
     */
    public function __construct($detail)
    {
        $this->detail = $detail;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.n-s-detail')->with(['detail'=>$this->detail]);
    }
}
