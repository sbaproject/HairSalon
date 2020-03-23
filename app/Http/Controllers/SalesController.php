<?php

namespace App\Http\Controllers;
use App\Sales;
use App\Customer;
use App\Shop;
use App\Course;
use App\User;
use App\Staff;
use App\Option;
use Carbon\Carbon;

use Illuminate\Http\Request;

class SalesController extends Controller
{ 
    //load page with $id
    public function index()
    {
        $list_sales = Sales::where('s_del_flg', 0)->orderBy('s_id', 'DESC')->paginate(10); 
        $sum_money = Sales::where('s_del_flg', 0)->sum('s_money');
        $list_shop = Shop::all();
        $list_sales_count = Sales::where('s_del_flg', 0)->count();   
        // get current time
        $currentTime = Carbon::now()->format('yy/m/d');
        
        return view('pages.sales', compact('list_sales','sum_money','list_shop','list_sales_count','currentTime'));
    }

    public function getSalesNew() {
        $list_course = Course::where('co_del_flg', 0)->get();
        $list_sales_count = Sales::where('s_del_flg', 0)->count() + 1;
        $list_customer = Customer::all();
        $list_staff = Staff::where('s_del_flg', 0)->get();
        $list_option = Option::where('op_del_flg', 0)->get();
        // get current time
        $currentTime = Carbon::now()->format('yy/m/d');

        if($list_sales_count < 10){
            $list_sales_count = '0'. $list_sales_count;
        }     

        return view('pages.sales_new',compact('list_course','list_sales_count','list_customer','list_staff','list_option','currentTime'));
    }   

    public function postSearch(Request $req) {
        
        $req->validate([
            'str_date'   => 'required|date',
            'end_date'    => 'required|date|after_or_equal:str_date',           
        ], [
            'str_date.required'  => '入力してください!',
            'end_date.required'   => '入力してください!'
        ]);

        $str_date = str_replace('/','-',$req->str_date) . ' 00:00:00';
        $end_date = str_replace('/','-',$req->end_date) . ' 23:59:59';        

        $list_sales = Sales::where('s_date','>=',$str_date)
                                ->where('s_date','<=',$end_date)
                                ->where('s_sh_id',$req->shop_id)    
                                ->where('s_del_flg', 0)                         
                                ->paginate(10);

        $sum_money = $list_sales->sum('s_money');
        $list_sales_count = $list_sales->count();
        $list_shop = Shop::all();
        // get current time
        $currentTime = Carbon::now()->format('yy/m/d');

        //session()->regenerate();
        session(['search' => $list_sales_count]);

        return view('pages.sales', compact('list_sales','sum_money','list_shop','list_sales_count','currentTime'));
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

        $course = Course::where('co_id',$request->get('s_co_id'))
                            ->where('co_del_flg', 0)                      
                            ->first();

        $money = 0;
        if(!empty($course->Option1->op_amount)){
            $money = $money + $course->Option1->op_amount;
        }
        if(!empty($course->Option2->op_amount)){
            $money = $money + $course->Option2->op_amount;
        }
        if(!empty($course->Option3->op_amount)){
            $money = $money + $course->Option3->op_amount;
        }

        $sales = new Sales([
            's_c_id'        => $request->get('s_c_id'),
            's_co_id'       => $request->get('s_co_id'),
            's_opt1'        => $course->co_opt1,
            's_opts1'       => $request->get('s_opts1'),
            's_opt2'        => $course->co_opt2,
            's_opts2'       => $request->get('s_opts2'),
            's_opt3'        => $course->co_opt3,
            's_opts3'       => $request->get('s_opts3'),           
            's_money'       => $money,
            's_pay'         => $request->get('s_pay'),
            's_text'        => $request->get('s_text'),
            's_sh_id'       => session('user')-> u_id,
            's_del_flg'     => 0,
            'sale_date'     => $request->get('sale_date'),
            's_date'        => $currentTime,
            's_update'      => $currentTime
        ]);
        $sales->save();

        if($request->get('hid') == 1){
            return redirect()->back()->with('success', 'Added Sales successfully!');
        }else{
            return redirect('sales')->with('success', 'Added Sales successfully!');
        }        
    }

    public function getSalesEdit($id,$index) {
        $sales = Sales::where('s_id', $id)->where('s_del_flg', 0) ->first();
        $list_course = Course::where('co_del_flg', 0)->get();
        $list_customer = Customer::all();
        $list_staff = Staff::where('s_del_flg', 0)->get();
        $list_option = Option::where('op_del_flg', 0)->get();
        
        $salesDate = date('yy/m/d', strtotime($sales->sale_date));

        return view('pages.sales_edit', compact('sales', 'list_course','index','list_customer','list_staff','list_option','salesDate'));
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

        $course = Course::where('co_id',$request->get('s_co_id'))
        ->where('co_del_flg', 0)                      
        ->first();

        $money = 0;
        if(!empty($course->Option1->op_amount)){
            $money = $money + $course->Option1->op_amount;
        }
        if(!empty($course->Option2->op_amount)){
            $money = $money + $course->Option2->op_amount;
        }
        if(!empty($course->Option3->op_amount)){
            $money = $money + $course->Option3->op_amount;
        }

        $sales = Sales::find($id);

        $sales->s_c_id      = $request->get('s_c_id');
        $sales->s_co_id     = $request->get('s_co_id');
        $sales->s_opt1      = $course->co_opt1;
        $sales->s_opts1     = $request->get('s_opts1');
        $sales->s_opt2      = $course->co_opt2;
        $sales->s_opts2     = $request->get('s_opts2');
        $sales->s_opt3      = $course->co_opt3;
        $sales->s_opts3     = $request->get('s_opts3');
        $sales->s_money     = $money;
        $sales->s_pay       = $request->get('s_pay');        
        $sales->s_text      = $request->get('s_text');        
        $sales->s_sh_id     = session('user')-> u_id;
        $sales->s_del_flg   = 0;
        $sales->sale_date   = $request->get('sale_date');
        $sales->s_update    = Carbon::now();
        $sales->save();
        return redirect('sales')->with('success', 'Updated Sales successfully!');
    }

    public function getSalesDelete($id) {
        $sales = Sales::find($id);
        $sales->s_del_flg = 1;
        $sales->s_update  = Carbon::now();
        $sales->save();
        return redirect()->back()->with('success', 'Deleted Sales successfully!');
    }    
}