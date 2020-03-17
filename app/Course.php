<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = "t_course";
    
    public function Shop(){
         return $this->belongsTo('App\Shop','co_sh_id','co_id');
     }
     
     public function Sales(){
        return $this->hasMany('App\Sales','s_co_id','co_id');
    }
}
