<?php

namespace App\View\Components;

use App\Models\News;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ManagerNewsList extends Component
{
    protected $news;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->news = News::withTrashed()->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('manager.components.manager-news-list')->with(['news'=>$this->news]);
    }
}
