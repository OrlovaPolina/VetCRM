<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Stocks;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected const TYPE_CLASS = [
        'news' => News::class,
        'stocks' => Stocks::class,
        0 => News::class,
        1 => Stocks::class,
    ];
    protected const TYPE_CONTENT = [
        'news' => 'Новости',
        'stocks' => 'Акции'
    ];

    public function news(){
        $content = News::paginate(3);
        foreach($content as $item){            
            $item->images_urls = json_decode($item->images_urls); 
        }
        return view('newsStocks')->with(['title'=>'Новости','content'=>$content,'type'=>'news','user_sub' => true]);
    }
    public function stocks(){
        $content = Stocks::paginate(3);
        foreach($content as $item){            
            $item->images_urls = json_decode($item->images_urls); 
        }
        return view('newsStocks')->with(['title'=>'Акции','content'=>$content,'type'=>'stocks','user_sub' => true]);
    }
    public function detail($type,$id){
        try{
            $content = self::TYPE_CLASS[$type]::withTrashed()->where('id',$id)->get()->first();
            $content->images_urls = json_decode($content->images_urls);
            if(!is_null($content->deleted_at)){
                return redirect($type);
            }
            else{
                return view('ns-detail')->with(['content'=>$content,'title'=>self::TYPE_CONTENT[$type],'user_sub' => true]);
            }
        }
        catch(Exception $e){}
    }
    public function about(){

    }
}
