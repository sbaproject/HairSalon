<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = "t_sales";
    
    public function Shop(){
         return $this->belongsTo('App\Shop','s_sh_id','s_id');
     }
     
      public function Course(){
         return $this->belongsTo('App\Course','s_co_id','s_id');
     }
     
      public function Customer(){
         return $this->belongsTo('App\Customer','s_c_id','s_id');
     }
}
