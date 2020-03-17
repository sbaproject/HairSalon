<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $table = "t_shop";
    
    public function staff(){
        return $this->hasMany('App\Staff','s_shop','sh_id');
    }
}
