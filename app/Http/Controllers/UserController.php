<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //load page with $id
    public function index($id = "login")
    {
        return View("pages.".$id);
    }
}
