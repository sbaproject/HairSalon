<?php

namespace App\Http\Controllers;
use App\Sales;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    //load page with $id
    public function index($id = "login")
    {
        $sales = Sales::all();
        //print_r($sales);
        //exit();
        return View("pages.sales");
    }
}
