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

    public function createNewsAndStocks(Request $request){
        $fields = $request->all();
        $type = intval($fields['type']);
        $imgUrls = NULL;
        
        foreach($fields as $field){
            $field = preg_replace('/(RENAME)|(rename)|(DROP)|(drop)|(CREATE)|(create)|(DELETE)|(delete)/','',$field);
        }
        if ($request->images){
            $imgUrls = [];
            foreach($request->file('images') as $key=>$img){
                if($img !== null){
                    $name = $img->getClientOriginalName();                    
                    $path = self::UPLOAD_DIR . time() . '-' . $name;
                    $img = $request->file('images')[$key]->storeAs('public',$path);
                    $imgUrls[$key] = 'storage/' . $path;
                }
            }
        }
        // echo '<pre>' . print_r($imgUrls, 1) . '</pre>';
        // die();
        if($type == 0){//Новости
            News::create([
                'title' => $fields['title'],
                'content' => $fields['content'],
                'images_urls' => json_encode($imgUrls),
                'created_at' => new DateTime('now')
            ]);
            

        }
        elseif($type == 1){//Акции
            Stocks::create([
                'title' => $fields['title'],
                'content' => $fields['content'],                        
                'images_urls' => json_encode($imgUrls),        
                'created_at' => new DateTime('now')
            ]);
        }
        $returnUrl = '/manager/news?type=' .( $type == 1 ? 'stocks': 'news');
        return redirect($returnUrl,301);
    }

    public function editNewsStocks($type,$id){

    }

    public function deleteNewsStocks($type,$id){
        if($type == 'stocks'){
            $error = false;
            try{
                Stocks::find($id)->delete();
            }
            catch(Exception $e){
                $error = true;
            }
            return redirect('manager/news?type=stocks',301)->with(['error'=>$error]);
        }
        elseif($type == 'news'){
            $error = false;
            try{
            News::find($id)->delete();
            }
            catch(Exception $e){
                $error = true;
            }
            return redirect('manager/news?type=news',301)->with(['error'=>$error]);
        }
       
    }
    
    function restoreNewsStocks($type,$id)
    {
        if($type == 'stocks'){
            Stocks::withTrashed()->find($id)->restore();
            return redirect('manager/news?type=stocks',301);
        }
        elseif($type == 'news'){
            News::withTrashed()->find($id)->restore();
            return redirect('manager/news?type=news',301);
        }
    }
}
