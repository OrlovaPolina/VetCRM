<?php

namespace App\Http\Controllers;

use App\Models\DoctorConfig;

class Config
{
      /**
     * @param integer $id
     * @param string $name
     * @return object
     */
    public static function get($id,$name){
        $value = null;
        try{
            $value = DoctorConfig::where(['doctor_id'=>$id,'name'=>$name])->get()->first();
        }
        catch(\Exception $e){
            return $e;
        }
        return $value;
    }
    
    public static function getAll($id){
        try{
            $all = DoctorConfig::where('doctor_id',$id)->get();
        }
        catch(\Exception $e){
            return $e;
        }
        return $all;
    }
}