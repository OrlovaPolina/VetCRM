<?php

namespace App\View\Components;

use App\Models\Stocks;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ManagerStocksList extends Component
{
    protected $stocks;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->stocks = Stocks::withTrashed()->paginate(20)->withQueryString();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        
        return view('manager.components.manager-stocks-list')->with(['stocks' => $this->stocks]);
    }
}
