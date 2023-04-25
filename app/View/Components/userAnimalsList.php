<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class userAnimalsList extends Component
{
    protected $animals;
    protected $events;
    protected $visits;
    /**
     * Create a new component instance.
     */
    public function __construct($animals,$events,$visits)
    {
        $this->animals = $animals;
        $this->events = $events;
        $this->visits = $visits;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('user.components.user-animals-list')->with(['animals'=>$this->animals,'events'=>$this->events,'visits'=> $this->visits]);
    }
}
