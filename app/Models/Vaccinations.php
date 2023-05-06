<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vaccinations extends Model
{
    use HasFactory;
    protected $table = 'vaccinations';
    protected $fillable = ['id','animal_id','vaccine','date_injected','sell_by'];
    protected $fileds = ['id','animal_id','vaccine','date_injected','sell_by'];
    protected  $primaryKey = 'id';
    public $timestamps = false;
}
