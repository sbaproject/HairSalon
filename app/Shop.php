<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = "t_shop";
    
    public function staff(){
        return $this->hasMany('App\Staff','s_shop','sh_id');
    }
    
     public function user(){
        return $this->hasMany('App\User','u_shop','sh_id');
    }
    
    public function course(){
        return $this->hasMany('App\Course','co_sh_shop','sh_id');
    }
    
    public function sales(){
        return $this->hasMany('App\Sales','s_sh_shop','sh_id');
    }
}
