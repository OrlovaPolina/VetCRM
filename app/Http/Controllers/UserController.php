<?php

namespace App\Http\Controllers;

use App\Models\Animals;
use App\Models\Breed;
use App\Models\Events;
use App\Models\Species;
use App\Models\Visits;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                redirect('/user/animals?error=true');
            }
            finally{
                redirect('/user/animals',301);
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

    public function createEvent(Request $request){}

    public function download(){}

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
