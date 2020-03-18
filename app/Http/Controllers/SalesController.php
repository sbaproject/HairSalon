<?php

namespace App\Http\Controllers;
use App\Sales;
use App\Customer;
use App\Shop;
use App\Course;
use Carbon\Carbon;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    //load page with $id
    public function index()
    {
        $list_sales = Sales::all();  
        //$list_customer = Customer::all();
        $sum_money = Sales::all()->sum('s_money');
        $list_shop = Course::all();

        // print_r($list_customer);
        // exit();
        // $list_staff = Staff::where('s_del_flg', 1)->paginate(10);
        return view('pages.sales', compact('list_sales','sum_money','list_shop'));
    }

    public function getSalesNew() {
        $list_course = Course::all();
        return view('pages.sales_new',compact('list_course'));
    }   

    public function getSearch(Request $req) {
         $list_sales = Sales::where('s_date','>','2020-03-17 15:20:48')
                            ->where('s_date','<','2020-03-17 15:20:48')
                             ->where('s_sh_id',$req->shop_id)
                             ->get();

        // $list_sales = Sales::where('s_sh_id',$req->shop_id)
        //             //->andWhere('s_sh_id',$req->shop_id)
        // ->get();

        $sum_money = $list_sales->sum('s_money');
        $list_shop = Shop::all();

        return view('pages.sales', compact('list_sales','sum_money','list_shop'));
    }   

    public function postSalesNew(Request $request) {
        // $request->validate([
        //     's_firstname'   => 'required',
        //     's_lastname'    => 'required',
        //     's_charge'      => 'required',
        // ], [
        //     's_firstname.required'  => '入力してください!',
        //     's_lastname.required'   => '入力してください!',
        //     's_charge.required'     => '入力してください!'
        // ]);

        // get current time
        $currentTime = Carbon::now();

        $sales = new Sales([
            's_c_id'        => $request->get('s_c_id'),
            's_co_id'       => $request->get('s_co_id'),
            's_pay'         => $request->get('s_pay'),
            's_money'       => $request->get('s_money'),
            's_text'        => $request->get('s_text'),
            's_date'        => $currentTime,
            's_update'      => $currentTime
        ]);
        $sales->save();
        return redirect()->back()->with('success', 'Added staff successfully!');
    }

    public function getSalesEdit($id) {
        $staff = Staff::where('s_id', $id)->first();
        $list_shop = Shop::all();
        return view('pages.staff_edit', compact('staff', 'list_shop'));
    }

    public function postSalesEdit(Request $request) {
        $request->validate([
            's_firstname'   => 'required',
            's_lastname'    => 'required',
            's_charge'      => 'required',
        ], [
            's_firstname.required'  => '入力してください!',
            's_lastname.required'   => '入力してください!',
            's_charge.required'     => '入力してください!'
        ]);

        $staff = Staff::find($request->get('s_id'));

        $staff->s_firstname = $request->get('s_firstname');
        $staff->s_lastname  = $request->get('s_lastname');
        $staff->s_shop      = $request->get('s_shop');
        $staff->s_charge    = $request->get('s_charge');
        $staff->s_text      = $request->get('s_text');
        $staff->s_update    = Carbon::now();
        $staff->save();
        return redirect()->back()->with('success', 'Updated staff successfully!');
    }

    public function getSalesDelete($id) {
        $staff = Staff::find($id);
        $staff->s_del_flg = 0;
        $staff->s_update  = Carbon::now();
        $staff->save();
        return redirect()->back()->with('success', 'Deleted staff successfully!');
    }
}