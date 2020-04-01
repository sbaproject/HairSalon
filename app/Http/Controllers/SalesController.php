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
use Session;

use Illuminate\Http\Request;

class SalesController extends Controller
{ 
    //load page with $id
    public function index(Request $req)
    {
        if(!empty($req->str_date)&&!empty($req->end_date)&&!empty($req->shop_id)){
            
            $req->validate([
                'str_date'   => 'required|date',
                'end_date'    => 'required|date|after_or_equal:str_date',           
            ], [
                'end_date.after_or_equal'  => '終了日は開始日以降の日付を選択してください。',
            ]);
    
            $str_date = str_replace('/','-',$req->str_date) . ' 00:00:00';
            $end_date = str_replace('/','-',$req->end_date) . ' 23:59:59';        
    
            $list_sales = Sales::where('sale_date','>=',$str_date)
                                    ->where('sale_date','<=',$end_date)
                                    ->where('s_sh_id',$req->shop_id)    
                                    ->orderBy('s_id', 'DESC')
                                    ->where('s_del_flg', 0);                        
    
            $sum_money = $list_sales->sum('s_money');
            $list_sales_count = $list_sales->count();
            $list_shop = Shop::all();
            // get current time
            $currentTime = Carbon::now()->format('yy/m/d');
    
            $str_date = date('yy/m/d', strtotime($str_date));
            $end_date = date('yy/m/d', strtotime($end_date));
    
            $shopId = $req->shop_id;
    
            session(['search' => $list_sales_count]);
    
            $list_sales = Sales::where('sale_date','>=',$str_date)
            ->where('sale_date','<=',$end_date)
            ->where('s_sh_id',$req->shop_id)    
            ->where('s_del_flg', 0)
            ->orderBy('s_id', 'DESC')
            ->paginate(10);
    
            return view('pages.sales', compact('list_sales','sum_money','list_shop','list_sales_count','currentTime','str_date','end_date','shopId'));

        }else{

            $list_sales = Sales::where('s_del_flg', 0)->orderBy('s_id', 'DESC')->paginate(10); 
            $sum_money = Sales::where('s_del_flg', 0)->sum('s_money');
            $list_shop = Shop::all();
            $list_sales_count = Sales::where('s_del_flg', 0)->count();   
            $currentTime = Carbon::now()->format('yy/m/d');
            
            return view('pages.sales', compact('list_sales','sum_money','list_shop','list_sales_count','currentTime'));
        }        
    }

    public function getSalesNew() {
         // check login
         $userLogged = Session::get('user');
         if ($userLogged == null) {
             return redirect('/login');
         }

        $list_course = Course::where('co_del_flg', 0)->where('co_sh_id', $userLogged->u_shop)->get();
        $list_customer = Customer::all();
        $list_staff = Staff::where('s_del_flg', 0)->get();
        $list_option = Option::where('op_del_flg', 0)->where('op_shop', $userLogged->u_shop)->get();
        $currentTime = Carbon::now()->format('yy/m/d');

        $last_sales = Sales::orderBy('s_id', 'DESC')->take(1)->first('s_id');
        if ($last_sales != null) {
            $last_sales_id = $last_sales->s_id;
        } else {
            $last_sales_id = 0;
        }  

        return view('pages.sales_new',compact('list_course','last_sales_id','list_customer','list_staff','list_option','currentTime'));
    }   

    public function postSalesNew(Request $request) {

         $request->validate([
            's_c_id'   => 'required',
            's_co_id'    => 'required',
        ], [
            's_c_id.required'  => '入力してください。',
            's_co_id.required'   => '入力してください。',
        ]);     

        // get current time
        $currentTime = Carbon::now();

        $course = Course::where('co_id',$request->get('s_co_id'))
                            ->where('co_del_flg', 0)                      
                            ->first();


        if ($course->co_opt1 != null && $request->get('s_opts1') === null ) {
            $customer_error = "入力してください。";
            return redirect()->back()->withInput($request->input())->withErrors(['customer_error' => $customer_error]);            
        }   

        if ($course->co_opt2 != null && $request->get('s_opts2') === null ) {
                        $customer_error2 = "入力してください。";
                        return redirect()->back()->withInput($request->input())->withErrors(['customer_error2' => $customer_error2]);                        
        }  

        if ($course->co_opt3 != null && $request->get('s_opts3') === null ) {
                        $customer_error3 = "入力してください。";
                        return redirect()->back()->withInput($request->input())->withErrors(['customer_error3' => $customer_error3]);                        
        }  
        
        if ($course->co_opt4 != null && $request->get('s_opts4') === null ) {
            $customer_error4 = "入力してください。";
            return redirect()->back()->withInput($request->input())->withErrors(['customer_error4' => $customer_error4]);                        
        }  

        if ($course->co_opt5 != null && $request->get('s_opts5') === null ) {
                    $customer_error5 = "入力してください。";
                    return redirect()->back()->withInput($request->input())->withErrors(['customer_error5' => $customer_error5]);                        
        }  
                            
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
        if(!empty($course->Option4->op_amount)){
            $money = $money + $course->Option4->op_amount;
        }
        if(!empty($course->Option5->op_amount)){
            $money = $money + $course->Option5->op_amount;
        }

        $sales = new Sales([
            's_c_id'        => $request->get('s_c_id'),
            's_co_id'       => $request->get('s_co_id'),
            's_opt1'        => $course->co_opt1,
            's_opts1'       => ( $course->co_opt1 === null ? null : $request->get('s_opts1')),
            's_opt2'        => $course->co_opt2,
            's_opts2'       => ( $course->co_opt2 === null ? null : $request->get('s_opts2')),
            's_opt3'        => $course->co_opt3,
            's_opts3'       => ( $course->co_opt3 === null ? null : $request->get('s_opts3')),    
            's_opt4'        => $course->co_opt4,
            's_opts4'       => ( $course->co_opt4 === null ? null : $request->get('s_opts4')), 
            's_opt5'        => $course->co_opt5,
            's_opts5'       => ( $course->co_opt5 === null ? null : $request->get('s_opts5')),        
            's_money'       => $money,
            's_pay'         => $request->get('s_pay'),
            's_text'        => $request->get('s_text'),
            's_sh_id'       => session('user')-> u_shop,
            's_del_flg'     => 0,
            'sale_date'     => $request->get('sale_date'),
            's_date'        => $currentTime,
            's_update'      => $currentTime
        ]);
        $sales->save();

        if($request->get('hid') == 1){
            return redirect()->back()->with('success', '売上データが追加出来ました。');
        }else{
            return redirect('sales')->with('success', '売上データが追加出来ました。');
            // return redirect($request->get('urlBack'))->with('success', '売上データが追加出来ました。');
        }        
    }

    public function getSalesEdit($id) {
        // check login
        $userLogged = Session::get('user');
        if ($userLogged == null) {
            return redirect('/login');
        }

        $sales = Sales::where('s_id', $id)->where('s_del_flg', 0) ->first();
        $list_course = Course::where('co_del_flg', 0)->where('co_sh_id', $userLogged->u_shop)->get();
        $list_customer = Customer::all();
        $list_staff = Staff::where('s_del_flg', 0)->get();
        $list_option = Option::where('op_del_flg', 0)->where('op_shop', $userLogged->u_shop)->get();
        
        $salesDate = date('yy/m/d', strtotime($sales->sale_date));

        return view('pages.sales_edit', compact('sales', 'list_course','list_customer','list_staff','list_option','salesDate'));
    }

    public function postSalesEdit(Request $request,$id) {
        $request->validate([
            's_c_id'   => 'required',
            's_co_id'    => 'required',
        ], [
            's_c_id.required'  => '入力してください。',
            's_co_id.required'   => '入力してください。',
        ]);

        $course = Course::where('co_id',$request->get('s_co_id'))
                ->where('co_del_flg', 0)                      
                ->first();

    if ($course->co_opt1 != null && $request->get('s_opts1') === null ) {
                    $customer_error = "入力してください。";
                    return redirect()->back()->withInput($request->input())->withErrors(['customer_error' => $customer_error]);                    
    }   

    if ($course->co_opt2 != null && $request->get('s_opts2') === null ) {
                                $customer_error2 = "入力してください。";
                                return redirect()->back()->withInput($request->input())->withErrors(['customer_error2' => $customer_error2]);                                
    }  

    if ($course->co_opt3 != null && $request->get('s_opts3') === null ) {
                                $customer_error3 = "入力してください。";
                                return redirect()->back()->withInput($request->input())->withErrors(['customer_error3' => $customer_error3]);                                
    } 
               
    if ($course->co_opt4 != null && $request->get('s_opts4') === null ) {
                    $customer_error4 = "入力してください。";
                    return redirect()->back()->withInput($request->input())->withErrors(['customer_error4' => $customer_error4]);                                
    }  

    if ($course->co_opt5 != null && $request->get('s_opts5') === null ) {
                    $customer_error5 = "入力してください。";
                    return redirect()->back()->withInput($request->input())->withErrors(['customer_error5' => $customer_error5]);                                
    } 

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
        if(!empty($course->Option4->op_amount)){
            $money = $money + $course->Option4->op_amount;
        }
        if(!empty($course->Option5->op_amount)){
            $money = $money + $course->Option5->op_amount;
        }

        $sales = Sales::find($id);

        $sales->s_c_id      = $request->get('s_c_id');
        $sales->s_co_id     = $request->get('s_co_id');
        $sales->s_opt1      = $course->co_opt1;
        $sales->s_opts1     = ( $course->co_opt1 === null ? null : $request->get('s_opts1'));
        $sales->s_opt2      = $course->co_opt2;
        $sales->s_opts2     = ( $course->co_opt2 === null ? null : $request->get('s_opts2'));
        $sales->s_opt3      = $course->co_opt3;
        $sales->s_opts3     = ( $course->co_opt3 === null ? null : $request->get('s_opts3'));
        $sales->s_opt4      = $course->co_opt4;
        $sales->s_opts4     = ( $course->co_opt4 === null ? null : $request->get('s_opts4'));
        $sales->s_opt5      = $course->co_opt5;
        $sales->s_opts5     = ( $course->co_opt5 === null ? null : $request->get('s_opts5'));        
        $sales->s_money     = $money;
        $sales->s_pay       = $request->get('s_pay');        
        $sales->s_text      = $request->get('s_text');        
        $sales->s_sh_id     = session('user')-> u_shop;
        $sales->s_del_flg   = 0;
        $sales->sale_date   = $request->get('sale_date');
        $sales->s_update    = Carbon::now();
        $sales->save();
         return redirect('sales')->with('success', 'データを更新出来ました。');
        // return redirect($request->get('urlBack'))->with('success', 'データを更新出来ました。');
    }

    public function getSalesDelete($id) {
        $sales = Sales::find($id);
        $sales->s_del_flg = 1;
        $sales->s_update  = Carbon::now();
        $sales->save();
        return redirect()->back()->with('success', '削除完了しました。');
    }    

    public function searchCustomerAjax(Request $request) {        
        $output = '';   

        if($request->has('query'))
        {
            $query = $request->get('query');

            if($query === "0"){
                $data = Customer::where('c_id', '<', 1000)
                    ->orWhere('c_lastname', 'LIKE', "%{$query}%")
                    ->orWhere('c_firstname', 'LIKE', "%{$query}%")
                    ->get();
               
            }else if($query === "00"){
                $data = Customer::where('c_id', '<', 100)
                    ->orWhere('c_lastname', 'LIKE', "%{$query}%")
                    ->orWhere('c_firstname', 'LIKE', "%{$query}%")
                    ->get();
            }else if($query === "000"){
                $data = Customer::where('c_id', '<', 10)
                    ->orWhere('c_lastname', 'LIKE', "%{$query}%")
                    ->orWhere('c_firstname', 'LIKE', "%{$query}%")
                    ->get();
            }else if(is_numeric($query) && (int)$query <= 9999 && strlen($query) <= 4){                    
                
                $que = (int)$query;

                if(strlen($query) == 4){
                    $data = Customer::where('c_id', '=', "{$que}")
                    ->orWhere('c_lastname', 'LIKE', "%{$query}%")
                    ->orWhere('c_firstname', 'LIKE', "%{$query}%")
                    ->get(); 
                }else{
                    $data = Customer::where('c_id', 'LIKE', "%{$que}%")
                    ->orWhere('c_lastname', 'LIKE', "%{$query}%")
                    ->orWhere('c_firstname', 'LIKE', "%{$query}%")
                    ->get(); 
                }             
            }else{
                $data = Customer::where('c_id', 'LIKE', "%{$query}%")
                ->orWhere('c_lastname', 'LIKE', "%{$query}%")
                ->orWhere('c_firstname', 'LIKE', "%{$query}%")
                ->get();  
            }         
                                               
            if($data->count() > 0){

                $output = '<ul id="listCustomerSearch" class="list-group" style="display:block; position:absolute; z-index: 10; width: 40%;max-height: 296px;overflow-y: auto;border: 1px solid rgba(0,0,0,.125);">';
            
                foreach($data as $row)
                {
                    $c_id = $row->c_id;
                    if ($c_id < 10) {
                        $c_id = '000' . $c_id;
                    } else {
                        if ($c_id >= 10 && $c_id < 100) {
                            $c_id = '00' . $c_id;
                        }
                        if ($c_id >= 100 && $c_id < 1000) {
                            $c_id = '0' . $c_id;
                        }
                    }    

                   $output .= '<li class="list-group-item list-group-item-action" style="font-size: smaller;padding: .4rem .5rem;white-space: nowrap;
                   text-overflow: ellipsis;
                   overflow: hidden;" value ='.$row->c_id.'>'. $c_id .' - '.$row->c_lastname.' '.$row->c_firstname.'</li>';
                }
                $output .= '</ul>';
            }       
                        
            echo $output;                       
       }       
    }
}