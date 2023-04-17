<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class NewsStocksList extends Component
{
    public $content,$type;
    /**
     * Create a new component instance.
     */
    public function __construct($content,$type)
    {
        $this->content = $content;
        $this->type = $type;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.news-stocks-list')->with(['content'=>$this->content,'type'=>$this->type]);
    }
}
