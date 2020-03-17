<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;

class StaffController extends Controller
{
    public function index() {
        $list_staff = Staff::all();  
        // $list_staff = Staff::where('s_del_flg', 1)->paginate(10);
        return view('pages.staff', compact('list_staff'));
    }    

    public function getStaffNew() {
        return view('pages.staff_new');
    }
}
