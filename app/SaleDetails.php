<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleDetails extends Model
{
    // change default Eloquent Model config
    protected $table = "t_salesdetails";
    public $timestamps = false;

    protected $fillable = ['s_id','s_co_id', 's_opt1', 's_opt2', 's_opt3', 's_opt4', 's_opt5', 's_opts1', 's_opts2', 's_opts3', 's_opts4', 's_opts5', 's_money', 's_date', 's_update'];

    public function Sales(){
        return $this->belongsTo('App\Sales','s_id','s_id');
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
