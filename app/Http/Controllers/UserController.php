<?php

namespace App\Http\Controllers;

use App\Models\Animals;
use App\Models\Breed;
use App\Models\DoctorConfig;
use App\Models\Events;
use App\Models\Species;
use App\Models\User;
use App\Models\Visits;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Dompdf\Adapter\PDFLib;
use App\Http\Controllers\Config;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class UserController extends Controller
{
    public function animalsPage(){
        $animals = Animals::where('user_id',Auth::user()->id)->get();
        $ev = [];
        $evKeys = [];        
        foreach($animals as $animal){
            $evKeys[] = $animal->id;
        }
        $events = DB::table('events')
        ->select(DB::raw('id, animal_id, max(start) as start'))
        ->whereIn('animal_id', $evKeys)
        ->groupBy('animal_id')
        ->get();
        foreach($events as $event){
            $ev[$event->animal_id] = $event->start;
        }
        $visits = DB::table('visits')
                    ->select(DB::raw('animal_id, max(id) as id, weight'))
                    ->whereIn('animal_id', $evKeys)
                    ->groupBy('animal_id')
                    ->get();
        $evKeys = [];
        foreach($visits as $visit){
            $evKeys[$visit->animal_id] = $visit->weight;
        }        
        return view('user.layouts.animals')->with(['title'=>'Животные','animals'=>$animals,'events'=>$ev,'visits'=>$evKeys]);
    }

    public function animalsCreatePage(){
        $breed = Breed::all();
        $species = Species::all();
        return view('user.layouts.animal-create')->with(['title'=>'Животные','breed'=>$breed,'species'=>$species]);
    }
    
    public function animalCreate(Request $request){
        if(isset($request) && !empty($request)){
            $params = self::create($request->all());
            $params['user_id'] = Auth::user()->id;
            try{                
                Animals::create($params);
            }
            catch(Exception $e){
               return redirect()->route('user.animals',['error'=>true]);
            }
            finally{
                return redirect()->route('user.animals',['success'=>true]);
                // redirect('/user/animals',301);
            }
        }
    }

    public function eventsPage(){
        $animals = Animals::where('user_id',Auth::user()->id)->get();
        $ev = [];
        $evKeys = [];        
        foreach($animals as $animal){
            $evKeys[] = $animal->id;
        }
        $events = Events::whereIn('animal_id', $evKeys)
        ->get();
        // $visits = DB::table('visits')
        //             ->select(DB::raw('id, animal_id, event_id, weight,temp,complaints,inspection,therapy'))
        //             ->whereIn('animal_id', $evKeys)
        //             ->get();      
        $visits = Visits::whereIn('animal_id', $evKeys)->get(); 
        return view('user.layouts.events')->with(['title'=>'Записи','events'=>$events,'visits'=>$visits]);
    }

    public function createEventPage(){
            $animals = Animals::where('user_id',Auth::user()->id)->get();
            $doctors = User::where('role','1')->get();
            return view('user.layouts.event')->with(['title'=>'Записаться на приём','user_sub'=>true,'animals'=> $animals,'doctors'=>$doctors ]);
       
    }

    public function getDoctorsParameters(Request $request){
        $doctor_config = Config::get($request->doctor,'schedule_work');
        return response()->json(['doctor'=>json_decode($doctor_config->value,1)]);
    }

    public function createEvent(Request $request){
        $animals = $request->animals;
        $doctors = $request->doctors;
        $doctors_d = $request->doctors_date;
        $doctors_t = $request->doctors_time;
        $title = 'Запись к ' . User::where('id',$doctors)->get()->first()->name;
        $config = Config::get($doctors,'schedule_work');
        $config = json_decode($config->value,1);
        $error = true;
        $endTime = '';
        
        foreach($config[$doctors_d] as $key=>$day){            
            foreach($day as $k=>$start){
                if($k=='start'){
                    if($start == $doctors_t)
                    {
                        $error = false;
                        $endTime = $config[$doctors_d][$key]['end'];
                        unset($config[$doctors_d][$key]);
                    }
                }
            }          
        }

        if($error == false){
            try{
                $update = DoctorConfig::where(['doctor_id'=>$doctors,'name'=>'schedule_work'])->get()->first();
                $update->value = json_encode($config);
                $update->save();
                $start = new Carbon(new DateTime($doctors_d .' ' . $doctors_t));
                $start = $start->format('Y-m-d H:i:s');
                $end = new Carbon(new DateTime($doctors_d .' ' . $endTime));
                $now = new Carbon();
                $now = $now->format('Y-m-d H:i:s');
                $event = Events::create([
                    'title'=>$title,
                    'start'=>$start,
                    'end'=>$end,
                    'created_at'=> $now,
                    'user_id'=>Auth::user()->id,
                    'doctor_id'=>$doctors,
                    'animal_id'=>$animals
                ]);
            }
            catch(Exception $e){
                return redirect()->route('user.createEventPage',['error'=>true]);
            }
            
        }
        else{
            return redirect()->route('user.createEventPage',['error'=>true]);
        }
        
        return redirect()->route('user.createEventPage',['success'=>true]);
    }

    public function download(Request $request){
        $animal = Animals::where('id',$request->id)->first();
        $events = Events::where('animal_id', $animal->id)->get(); 
        $visits = Visits::where('animal_id', $animal->id)->get(); 
        view()->share('animal_name',$animal);
        view()->share('events',$events);
        view()->share('visits',$visits);
        $data = ['title'=>'Записи','animal_name'=>$animal,'events'=>$events,'visits'=>$visits];

        $pdf = PDF::loadView('user.layouts.animal-pdf', $data)
        ->setOption('default_font', 'dejavu')
        ->setOption('isHtml5ParserEnabled',true);
        return $pdf->download($animal->id.'_'.date('Y_m_d').'.pdf');
    }

    private function create($request){
        $arr = [];
        foreach($request as $k=>$field){
            if($k != '_token'){
                if($k == 'breed')
                $arr['breed_id'] = $field;  
                elseif($k == 'species')
                $arr['species_id'] = $field;  
                elseif($k == 'passport')
                $arr['passport'] = '1';
                else
                $arr[$k] = $field;  
            }
        }
        if(!array_key_exists('passport',$request)){
            $arr['passport'] = '0';
        }
        $arr['created_at'] = date("Y-m-d H:i:s");

        return $arr;
    } 
}
