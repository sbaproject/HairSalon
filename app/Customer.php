<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
     // change default Eloquent Model config
    protected $table = "t_customer";
    public $timestamps = false;
    public $primaryKey = 'c_id';

    protected $fillable = ['c_firstname', 'c_lastname', 'c_text', 'c_sh_id', 'c_date', 'c_update'];
     
     public function Sales(){
        return $this->hasMany('App\Sales','s_c_id','c_id');
    }
}
