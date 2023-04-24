<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function animalsPage(){
        return view('doctor.layouts.events')->with(['title'=>'Расписание']);;
    }
    public function eventNow(){}
    public function currentEvent(){
        return view('doctor.layouts.event')->with(['title'=>'Приём']);
    }
}
