<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
     protected $table = "t_user";
    public $timestamps = false;
    public $primaryKey = 'u_id';

    protected $fillable = ['u_user', 'u_pw', 'u_name', 'u_address', 'u_update', 'u_date'];
     
     public function Shop(){
         return $this->belongsTo('App\Shop','u_shop','u_id');
     }
}
