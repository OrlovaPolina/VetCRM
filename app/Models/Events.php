<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $fillable = ['id','title','start','end','created_at','updated_at','user_id','doctor_id','animal_id'];
    protected $fileds = ['id','title','start','end','created_at','updated_at','user_id','doctor_id','animal_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function doctor() {
        return $this->belongsTo(User::class);
    }
    public function animal() {
        return $this->belongsTo(Animals::class);
    }
}
