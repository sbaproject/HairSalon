<?php

namespace App\Http\Controllers;
use App\Sales;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    //load page with $id
    public function index()
    {
        $list_sales = Sales::all();  
        // $list_staff = Staff::where('s_del_flg', 1)->paginate(10);
        return view('pages.sales', compact('list_sales'));
    }

    public function getSalesNew() {
        return view('pages.sales_new');
    }

    
}
