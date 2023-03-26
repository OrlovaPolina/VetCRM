<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
    /**
     * Класс отвечает за изменения бд через Web интерфейс
     */

    /**
     * Создание нового врача в бд 
     * 
     * 
     *  */ 
    public function createDoctor(Request $request){
        
    }

    public function deleteDoctor(Request $request){

    }

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
                    $user = User::find($users['id']);
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
                    return Redirect::route('manager.dashboard',['error'=>$error]);
                }
            }           
        }  
        $success = true;
        return Redirect::route('manager.dashboard',['success'=>$success]);
    }
}
