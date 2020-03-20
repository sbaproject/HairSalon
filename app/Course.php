<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $table = "t_course";
    public $timestamps = false;
    public $primaryKey = 'co_id';

    protected $fillable = ['co_name', 'co_sh_id', 'co_opt1', 'co_opt2', 'co_opt3', 'co_money', 'co_text', 'co_del_flg', 'co_date', 'co_update'];
    
    public function Shop(){
        return $this->belongsTo('App\Shop','co_sh_id','co_id');
    }
     
    public function Sales(){
        return $this->hasMany('App\Sales','s_co_id','co_id');
    }

    public function Option1(){
        return $this->belongsTo('App\Option','co_opt1','op_id');
    }

    public function Option2(){
        return $this->belongsTo('App\Option','co_opt2','op_id');
    }

    public function Option3(){
        return $this->belongsTo('App\Option','co_opt3','op_id');
    }

}
