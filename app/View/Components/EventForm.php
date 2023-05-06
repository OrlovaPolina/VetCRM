<?php

namespace App\View\Components;

use App\Models\Events;
use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EventForm extends Component
{
    protected $id;
    protected $doctors;
    protected $animal;
    /**
     * Create a new component instance.
     */
    public function __construct($id)
    {
        $this->doctors = User::where('role','1')->get();
        $this->id = $id;
        $this->animal = Events::where('id',$id)->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('doctor.components.event-form')->with(['event_id'=> $this->id,'doctors'=>$this->doctors,'animal'=>$this->animal]);
    }
}
