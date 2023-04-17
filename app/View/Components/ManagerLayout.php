<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ManagerLayout extends Component
{
    public $users, $search;
    /**
     * Create a new component instance.
     */
    public function __construct($user,$search){
        $this->users = $user;
        $this->search = $search;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('manager.layouts.app')->with(['users'=>$this->users,'search'=> $this->search ]);
    }
}
