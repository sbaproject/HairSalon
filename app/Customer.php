<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
     protected $table = "t_customer";
     
     public function Sales(){
        return $this->hasMany('App\Sales','s_c_id','c_id');
    }
}
