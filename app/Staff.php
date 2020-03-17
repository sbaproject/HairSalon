<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
     protected $table = "t_staff";
     
     public function Shop(){
         return $this->belongsTo('App\Shop','s_shop','s_id');
     }
}
