<?php
use app\Models\DoctorConfig;
class Config
{
    /**
     * @param integer $id
     * @param string $name
     * @return array
     */
    public static function get($id,$name){
        $value = null;
        try{
            $value = DoctorConfig::where(['doctor_id'=>$id,'name'=>$name])->get()->first();
        }
        catch(Exception $e){
            return $e;
        }
        return $value;
    }
    
    public static function getAll($id){
        $value = null;
        try{
            $all = DoctorConfig::where('doctor_id',$id)->get();
            foreach($all as $item){
                $value[$item->name] = $item->value;
            }
        }
        catch(Exception $e){
            return $e;
        }
        return $value;
    }
}
