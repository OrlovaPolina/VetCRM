<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animals extends Model
{
    use HasFactory;
    protected $table = 'animals';
    protected $fillable = ['id','user_id','name','breed_id','species_id','age','passport','created_at','updated_at'];
    public function breed(){
        return $this->belongsTo(Breed::class);
    }
    public function species(){
        return $this->belongsTo(Species::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
