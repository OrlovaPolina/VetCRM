<?php

namespace App\View\Components;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ManagerForms extends Component
{
    public $users, $search;
    /**
     * Create a new component instance.
     */
    public function __construct($user,$search)
    {
        
        if($user === null){
            $usersAll = User::all();
           $this->users = $usersAll;
        }
        else{
            $this->users = json_decode($user,false);
        }
        $this->search = $search;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {        
        // 
        return view('components.manager-forms')->with(['users'=>$this->users,'search'=>$this->search]);
    }
}
