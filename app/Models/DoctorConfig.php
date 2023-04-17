<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorConfig extends Model
{
    use HasFactory;
    protected $table = 'doctor_config';
    protected $fillable = ['id','doctor_id','name','value'];
}
