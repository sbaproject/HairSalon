<?php

namespace App\Http\Controllers;
use App\Sales;
use App\Customer;
use App\Shop;
use App\Course;
use App\User;
use Carbon\Carbon;

use Illuminate\Http\Request;

class SalesController extends Controller
{
    //load page with $id
    public function index()
    {
        $list_sales = Sales::paginate(10); 
        $sum_money = Sales::all()->sum('s_money');
        $list_shop = Shop::all();
        $list_sales_count = Sales::count();         
        
        return view('pages.sales', compact('list_sales','sum_money','list_shop','list_sales_count'));
    }

    public function getSalesNew() {
        $list_course = Course::all();
        $list_sales_count = Sales::count() + 1;
        $list_customer = Customer::all();

        if($list_sales_count < 10){
            $list_sales_count = '0'. $list_sales_count;
        }     

        return view('pages.sales_new',compact('list_course','list_sales_count','list_customer'));
    }   

    public function postSearch(Request $req) {
        
        $req->validate([
            'str_date'   => 'required',
            'end_date'    => 'required',           
        ], [
            'str_date.required'  => '入力してください!',
            'end_date.required'   => '入力してください!'
        ]);


        $str_date = str_replace('/','-',$req->str_date) . ' 00:00:00';
        $end_date = str_replace('/','-',$req->end_date) . ' 23:59:59';        

        $list_sales = Sales::where('s_date','>=',$str_date)
                                ->where('s_date','<=',$end_date)
                                ->where('s_sh_id',$req->shop_id)                             
                                ->paginate(10);

        $sum_money = $list_sales->sum('s_money');
        $list_sales_count = $list_sales->count();
        $list_shop = Shop::all();

        return view('pages.sales', compact('list_sales','sum_money','list_shop','list_sales_count'));
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

        if($request->get('hid') == 1){
            return redirect()->back()->with('success', 'Added Sales successfully!');
        }else{
            return redirect('sales')->with('success', 'Added Sales successfully!');
        }        
    }

    public function getSalesEdit($id,$index) {
        $sales = Sales::where('s_id', $id)->first();
        $list_course = Course::all();
        return view('pages.sales_edit', compact('sales', 'list_course','index'));
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
        return redirect('sales')->with('success', 'Updated Sales successfully!');
    }

    // public function getSalesDelete($id) {
    //     $sales = Sales::find($id);
    //     $sales->s_del_flg = 0;
    //     $sales->s_update  = Carbon::now();
    //     $sales->save();
    //     return redirect()->back()->with('success', 'Deleted Sales successfully!');
    // }

    public function getCustomerAjax(Request $request) {
                
        if($request->get('a'))
        {
            $customer = Customer::where('',$request->get('a'));
           
            //$outpub = $customer->c_firstname . '/' . $customer->c_lastname
           
        //     $data = DB::table('products')
        //     ->where('name_product', 'LIKE', "%{$query}%")
        //     ->get();
        //     $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
           
        //     foreach($data as $row)
        //     {
        //        $output .= '
        //        <li><a href="data/'. $row->id .'">'.$row->name_product.'</a></li>
        //        ';
        //    }
        //    $output .= '</ul>';
           echo "thach";
       }       
       echo "thach"; 
    }
    
}