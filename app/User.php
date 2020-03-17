<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
     protected $table = "t_user";
     
     public function Shop(){
         return $this->belongsTo('App\Shop','u_shop','u_id');
     }
}
