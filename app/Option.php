<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = "t_option";
    public $timestamps = false;
    public $primaryKey = 'op_id';

    protected $fillable = ['op_name', 'op_amount', 'op_del_flg'];
     
}
