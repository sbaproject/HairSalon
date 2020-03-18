<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    // change default Eloquent Model config
    protected $table = "t_staff";
    public $timestamps = false;
    public $primaryKey = 's_id';

    protected $fillable = ['s_firstname', 's_lastname', 's_shop', 's_charge', 's_text', 's_date', 's_update'];
     
    public function Shop(){
        return $this->belongsTo('App\Shop','s_shop','sh_id');
    }
}
