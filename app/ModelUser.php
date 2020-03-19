<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class ModelUser extends Model implements User
{
    public $pass_new;
	public $pass_confirm;
	
	public function __construct($pass_new, $pass_confirm) {  
        $this->pass_new = $pass_new;
	    $this->pass_confirm = $pass_confirm;
    } 

    public function pass_new(){
        return $this->pass_new;
    }

    public function pass_confirm(){
        return $this->pass_confirm;
    }

}
