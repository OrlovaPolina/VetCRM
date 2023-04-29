<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class userEventsList extends Component
{
    protected $events;
    protected $visits;
    /**
     * Create a new component instance.
     */
    public function __construct($events,$visits)
    {
        $this->events = $events;
        $this->visits = $visits;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('user.components.user-events-list')->with(['events'=>$this->events,'visits'=>$this->visits]);
    }
}
