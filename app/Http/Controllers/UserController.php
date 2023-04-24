<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function animalsPage(){
        return view('user.layouts.animals')->with(['title'=>'Животные']);
    }
    public function amimalCreate(){}
    public function eventsPage(){
        return view('user.layouts.events')->with(['title'=>'Записи']);
    }
    public function createEvent(){}
}
