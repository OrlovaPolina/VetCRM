<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visits extends Model
{
    use HasFactory;
    protected $table = 'visits';
    protected $fillable = ['id','animal_id','doctor_id','event_id','weight','temp','complaints','inspection','therapy'];
    protected $fileds = ['id','animal_id','doctor_id','event_id','weight','temp','complaints','inspection','therapy'];
    protected  $primaryKey = 'id';
    public $timestamps = false;
}
