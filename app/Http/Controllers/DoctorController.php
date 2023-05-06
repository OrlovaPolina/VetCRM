<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Config;
use App\Models\DoctorConfig;
use App\Models\User;
use App\Models\Vaccinations;
use App\Models\Visits;
use Carbon\Carbon;
use DateTime;
use Exception;

class DoctorController extends Controller
{
    public function timeboard(){
        $events = Events::where('doctor_id',Auth::user()->id)->get();
        return view('doctor.layouts.timeboard')->with(['title'=>'Расписание','events'=>$events]);
    }
    public function eventNow(){
        $doctors = User::where('role','1')->get();
        $id = $_GET['id'];
        $animal = Events::where('id', $id)->first();
        $param = ['title'=>'Приём','event_id'=> $id,'doctors'=>$doctors,'animal'=>$animal];
        $visits = Visits::where('event_id',$id)->get()->last();
        if(!empty($visits)){
            $param['visits'] = $visits;
        }
        $vaccinations = Vaccinations::where('animal_id',$animal->animal->id)->get()->last();
        if(!empty($vaccinations)){
            $param['vaccinations'] = $vaccinations;
        }
        return view('doctor.layouts.event')->with($param);
    }

    public function getDoctorsParameters(Request $request){
        $doctor_config = Config::get($request->doctor,'schedule_work');
        return response()->json(['doctor'=>json_decode($doctor_config->value,1)]);
    }

    public function currentEvent(Request $request){
        $data = $request->all();
        $params = [
            'title'=>'Приём'
        ];
        $now = new Carbon();
        $now = $now->format('Y-m-d H:i:s');
        foreach($data as $key => $val){  
                if($key == 'visits'){
                    if(isset($val['id']))
                    {
                        try{
                            $visit = Visits::where('id',$val['id'])->get()->first();
                            $visit->animal_id= $val['animal_id'];
                            $visit->doctor_id= $val['doctor_id'];
                            $visit->event_id= $val['event_id'];
                            $visit->weight= $val['weight'];
                            $visit->temp= $val['temp'];
                            $visit->complaints= $val['complaints'];
                            $visit->inspection=$val['inspection'];
                            $visit->therapy= $val['therapy']; 
                            $visit->save();
                            $params['success'] = true;    
                        }       
                        catch(Exception $e){
                            $params['success_error'] = true;
                        }
                    }
                    else{
                        try{
                            Visits::create([
                                'animal_id'=> $val['animal_id'],
                                'doctor_id'=> $val['doctor_id'],
                                'event_id'=> $val['event_id'],
                                'weight'=> $val['weight'],
                                'temp'=> $val['temp'],
                                'complaints'=> $val['complaints'],
                                'inspection'=> $val['inspection'],
                                'therapy'=> $val['therapy'] 
                            ]);    
                            $params['success'] = true;    
                        }       
                        catch(Exception $e){
                            $params['success_error'] = $e->getMessage();;
                        }
                    }
                }
                if($key == 'vaccinations'){
                    if(isset($val['check']))
                    {
                        if(isset($val['id'])){
                            try{
                                $vaccination = Vaccinations::where('id',$val['id'])->get()->first();
                                $vaccination->animal_id = $val['animal_id'];
                                $vaccination->vaccine = $val['vaccine'];
                                $vaccination->date_injected = $now;
                                $vaccination->sell_by = $val['sell_by'];
                                $vaccination->save();
                                $params['vaccinations'] = true;
                            }
                            catch(Exception $e){
                                $params['vaccinations_error'] = $e->getMessage();
                            }
                        }
                        else{
                            try{
                        
                                Vaccinations::create([
                                    'animal_id' =>$val['animal_id'],
                                    'vaccine' =>$val['vaccine'],
                                    'date_injected' =>$now,
                                    'sell_by' =>$val['sell_by'],
                                ]);
                                $params['vaccinations'] = true;
                            }
                            catch(Exception $e){
                                $params['vaccinations_error'] = true;
                            }
                        }                        
                    }
                }
                if($key == 'reAdmission'){
                    if(isset($val['check']))
                    {
                        try{
                            $animals = $val['animal_id'];
                            $doctors = $val['doctors'];
                            $user = $val['user_id'];
                            $doctors_d = $val['doctors_date'];
                            $doctors_t = $val['doctors_time'];
                            $title = 'Запись к ' . User::where('id',$doctors)->get()->first()->name;
                            $config = Config::get($doctors,'schedule_work');
                            $config = json_decode($config->value,1);
                            $endTime = '';
                            $error = true;
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
                                $update = DoctorConfig::where(['doctor_id'=>$doctors,'name'=>'schedule_work'])->get()->first();
                                $update->value = json_encode($config);
                                $update->save();
                                $start = new Carbon(new DateTime($doctors_d .' ' . $doctors_t));
                                $start = $start->format('Y-m-d H:i:s');
                                $end = new Carbon(new DateTime($doctors_d .' ' . $endTime));
                                $event = Events::create([
                                    'title'=>$title,
                                    'start'=>$start,
                                    'end'=>$end,
                                    'created_at'=> $now,
                                    'user_id'=>$user,
                                    'doctor_id'=>$doctors,
                                    'animal_id'=>$animals
                                ]);                            
                                $params['success_reAd'] = true;
                            }
                        }
                        catch(Exception $e){
                            $params['success_reAd_error'] = true;
                        }
                    }
                }
            }
            // echo '<pre>' . print_r($params, 1) . '</pre>';
            // die();
        return redirect()->route('doctor.timeboard',$params);
    }
}
