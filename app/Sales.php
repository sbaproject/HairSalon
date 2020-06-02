<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    // change default Eloquent Model config
    protected $table = "t_sales";
    public $timestamps = false;
    public $primaryKey = 's_id';

    protected $fillable = ['s_c_id','s_money', 's_saleoff_flg', 's_pay', 's_text', 's_sh_id', 's_del_flg', 'sale_date' ,'s_date', 's_update'];
    
    public function Shop(){
         return $this->belongsTo('App\Shop','s_sh_id','sh_id');
    }

    public function Customer(){
         return $this->belongsTo('App\Customer','s_c_id','c_id');
    }

    public function SaleDetails(){
        return $this->hasMany('App\SaleDetails','s_id','s_id')->orderBy('s_co_num');
    }

}
