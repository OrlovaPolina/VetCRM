<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Stocks;
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Config;
use App\Models\DoctorConfig;
use App\Models\Events;
use Carbon\Carbon;

class ManagerController extends Controller
{

    protected const ROLE_SWITCH = [
        0 => 'off',
        1 => 'on'
    ];
    protected const BLACKLIST_SWITCH = [
        0 => 'off',
        1 => 'on'
    ];
    protected const TYPE_CONTENT = [
        0 => 'news',
        1 => 'stocks'
    ];
    protected const TYPE_CLASS = [
        'news' => News::class,
        'stocks' => Stocks::class,
        0 => News::class,
        1 => Stocks::class,
    ];

    protected const WEEK = [
        0=>Carbon::SUNDAY,
        1=>Carbon::MONDAY,
        2=>Carbon::TUESDAY,
        3=>Carbon::WEDNESDAY,
        4=>Carbon::THURSDAY,
        5=>Carbon::FRIDAY,
        6=>Carbon::SATURDAY,
    ];

    private const UPLOAD_DIR = 'uploads/news/';

    public function search(Request $request){
        $search = $request->filter;
        $users = null;
        if(isset($search['email']) && strlen($search['email']) > 2){
           $users = User::where('email','LIKE','%'. $search['email'] .'%')->get();
           return view('manager.dashboard')->with(['users'=>json_encode($users),'search'=>$search]);
        }
        if(isset($search['userName']) && strlen($search['userName']) > 2){
            $users = User::where('name','LIKE','%'.$search['userName'].'%')->get();
            return view('manager.dashboard')->with(['users'=>json_encode($users),'search'=>$search]);
        }
        return Redirect::route('manager.dashboard',['error'=>true]);
    }

    public function saveUserTable(Request $request){
        foreach($request->users as $users){
            if(intval(Auth::user()->id) !== intval($users['id'])){
                try{
                    $user = User::where('id',$users['id'])->get()->first();
                    if(isset($users['role']) && $users['role'] == 'on'){
                        if(self::ROLE_SWITCH[intval($user->role)] != $users['role']){
                            $user->role = '1';
                        }
                    }
                    else{
                        $users['role'] = 'off';
                        if(self::ROLE_SWITCH[intval($user->role)] != $users['role']){
                            $user->role = '0';                        
                        }
                    }
                    if(isset($users['blacklist']) && $users['blacklist'] == 'on'){
                        if(self::BLACKLIST_SWITCH[intval($user->blacklist)] != $users['blacklist']){
                            $user->blacklist = '1';
                        }
                    }
                    else{
                        $users['blacklist'] = 'off';
                        if(self::BLACKLIST_SWITCH[intval($user->blacklist)] != $users['blacklist']){
                            $user->blacklist = '0';
                        }
                    }
                    $user->save();
                }
                catch(Exception $e){
                    $error = true;
                    echo '<pre>'.print_r($e->getMessage(),1).'</pre>';die();
                    return Redirect::route('manager.dashboard',['error'=>$error]);
                }
            }           
        }  
        $success = true;
        return Redirect::route('manager.dashboard',['success'=>$success]);
    }

    public function createNewsAndStocks(Request $request){
        $fields = $request->all();
        $type = intval($fields['type']);
        $imgUrls = NULL;
        
        foreach($fields as $field){
            $field = preg_replace('/(RENAME)|(rename)|(DROP)|(drop)|(CREATE)|(create)|(DELETE)|(delete)/','',$field);
        }
        if ($request->images){
            $imgUrls = self::saveImageToStorage($request);
        }
        //создание новости/акции
        self::TYPE_CLASS[$type]::create([
            'title' => $fields['title'],
            'content' => $fields['content'],
            'images_urls' => json_encode($imgUrls),
            'created_at' => new DateTime('now'),
            'active_to' => !empty($fields['active_to'])?$fields['active_to']:NULL
        ]);           

        $returnUrl = '/manager/news?type=' .( $type == 1 ? 'stocks': 'news');
        return redirect($returnUrl,301);
    }

    public function editNewsStocksPage($type,$id){
        $content = self::TYPE_CLASS[$type]::withTrashed()->where('id',$id)->get()->first();
        $content->images_urls = json_decode($content->images_urls);
        return view('manager.edit')->with(['content'=>$content,'type'=>$type]);
    }

    public function editNewsStocks(Request $request){
        $fields = $request->all();
        $type = intval($fields['type']);
        $imgUrls = NULL;
        $content = self::TYPE_CLASS[$type]::withTrashed()->where('id',$fields['id'])->get()->first();
        
        foreach($fields as $field){
            $field = preg_replace('/(RENAME)|(rename)|(DROP)|(drop)|(CREATE)|(create)|(DELETE)|(delete)/','',$field);
        }
        $oldImg = $content->toArray();
        $oldImg = json_decode($oldImg['images_urls']);
        
        try{
            if ($request->images){
                $imgUrls = self::saveImageToStorage($request);           
            }
        }
        catch(Exception $e){
            return redirect('manager/'.self::TYPE_CONTENT[$type].'/edit/'.$fields['id'].'?error=true');
        } 

        try{
            self::removeImages($fields['type'],$fields['id'],$imgUrls);
            
            foreach($content->toArray() as $key=>$item){
                if(in_array($key,['title','content','active_to']))
                $content->$key = !empty($fields[$key])?$fields[$key]:NULL;
                elseif($key == 'images_urls')
                $content->$key = json_encode($imgUrls);
            }
            $content->save();
            
            if(isset($fields['deleted_at']) && $fields['deleted_at'] === 'on'){
                self::TYPE_CLASS[$type]::where('id',$fields['id'])->delete();
            }
            if(!isset($fields['deleted_at'])){
                self::TYPE_CLASS[$type]::withTrashed()->where('id',$fields['id'])->restore();
            }
        }  
        catch(Exception $e){
            return redirect('manager/'.self::TYPE_CONTENT[$type].'/edit/'.$fields['id'].'?error=true');
        } 

        return redirect('manager/'.self::TYPE_CONTENT[$type].'/edit/'.$fields['id'].'?success=true');
    }

    private function saveImageToStorage($request){
        $imgUrls = [];
        foreach($request->file('images') as $key=>$img){
            if($img !== null){
                $name = $img->getClientOriginalName();                    
                $path = self::UPLOAD_DIR . time() . '-' . $name;
                if(!is_file('storage/uploads/news/'.$name)){
                    $img = $request->file('images')[$key]->storeAs('public',$path);
                    $imgUrls[$key] = 'storage/' . $path;
                }
                else
                    $imgUrls[$key] = 'storage/uploads/news/'.$name;
            }
        }
        return $imgUrls;
    }

    private function removeImages($type,$id,$newImg){
        $content = self::TYPE_CLASS[$type]::withTrashed()->where('id',$id)->get()->first();
        $content->images_urls = json_decode($content->images_urls);
        foreach($content->images_urls as $img){
            $name = preg_split('/\//',$img);
            $name = $name[count($name) - 1];
            if(is_file($img)){
                if(!in_array($img,$newImg))
                unlink(storage_path('app/public/uploads/news/'.$name));   
            }
        }
    }

    public function deleteNewsStocks($type,$id){
        $error = false;
        try{
            self::TYPE_CLASS[$type]::where('id',$id)->delete();            
        }
        catch(Exception $e){
            $error = true;
        }
        return redirect('manager/news?type='.$type,301)->with(['error'=>$error]);
    }
    
    public function restoreNewsStocks($type,$id)
    {
            self::TYPE_CLASS[$type]::withTrashed()->where('id',$id)->restore();
            return redirect('manager/news?type='.$type,301);
    }

    public function doctorEdit($id){
        $schedule_c = Config::get($id,'schedule');
        $schedule = json_decode($schedule_c->value,1);
        return view('manager.layouts.doctor')->with(['title'=>'Редактирование настроек','user_sub'=>false,'schedule'=>$schedule,'doctor'=>$schedule_c->doctor]);
    }
    public function doctorEditForm(Request $request){
        $last = Config::get($request->doctor,'schedule');
        $last = array_reverse(json_decode($last->value,1));
        $last_ = "";
        $interval = $request->hours;
        $week = $request->week;
        if(count($last)>=1)
        foreach($last as $k=>$l){
            $last_ = new Carbon(new DateTime($k));
            break;
        }
        else
        $last_ = new Carbon();
        $ll = $last_;
        $new_dates = [];
        $next = "";
        foreach ($week as $k=>$v){
            $last = $last_->clone();
            array_push($new_dates,$last->next(self::WEEK[$k])->format('Y-m-d'));
           
            $a=$last->clone();
            for($i = 0;$i<3;$i++){
                $a = $a->clone();
                array_push($new_dates,$a->addWeek()->format('Y-m-d'));
            }
        }
        $new_conf = [];
        foreach($new_dates as $key=>$date){
            // $new_conf[$date];
            $count_intervals = 600 / $interval;
            $time_arr = [];
            $start = new Carbon('2023-01-01 11:00');
            for($i = 0;$i<$count_intervals;$i++){
                $new_conf[$date][$i] = [
                    'start'=>$start->format('H:i'),
                    'end'=>$start->addMinutes($interval)->format('H:i')
                ];
            }
        }
        try{
            $update = DoctorConfig::where(['doctor_id'=>$request->doctor,'name'=>'schedule'])->get()->first();
            $update->value = json_encode($new_conf);
            $update->save();
            $update = DoctorConfig::where(['doctor_id'=>$request->doctor,'name'=>'schedule_work'])->get()->first();
            $update->value = json_encode($new_conf);
            $update->save();
        }
        catch(Exception $e){
            return redirect()->route('manager.doctorEdit',['id'=>$request->doctor,'error'=>true]);
        }
        return redirect()->route('manager.doctorEdit',['id'=>$request->doctor,'success'=>true]);
        
    }

    public function timeTable(){
        $events = Events::all();
        return view('manager.timetable')->with(['title'=>'Расписание','events'=>$events]);
    }

    public function deleteEvent($id){
        $params = ['title'=>'Расписание'];
        try{
            $event = Events::where('id',$id)->get()->first();
            $event->delete();
            $params['success'] = true;
        }
        catch(Exception $e){
            $params['error'] = $e->getMessage();
        }
        return redirect()->route('manager.timetable',$params);
    }
}
