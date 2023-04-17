<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stocks extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'Stocks';
    protected $fillable = ['id','title','content','created_at','deleted_at','images_urls','active_to'];
}
