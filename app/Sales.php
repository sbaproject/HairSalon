<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    // change default Eloquent Model config
    protected $table = "t_sales";
    public $timestamps = false;
    public $primaryKey = 's_id';

    protected $fillable = ['s_c_id', 's_co_id1', 's_co_id2', 's_co_id3', 's_co_id4', 's_co_id5','s_money', 's_saleoff_flg', 's_pay', 's_text', 's_sh_id', 's_del_flg', 'sale_date' ,'s_date', 's_update'];
    
    public function Shop(){
         return $this->belongsTo('App\Shop','s_sh_id','sh_id');
     }
     
    public function Course(){
         return $this->belongsTo('App\Course','s_co_id','co_id');
     }
     
    public function Customer(){
         return $this->belongsTo('App\Customer','s_c_id','c_id');
     }

     public function Option1(){
        return $this->belongsTo('App\Option','s_opt1','op_id');
    }

    public function Option2(){
        return $this->belongsTo('App\Option','s_opt2','op_id');
    }

    public function Option3(){
        return $this->belongsTo('App\Option','s_opt3','op_id');
    }

    public function Option4(){
        return $this->belongsTo('App\Option','s_opt4','op_id');
    }

    public function Option5(){
        return $this->belongsTo('App\Option','s_opt5','op_id');
    }
}
