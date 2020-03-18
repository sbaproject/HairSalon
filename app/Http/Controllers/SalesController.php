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
        $list_sales = Sales::paginate(10);
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
        $request->validate([
            's_c_id'   => 'required',
            's_co_id'    => 'required',
            's_pay'    => 'required',
            's_money'      => 'required',
        ], [
            's_c_id.required'  => '入力してください!',
            's_co_id.required'   => '入力してください!',
            's_pay.required'     => '入力してください!',
            's_money.required'     => '入力してください!'
        ]);

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
        return redirect()->back()->with('success', 'Added Sales successfully!');
    }

    public function getSalesEdit($id) {
        $sales = Sales::where('s_id', $id)->first();
        $list_course = Course::all();
        return view('pages.sales_edit', compact('sales', 'list_course'));
    }

    public function postSalesEdit(Request $request,$id) {
        $request->validate([
            's_c_id'   => 'required',
            's_co_id'    => 'required',
            's_pay'    => 'required',
            's_money'      => 'required',
        ], [
            's_c_id.required'  => '入力してください!',
            's_co_id.required'   => '入力してください!',
            's_pay.required'     => '入力してください!',
            's_money.required'     => '入力してください!'
        ]);

        $sales = Sales::find($id);

        $sales->s_c_id      = $request->get('s_c_id');
        $sales->s_co_id     = $request->get('s_co_id');
        $sales->s_pay       = $request->get('s_pay');
        $sales->s_money     = $request->get('s_money');
        $sales->s_text      = $request->get('s_text');
        $sales->s_update    = Carbon::now();
        $sales->save();
        return redirect()->back()->with('success', 'Updated Sales successfully!');
    }

    public function getSalesDelete($id) {
        $sales = Sales::find($id);
        $sales->s_del_flg = 0;
        $sales->s_update  = Carbon::now();
        $sales->save();
        return redirect()->back()->with('success', 'Deleted Sales successfully!');
    }
}