<?php

namespace App\Http\Controllers;
use App\Sales;
use App\Customer;
use App\Shop;
use App\Course;
use App\User;
use App\Staff;
use App\Option;
use App\SaleDetails;
use Carbon\Carbon;
use Session;
use PDF;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class SalesController extends Controller
{ 
    //load page with $id
    public function index(Request $req)
    {
        $userLogged = Session::get('user');
        if ($userLogged == null) {
            return redirect('/login');
        }
        $shop_user = $userLogged->u_shop;
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
            $currentTime = Carbon::now()->format('Y/m/d');
    
            $str_date = date('Y/m/d', strtotime($str_date));
            $end_date = date('Y/m/d', strtotime($end_date));
    
            $shopId = $req->shop_id;
            session(['search' => $list_sales_count]);
    
            $list_sales = Sales::where('sale_date','>=',$str_date)
            ->where('sale_date','<=',$end_date)
            ->where('s_sh_id',$req->shop_id)    
            ->where('s_del_flg', 0)
            ->orderBy('s_id', 'DESC')
            ->paginate(10);
    
            return view('pages.sales', compact('list_sales','sum_money','list_shop','list_sales_count','currentTime','str_date','end_date','shopId','shop_user'));

        }else{

            $list_sales = Sales::where('s_del_flg', 0)->orderBy('s_id', 'DESC')->paginate(10); 
            $sum_money = Sales::where('s_del_flg', 0)->sum('s_money');
            $list_shop = Shop::all();
            $list_sales_count = Sales::where('s_del_flg', 0)->count();   
            $currentTime = Carbon::now()->format('Y/m/d');
            return view('pages.sales', compact('list_sales','sum_money','list_shop','list_sales_count','currentTime', 'shop_user'));
        }        
    }

    public function getSalesNew() {
         // check login
         $userLogged = Session::get('user');
         if ($userLogged == null) {
             return redirect('/login');
         }

        $list_course = Course::where('co_del_flg', 0)->where('co_sh_id', $userLogged->u_shop)->get();
        $list_customer = Customer::where('c_sh_id', $userLogged->u_shop)->get();
        $list_staff = Staff::where('s_del_flg', 0)->get();
        $list_option = Option::where('op_del_flg', 0)->where('op_shop', $userLogged->u_shop)->get();
        $currentTime = Carbon::now()->format('Y/m/d');

        $last_sales = Sales::orderBy('s_id', 'DESC')->take(1)->first('s_id');
        if ($last_sales != null) {
            $last_sales_id = $last_sales->s_id;
        } else {
            $last_sales_id = 0;
        }  

        return view('pages.sales_new',compact('list_course','last_sales_id','list_customer','list_staff','list_option','currentTime'));
    }   

    public function postSalesNew(Request $request) {

        $arrFieldValidate = array('s_c_id' => 'required', 's_co_id1' => 'required', 's_money_1' => 'required');
        $arrMessageValidate = array('s_c_id.required' => '入力してください。', 's_co_id1.required' => '入力してください。', 's_money_1.required' => '入力してください。');
        if ($request->get('hd-block') != '') {

            if ($request->get('hd-block') > 1){
                $arrFieldValidate['s_co_id2'] = 'required';
                $arrFieldValidate['s_money_2'] = 'required';
                $arrMessageValidate['s_co_id2.required'] = '入力してください';
                $arrMessageValidate['s_money_2.required'] = '入力してください';
            }
            if ($request->get('hd-block') > 2){
                $arrFieldValidate['s_co_id3'] = 'required';
                $arrFieldValidate['s_money_3'] = 'required';
                $arrMessageValidate['s_co_id3.required'] = '入力してください';
                $arrMessageValidate['s_money_3.required'] = '入力してください';
            }
            if ($request->get('hd-block') > 3){
                $arrFieldValidate['s_co_id4'] = 'required';
                $arrFieldValidate['s_money_4'] = 'required';
                $arrMessageValidate['s_co_id4.required'] = '入力してください';
                $arrMessageValidate['s_money_4.required'] = '入力してください';
            }
            if ($request->get('hd-block') > 4){
                $arrFieldValidate['s_co_id5'] = 'required';
                $arrFieldValidate['s_money_5'] = 'required';
                $arrMessageValidate['s_co_id5.required'] = '入力してください';
                $arrMessageValidate['s_money_5.required'] = '入力してください';
            }
        }

        $request->validate($arrFieldValidate, $arrMessageValidate);

        // get current time
        $currentTime = date('Y-m-d H:i:s');
        $dataSales = [
            's_c_id'        => $request->get('s_c_id'),
            's_money'       => str_replace(",", "", $request->get('s_total_money')),
            's_saleoff_flg' => ($request->has('s_saleoff_flg')) ? 1 : 0,
            's_pay'         => $request->get('s_pay'),
            's_text'        => $request->get('s_text'),
            's_sh_id'       => session('user')-> u_shop,
            's_del_flg'     => 0,
            'sale_date'     => $request->get('sale_date'),
            's_date'        => $currentTime,
            's_update'      => $currentTime
        ];

        $dataSaleDetail = array();

        for ($i = 1; $i<=5;$i++){
            // if s_co_id = 0 then it is フリー course
            if ($request->get('s_co_id'.$i) != '') {
                $dataSaleDetail[$i-1]['s_co_num'] = $i;
                if ($request->get('s_co_id'.$i) == 0) {
                    if ($request->get('s_opts1_'.$i) === null ) {
                        $customer_error = "入力してください。";
                        return redirect()->back()->withInput($request->input())->withErrors(['customer_error1_'.$i => $customer_error]);
                    }

                    $dataSaleDetail[$i-1]['s_co_id'] = 0;
                    $dataSaleDetail[$i-1]['s_opt1'] = 0;
                    $dataSaleDetail[$i-1]['s_opts1'] = $request->get('s_opts1_'.$i);
                    $dataSaleDetail[$i-1]['s_money'] = str_replace(",", "", $request->get('s_money_'.$i));
                }
                // if s_co_id = 9999 then it is 商品販売 course
                else if ($request->get('s_co_id'.$i) == 9999) {
                    if ($request->get('s_opts1_'.$i) === null ) {
                        $customer_error = "入力してください。";
                        return redirect()->back()->withInput($request->input())->withErrors(['customer_error1_'.$i => $customer_error]);
                    }
                    $dataSaleDetail[$i-1]['s_co_id'] = 9999;
                    $dataSaleDetail[$i-1]['s_opt1'] = 9999;
                    $dataSaleDetail[$i-1]['s_opts1'] = $request->get('s_opts1_'.$i);
                    $dataSaleDetail[$i-1]['s_money'] = str_replace(",", "", $request->get('s_money_'.$i));
                }
                else{
                    // s_co_id != 0 ,  s_co_id != 9999
                    $course = Course::where('co_id',$request->get('s_co_id'.$i))
                        ->where('co_del_flg', 0)
                        ->first();

                    if ($course->co_opt1 != null && $request->get('s_opts1_'.$i) === null ) {
                        $customer_error = "入力してください。";
                        return redirect()->back()->withInput($request->input())->withErrors(['customer_error1_'.$i => $customer_error]);
                    }

                    if ($course->co_opt2 != null && $request->get('s_opts2_'.$i) === null ) {
                        $customer_error2 = "入力してください。";
                        return redirect()->back()->withInput($request->input())->withErrors(['customer_error2_'.$i => $customer_error2]);
                    }

                    if ($course->co_opt3 != null && $request->get('s_opts3_'.$i) === null ) {
                        $customer_error3 = "入力してください。";
                        return redirect()->back()->withInput($request->input())->withErrors(['customer_error3_'.$i => $customer_error3]);
                    }

                    if ($course->co_opt4 != null && $request->get('s_opts4_'.$i) === null ) {
                        $customer_error4 = "入力してください。";
                        return redirect()->back()->withInput($request->input())->withErrors(['customer_error4_'.$i => $customer_error4]);
                    }

                    if ($course->co_opt5 != null && $request->get('s_opts5_'.$i) === null ) {
                        $customer_error5 = "入力してください。";
                        return redirect()->back()->withInput($request->input())->withErrors(['customer_error5_'.$i => $customer_error5]);
                    }

                    $dataSaleDetail[$i-1]['s_co_id'] = $request->get('s_co_id'.$i);
                    $dataSaleDetail[$i-1]['s_opt1'] = $course->co_opt1;
                    $dataSaleDetail[$i-1]['s_opts1'] = $course->co_opt1 === null ? null : $request->get('s_opts1_'.$i);
                    $dataSaleDetail[$i-1]['s_opt2'] = $course->co_opt2;
                    $dataSaleDetail[$i-1]['s_opts2'] = $course->co_opt2 === null ? null : $request->get('s_opts2_'.$i);
                    $dataSaleDetail[$i-1]['s_opt3'] = $course->co_opt3;
                    $dataSaleDetail[$i-1]['s_opts3'] = $course->co_opt3 === null ? null : $request->get('s_opts3_'.$i);
                    $dataSaleDetail[$i-1]['s_opt4'] = $course->co_opt4;
                    $dataSaleDetail[$i-1]['s_opts4'] = $course->co_opt4 === null ? null : $request->get('s_opts4_'.$i);
                    $dataSaleDetail[$i-1]['s_opt5'] = $course->co_opt5;
                    $dataSaleDetail[$i-1]['s_opts5'] = $course->co_opt5 === null ? null : $request->get('s_opts5_'.$i);
                    $dataSaleDetail[$i-1]['s_money'] = str_replace(",", "", $request->get('s_money_'.$i));
                }
            }
        }

        $sales = new Sales($dataSales);
        $sales->save();

        $idSale = $sales->s_id;

        foreach ($dataSaleDetail as $value){
            $value['s_id'] = $idSale;
            $value['s_date'] = $currentTime;
            $value['s_update'] = $currentTime;
            $saledetails = new SaleDetails($value);
            $saledetails->save();
        }

        if($request->get('hid') == 1){
            return redirect()->back()->with('success', '売上データが追加出来ました。');
        }else{
            return redirect('sales')->with('success', '売上データが追加出来ました。');
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
        $list_customer = Customer::where('c_sh_id', $userLogged->u_shop)->get();
        $list_staff = Staff::where('s_del_flg', 0)->get();
        $list_option = Option::where('op_del_flg', 0)->where('op_shop', $userLogged->u_shop)->get();
        $salesDate = date('Y/m/d', strtotime($sales->sale_date));
        $sale_details = SaleDetails::where('s_id', $id)->orderBy('s_co_num', 'ASC')->get();
        $total_detail = count($sale_details);

        return view('pages.sales_edit', compact('sales', 'list_course','list_customer','list_staff','list_option','salesDate','sale_details','total_detail'));
    }

    public function postSalesEdit(Request $request,$id) {

        $arrFieldValidate = array('s_c_id' => 'required', 's_co_id1' => 'required', 's_money_1' => 'required');
        $arrMessageValidate = array('s_c_id.required' => '入力してください。', 's_co_id1.required' => '入力してください。', 's_money_1.required' => '入力してください。');
        if ($request->get('hd-block') != '') {

            if ($request->get('hd-block') > 1){
                $arrFieldValidate['s_co_id2'] = 'required';
                $arrFieldValidate['s_money_2'] = 'required';
                $arrMessageValidate['s_co_id2.required'] = '入力してください';
                $arrMessageValidate['s_money_2.required'] = '入力してください';
            }
            if ($request->get('hd-block') > 2){
                $arrFieldValidate['s_co_id3'] = 'required';
                $arrFieldValidate['s_money_3'] = 'required';
                $arrMessageValidate['s_co_id3.required'] = '入力してください';
                $arrMessageValidate['s_money_3.required'] = '入力してください';
            }
            if ($request->get('hd-block') > 3){
                $arrFieldValidate['s_co_id4'] = 'required';
                $arrFieldValidate['s_money_4'] = 'required';
                $arrMessageValidate['s_co_id4.required'] = '入力してください';
                $arrMessageValidate['s_money_4.required'] = '入力してください';
            }
            if ($request->get('hd-block') > 4){
                $arrFieldValidate['s_co_id5'] = 'required';
                $arrFieldValidate['s_money_5'] = 'required';
                $arrMessageValidate['s_co_id5.required'] = '入力してください';
                $arrMessageValidate['s_money_5.required'] = '入力してください';
            }
        }

        $request->validate($arrFieldValidate, $arrMessageValidate);

        // get current time
        $currentTime = date('Y-m-d H:i:s');
        $dataSales = [
            's_c_id'        => $request->get('s_c_id'),
            's_money'       => str_replace(",", "", $request->get('s_total_money')),
            's_saleoff_flg' => ($request->has('s_saleoff_flg')) ? 1 : 0,
            's_pay'         => $request->get('s_pay'),
            's_text'        => $request->get('s_text'),
            's_sh_id'       => session('user')-> u_shop,
            's_del_flg'     => 0,
            'sale_date'     => $request->get('sale_date'),
            's_date'        => $currentTime,
            's_update'      => $currentTime
        ];

        $dataSaleDetail = array();

        for ($i = 1; $i<=5;$i++){
            // if s_co_id = 0 then it is フリー course
            if ($request->get('s_co_id'.$i) != '') {
                $dataSaleDetail[$i-1]['s_co_num'] = $i;
                if ($request->get('s_co_id'.$i) == 0) {
                    if ($request->get('s_opts1_'.$i) === null ) {
                        $customer_error = "入力してください。";
                        return redirect()->back()->withInput($request->input())->withErrors(['customer_error1_'.$i => $customer_error]);
                    }
                    $dataSaleDetail[$i-1]['s_co_id'] = 0;
                    $dataSaleDetail[$i-1]['s_opt1'] = 0;
                    $dataSaleDetail[$i-1]['s_opts1'] = $request->get('s_opts1_'.$i);
                    $dataSaleDetail[$i-1]['s_money'] = str_replace(",", "", $request->get('s_money_'.$i));
                }
                // if s_co_id = 9999 then it is 商品販売 course
                else if ($request->get('s_co_id'.$i) == 9999) {
                    if ($request->get('s_opts1_'.$i) === null ) {
                        $customer_error = "入力してください。";
                        return redirect()->back()->withInput($request->input())->withErrors(['customer_error1_'.$i => $customer_error]);
                    }
                    $dataSaleDetail[$i-1]['s_co_id'] = 9999;
                    $dataSaleDetail[$i-1]['s_opt1'] = 9999;
                    $dataSaleDetail[$i-1]['s_opts1'] = $request->get('s_opts1_'.$i);
                    $dataSaleDetail[$i-1]['s_money'] = str_replace(",", "", $request->get('s_money_'.$i));
                }
                else{
                    // s_co_id != 0 ,  s_co_id != 9999
                    $course = Course::where('co_id',$request->get('s_co_id'.$i))
                        ->where('co_del_flg', 0)
                        ->first();

                    if ($course->co_opt1 != null && $request->get('s_opts1_'.$i) === null ) {
                        $customer_error = "入力してください。";
                        return redirect()->back()->withInput($request->input())->withErrors(['customer_error1_'.$i => $customer_error]);
                    }

                    if ($course->co_opt2 != null && $request->get('s_opts2_'.$i) === null ) {
                        $customer_error2 = "入力してください。";
                        return redirect()->back()->withInput($request->input())->withErrors(['customer_error2_'.$i => $customer_error2]);
                    }

                    if ($course->co_opt3 != null && $request->get('s_opts3_'.$i) === null ) {
                        $customer_error3 = "入力してください。";
                        return redirect()->back()->withInput($request->input())->withErrors(['customer_error3_'.$i => $customer_error3]);
                    }

                    if ($course->co_opt4 != null && $request->get('s_opts4_'.$i) === null ) {
                        $customer_error4 = "入力してください。";
                        return redirect()->back()->withInput($request->input())->withErrors(['customer_error4_'.$i => $customer_error4]);
                    }

                    if ($course->co_opt5 != null && $request->get('s_opts5_'.$i) === null ) {
                        $customer_error5 = "入力してください。";
                        return redirect()->back()->withInput($request->input())->withErrors(['customer_error5_'.$i => $customer_error5]);
                    }
                    $dataSaleDetail[$i-1]['s_co_id'] = $request->get('s_co_id'.$i);
                    $dataSaleDetail[$i-1]['s_opt1'] = $course->co_opt1;
                    $dataSaleDetail[$i-1]['s_opts1'] = $course->co_opt1 === null ? null : $request->get('s_opts1_'.$i);
                    $dataSaleDetail[$i-1]['s_opt2'] = $course->co_opt2;
                    $dataSaleDetail[$i-1]['s_opts2'] = $course->co_opt2 === null ? null : $request->get('s_opts2_'.$i);
                    $dataSaleDetail[$i-1]['s_opt3'] = $course->co_opt3;
                    $dataSaleDetail[$i-1]['s_opts3'] = $course->co_opt3 === null ? null : $request->get('s_opts3_'.$i);
                    $dataSaleDetail[$i-1]['s_opt4'] = $course->co_opt4;
                    $dataSaleDetail[$i-1]['s_opts4'] = $course->co_opt4 === null ? null : $request->get('s_opts4_'.$i);
                    $dataSaleDetail[$i-1]['s_opt5'] = $course->co_opt5;
                    $dataSaleDetail[$i-1]['s_opts5'] = $course->co_opt5 === null ? null : $request->get('s_opts5_'.$i);
                    $dataSaleDetail[$i-1]['s_money'] = str_replace(",", "", $request->get('s_money_'.$i));
                }
            }
        }


        $sales = Sales::find($id);

        $sales->s_c_id  = $dataSales['s_c_id'];
        $sales->s_money  = $dataSales['s_money'];
        $sales->s_pay  = $dataSales['s_pay'];
        $sales->s_text  = $dataSales['s_text'];
        $sales->s_sh_id  = $dataSales['s_sh_id'];
        $sales->s_saleoff_flg  = $dataSales['s_saleoff_flg'];
        $sales->sale_date  = $dataSales['sale_date'];
        $sales->s_update  = $dataSales['s_update'];

        $sales->save();


        SaleDetails::where('s_id', $id)->delete();

        foreach ($dataSaleDetail as $value){
            $value['s_id'] = $id;
            $value['s_date'] = $currentTime;
            $value['s_update'] = $currentTime;
            $newsaledetails = new SaleDetails($value);
            $newsaledetails->save();

        }
        return redirect('sales')->with('success', 'データを更新出来ました。');
    }

    public function getSalesDelete($id) {
        $sales = Sales::find($id);
        $sales->s_del_flg = 1;
        $sales->s_update  = Carbon::now();
        $sales->save();
        return redirect()->back()->with('success', '削除完了しました。');
    }    

    public function searchCustomerAjax(Request $request) {        
        $userLogged = Session::get('user');
        
        $output = '';   

        if($request->has('query'))
        {
            $query = trim($request->get('query'), "");


            if($query === "0"){
                $data = Customer::where(function($querySql) use ($query, $userLogged)
                    {
                        $querySql->where("c_lastname",'LIKE', "%{$query}%")
                            ->where("c_sh_id",$userLogged->u_shop);
                    })
                    ->orWhere(function($querySql)  use ($query, $userLogged)
                    {
                        $querySql->Where("c_firstname", 'LIKE', "%{$query}%")
                            ->where("c_sh_id",$userLogged->u_shop);
                    })
                    ->orWhere(function($querySql)  use ($userLogged)
                    {
                        $querySql->Where("c_id", '<', 1000)
                            ->where("c_sh_id",$userLogged->u_shop);
                    })
                    ->get();
               
            }else if($query === "00"){
                $data = Customer::where(function($querySql) use ($query, $userLogged)
                    {
                        $querySql->where("c_lastname",'LIKE', "%{$query}%")
                            ->where("c_sh_id",$userLogged->u_shop);
                    })
                    ->orWhere(function($querySql)  use ($query, $userLogged)
                    {
                        $querySql->Where("c_firstname", 'LIKE', "%{$query}%")
                            ->where("c_sh_id",$userLogged->u_shop);
                    })
                    ->orWhere(function($querySql)  use ($userLogged)
                    {
                        $querySql->Where("c_id", '<', 100)
                            ->where("c_sh_id",$userLogged->u_shop);
                    })
                    ->get();
            }else if($query === "000"){
                $data = Customer::where(function($querySql) use ($query, $userLogged)
                    {
                        $querySql->where("c_lastname",'LIKE', "%{$query}%")
                            ->where("c_sh_id",$userLogged->u_shop);
                    })
                    ->orWhere(function($querySql)  use ($query, $userLogged)
                    {
                        $querySql->Where("c_firstname", 'LIKE', "%{$query}%")
                            ->where("c_sh_id",$userLogged->u_shop);
                    })
                    ->orWhere(function($querySql)  use ($userLogged)
                    {
                        $querySql->Where("c_id", '<', 10)
                            ->where("c_sh_id",$userLogged->u_shop);
                    })
                    ->get();
            }else if(is_numeric($query) && (int)$query <= 9999 && strlen($query) <= 4){                    
                
                $que = (int)$query;

                if(strlen($query) == 4){
                    $data = Customer::where(function($querySql) use ($query, $userLogged)
                        {
                            $querySql->where("c_lastname",'LIKE', "%{$query}%")
                                ->where("c_sh_id",$userLogged->u_shop);
                        })
                        ->orWhere(function($querySql)  use ($query, $userLogged)
                        {
                            $querySql->Where("c_firstname", 'LIKE', "%{$query}%")
                                ->where("c_sh_id",$userLogged->u_shop);
                        })
                        ->orWhere(function($querySql)  use ($que ,$userLogged)
                        {
                            $querySql->Where("c_id", '=', "{$que}")
                                ->where("c_sh_id",$userLogged->u_shop);
                        })
                        ->get();
                }else{

                    $data = Customer::where(function($querySql) use ($query, $userLogged)
                        {
                            $querySql->where("c_lastname",'LIKE', "%{$query}%")
                                ->where("c_sh_id",$userLogged->u_shop);
                        })
                        ->orWhere(function($querySql)  use ($query, $userLogged)
                        {
                            $querySql->Where("c_firstname", 'LIKE', "%{$query}%")
                                ->where("c_sh_id",$userLogged->u_shop);
                        })
                        ->orWhere(function($querySql)  use ($que ,$userLogged)
                        {
                            $querySql->Where("c_id", 'LIKE', "%{$que}%")
                                ->where("c_sh_id",$userLogged->u_shop);
                        })
                        ->get();
                }             
            }else if($query !== ""){
                $data = Customer::where(function($querySql) use ($query, $userLogged)
                    {
                        $querySql->where("c_lastname",'LIKE', "%{$query}%")
                            ->where("c_sh_id",$userLogged->u_shop);
                    })
                    ->orWhere(function($querySql)  use ($query, $userLogged)
                    {
                        $querySql->Where("c_firstname", 'LIKE', "%{$query}%")
                            ->where("c_sh_id",$userLogged->u_shop);
                    })
                    ->get();
            } else {
                $data = Customer::where('c_sh_id', $userLogged->u_shop)->get();
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

    public function exportExcel(Request $req)
    {
        $day_in_month = 1;
        if(!empty($req->str_date)&&!empty($req->end_date)&&!empty($req->shop_id)){
            $export_date = str_replace('/','-',$req->str_date);
            $str_date = str_replace('/','-',$req->str_date) . ' 00:00:00';
            $end_date = str_replace('/','-',$req->end_date) . ' 23:59:59';

            $datetime1 = date_create($str_date);
            $datetime2 = date_create($end_date);
            $interval = date_diff($datetime1, $datetime2);
            $day_in_month =  $interval->format('%a') + 1;

            $list_sales = Sales::where('sale_date','>=',$str_date)
                ->where('sale_date','<=',$end_date)
                ->where('s_sh_id',$req->shop_id)
                ->orderBy('s_id', 'DESC')
                ->where('s_del_flg', 0)->get()->toArray();
            $list_shop = Shop::where('sh_id', '=', $req->shop_id)->get()->toArray();
            $shop_name = $list_shop[0]['sh_name'];
            
            $list_sales_2 = Sales::where('sale_date','>=',$str_date)
                ->where('sale_date','<=',$end_date)
                ->where('s_sh_id',$req->shop_id)
                ->where('s_c_id', 430)
                ->orderBy('s_id', 'DESC')
                ->where('s_del_flg', 0)->get()->toArray();

        }else{
            $export_date = date('Y-m-d');
            $list_sales = Sales::where('s_del_flg', 0)->orderBy('s_id', 'DESC')->get()->toArray();
            $list_sales_2 = array();
            $shop_name = '全部';
        }
        // process data
        $list_staff_data = array();
        $list_option_id = array();
        $sum_money = 0; //B6
        $list_sale_id = array();
        foreach ($list_sales as $sale){
            $sum_money += $sale['s_money'];
            $list_sale_id[] = $sale['s_id'];
        }

        $list_sale_details = SaleDetails::whereIn('s_id',$list_sale_id)->orderBy('s_id', 'ASC')->get()->toArray();
        foreach ($list_sale_details as $sale){
            $s_opts1 = $sale['s_opts1'];
            $s_opts2 = $sale['s_opts2'];
            $s_opts3 = $sale['s_opts3'];
            $s_opts4 = $sale['s_opts4'];
            $s_opts5 = $sale['s_opts5'];

            if (!empty($s_opts1) && !in_array($s_opts1, $list_staff_data)){
                $list_staff_data[$s_opts1]['id'] = $s_opts1;
            }
            if (!empty($s_opts2) && !in_array($s_opts2, $list_staff_data)){
                $list_staff_data[$s_opts2]['id'] = $s_opts2;
            }
            if (!empty($s_opts3) && !in_array($s_opts3, $list_staff_data)){
                $list_staff_data[$s_opts3]['id'] = $s_opts3;
            }
            if (!empty($s_opts4) && !in_array($s_opts4, $list_staff_data)){
                $list_staff_data[$s_opts4]['id'] = $s_opts4;
            }
            if (!empty($s_opts5) && !in_array($s_opts5, $list_staff_data)){
                $list_staff_data[$s_opts5]['id'] = $s_opts5;
            }

            $s_opt1 = $sale['s_opt1'];
            $s_opt2 = $sale['s_opt2'];
            $s_opt3 = $sale['s_opt3'];
            $s_opt4 = $sale['s_opt4'];
            $s_opt5 = $sale['s_opt5'];
            $s_money = $sale['s_money'];

            if ($s_opt1 == 0 || $s_opt1 == 9999 || !empty($s_opt1)){
                if ($s_opt1 == 0 && $s_money >= 0){
                    $s_opt1 = 99999;
                }
                if ($s_opt1 == 0 && $s_money < 0){
                    $s_opt1 = 99998;
                }
                $list_staff_data[$s_opts1]['co_id'][] = $s_opt1;
                if ($s_opt1 == 9999 || $s_opt1 == 99999 ||  $s_opt1 == 99998 ){
                    if (empty($list_staff_data[$s_opts1]['amount'][$s_opt1])){
                      $list_staff_data[$s_opts1]['amount'][$s_opt1] = $s_money;
                    }
                    else{
                      $list_staff_data[$s_opts1]['amount'][$s_opt1] += $s_money;  
                    }
                    
                }
                if (!in_array($s_opt1, $list_option_id)){
                    $list_option_id[] = $s_opt1;
                }
            }
            if (!empty($s_opt2)){
                $list_staff_data[$s_opts2]['co_id'][] = $s_opt2;
                if (!in_array($s_opt2, $list_option_id)){
                    $list_option_id[] = $s_opt2;
                }
            }
            if (!empty($s_opt3)){
                $list_staff_data[$s_opts3]['co_id'][] = $s_opt3;
                if (!in_array($s_opt3, $list_option_id)){
                    $list_option_id[] = $s_opt3;
                }
            }
            if (!empty($s_opt4)){
                $list_staff_data[$s_opts4]['co_id'][] = $s_opt4;
                if (!in_array($s_opt4, $list_option_id)){
                    $list_option_id[] = $s_opt4;
                }
            }
            if (!empty($s_opt5)){
                $list_staff_data[$s_opts5]['co_id'][] = $s_opt5;
                if (!in_array($s_opt5, $list_option_id)){
                    $list_option_id[] = $s_opt5;
                }
            }
        }

        $list_staff_id = array_keys($list_staff_data);
        sort($list_staff_id);
        sort($list_option_id);

        foreach ($list_staff_data as $key => $value){
            $list_co_id = $list_staff_data[$key]['co_id'];
            $list_co_id = array_filter($list_co_id);
            $list_co_id = array_count_values($list_co_id);
            $list_staff_data[$key]['co_id'] = $list_co_id;
        }

        // get data from database
        $list_options = Option::whereIn('op_id',$list_option_id)->orderBy('op_id', 'ASC')->get()->toArray();
        $list_staff = Staff::whereIn('s_id',$list_staff_id)->orderBy('s_id', 'ASC')->get()->toArray();

        if (in_array(99999, $list_option_id)){
            $list_options[] = array('op_id' => 99999, 'op_name' => 'フリー', 'op_amount' => 1);
        }
        if (in_array(99998, $list_option_id)){
            $list_options[] = array('op_id' => 99998, 'op_name' => 'フリー(値引分)', 'op_amount' => 1);
        }
        if (in_array(9999, $list_option_id)){
            $list_options[] = array('op_id' => 9999, 'op_name' => '商品販売', 'op_amount' => 1);
        }
        $list_sales_count_2 = count($list_sales_2); //B9
        $list_sales_count = count($list_sales) - $list_sales_count_2; //B6
        $avg_person = ceil($list_sales_count/$day_in_month) ; //B7 = B6 / $day_in_month
        $total_staff = count($list_staff_id); //B8
        // export excel
        $font_family = 'Arial';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->getColumnDimension('A')->setWidth('18');
        $sheet->getColumnDimension('B')->setWidth('15');
        $sheet->getColumnDimension('E')->setWidth('5');
        $sheet->getColumnDimension('F')->setWidth('22');
        $sheet->getColumnDimension('G')->setWidth('22');
        $sheet->getColumnDimension('H')->setWidth('22');
        $sheet->getColumnDimension('I')->setWidth('18');
        $sheet->getColumnDimension('J')->setWidth('18');
        $sheet->getColumnDimension('K')->setWidth('18');

        //A1
        $sheet->setCellValue('A1', '店名');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('right');
        $sheet->getStyle("A1")->getFont()->setName($font_family)->setSize(10);

        $styleArray1 = array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('argb' => '000000'),

        );

        $styleArray2 = array(
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => array('argb' => 'D9D9D9'),

        );

        $sheet->getStyle('A1')->getBorders()->getAllBorders()->applyFromArray($styleArray1);

        //B1
        $sheet->mergeCells("B1:D1");
        $sheet->setCellValue('B1', $shop_name);
        $sheet->getStyle('B1')->getAlignment()->setHorizontal('center');
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                ),
            ),
            'font'  => array(
                'size'  => 14,
                'name'  => $font_family
            )
        );

        $sheet->getStyle('B1:D1')->getBorders()->getAllBorders()->applyFromArray($styleArray1);
        $sheet->getStyle('B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');

        //A3
        $sheet->setCellValue('A3', '入力欄');
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('left');
        $sheet->getStyle("A3")->getFont()->setName($font_family)->setSize(16);


        // A5: B9
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                ),
            ),
            'font'  => array(
                'size'  => 11,
                'name'  => $font_family
            )
        );
        $sheet->getStyle('A5')->applyFromArray($styleArray);
        $sheet->getStyle('A6')->applyFromArray($styleArray);
        $sheet->getStyle('A7')->applyFromArray($styleArray);
        $sheet->getStyle('A8')->applyFromArray($styleArray);
        $sheet->getStyle('A9')->applyFromArray($styleArray);

        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                ),
            ),
            'font'  => array(
                'size'  => 12,
                'name'  => $font_family
            )
        );

        $sheet->getStyle('A4')->getBorders()->getAllBorders()->applyFromArray($styleArray2);
        $sheet->getStyle('A4')->getBorders()->getBottom()->applyFromArray($styleArray1);
        $sheet->getStyle('B4')->getBorders()->getAllBorders()->applyFromArray($styleArray2);
        $sheet->getStyle('B4')->getBorders()->getBottom()->applyFromArray($styleArray1);
        $sheet->getStyle('B5')->getBorders()->getAllBorders()->applyFromArray($styleArray1);
        $sheet->getStyle('B6')->applyFromArray($styleArray);
        $sheet->getStyle('B7')->applyFromArray($styleArray);
        $sheet->getStyle('B8')->applyFromArray($styleArray);
        $sheet->getStyle('B9')->applyFromArray($styleArray);

        $sheet->setCellValue('A5', '当月売上');
        $sheet->setCellValue('A6', '当月総客数');
        $sheet->setCellValue('A7', 'のべ人数');
        $sheet->setCellValue('A8', 'スタッフ数');
         $sheet->setCellValue('A9', '物品購入');

        $sheet->getStyle('B5')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('B6')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('B7')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('B8')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('B5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');
        $sheet->getStyle('B6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');
        $sheet->getStyle('B7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');
        $sheet->getStyle('B8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');
        $sheet->getStyle('B9')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');

        $sheet->setCellValue('B5', number_format($sum_money));
        $sheet->setCellValue('B6', number_format($list_sales_count));
        $sheet->setCellValue('B7', number_format($avg_person));
        $sheet->setCellValue('B8', number_format($total_staff));
        $sheet->setCellValue('B9', number_format($list_sales_count_2));


        //A19 : C22
        $sheet->setCellValue('A19', '■連絡事項（何かあればご記入ください）');
        $sheet->getStyle('A19')->getAlignment()->setHorizontal('left');
        $sheet->getStyle("A19")->getFont()->setName($font_family)->setSize(10);

        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                ),
            ),
            'font'  => array(
                'size'  => 10,
                'name'  => $font_family
            )
        );
        $sheet->getStyle('A19:C19')->getBorders()->getAllBorders()->applyFromArray($styleArray2);
        $sheet->getStyle('A19:C19')->getBorders()->getBottom()->applyFromArray($styleArray1);
        $sheet->mergeCells("A20:C22");
        $sheet->getStyle('A20')->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('A20')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');
        $sheet->getStyle('A20:C22')->applyFromArray($styleArray);


        //F1 : I1
        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('arg' => '000000'),
                ),
            )
        );


        $sheet->getStyle('E1')->getBorders()->getAllBorders()->applyFromArray($styleArray2);
        $sheet->getStyle('E1')->getBorders()->getRight()->applyFromArray($styleArray1);
        $sheet->getStyle('F1')->getBorders()->getAllBorders()->applyFromArray($styleArray1);
        $sheet->getStyle('G1')->getBorders()->getAllBorders()->applyFromArray($styleArray1);
        $sheet->getStyle('H1')->getBorders()->getAllBorders()->applyFromArray($styleArray1);

        $sheet->getStyle('F1:I1')->applyFromArray($styleArray);

        $arr_date = explode('-', $export_date);
        $sheet->setCellValue('F1', $arr_date[0]);
        $sheet->getStyle('F1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle("F1")->getFont()->setName($font_family)->setSize(18);
        $sheet->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');

        $sheet->setCellValue('G1', '年');
        $sheet->getStyle('G1')->getAlignment()->setHorizontal('left');
        $sheet->getStyle("G1")->getFont()->setName($font_family)->setSize(10);

        $sheet->setCellValue('H1', (int)$arr_date[1]);
        $sheet->getStyle('H1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle("H1")->getFont()->setName($font_family)->setSize(18);
        $sheet->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');

        $sheet->setCellValue('I1', '月');
        $sheet->getStyle('I1')->getAlignment()->setHorizontal('left');
        $sheet->getStyle("I1")->getFont()->setName($font_family)->setSize(10);

        //F3
        $sheet->setCellValue('F3', '実績');
        $sheet->getStyle('F3')->getAlignment()->setHorizontal('left');
        $sheet->getStyle("F3")->getFont()->setName($font_family)->setSize(16);

        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                ),
            ),
            'font'  => array(
                'size'  => 10,
                'name'  => $font_family
            )
        );

        $sheet->getStyle('E4:E5')->getBorders()->getAllBorders()->applyFromArray($styleArray2);
        $sheet->getStyle('E4:E5')->getBorders()->getRight()->applyFromArray($styleArray1);
        $sheet->getStyle('F3:K3')->getBorders()->getAllBorders()->applyFromArray($styleArray2);
        $sheet->getStyle('F3:K3')->getBorders()->getBottom()->applyFromArray($styleArray1);

        //F4
        $sheet->setCellValue('F4', '当月売上');
        $sheet->getStyle('F4')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('F4')->applyFromArray($styleArray);

        //G4
        $sheet->setCellValue('G4', '客単価');
        $sheet->getStyle('G4')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('G4')->applyFromArray($styleArray);

        //H4
        $sheet->mergeCells("H4:I4");
        $sheet->setCellValue('H4', '1日1人あたり売上(当月)');
        $sheet->getStyle('H4')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('H4')->applyFromArray($styleArray);
        $sheet->getStyle('I4')->applyFromArray($styleArray);

        //J4
        $sheet->mergeCells("J4:K4");
        $sheet->setCellValue('J4', '1ヵ月1人あたり売上');
        $sheet->getStyle('J4')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('J4')->applyFromArray($styleArray);
        $sheet->getStyle('K4')->applyFromArray($styleArray);


        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                ),
            ),
            'font'  => array(
                'size'  => 12,
                'name'  => $font_family
            )
        );

        //F5
        $sheet->setCellValue('F5', number_format($sum_money));
        $sheet->getStyle('F5')->getAlignment()->setHorizontal('center');
        $sheet->getStyle("F5")->getFont()->setBold(true);
        $sheet->getStyle('F5')->applyFromArray($styleArray);

        //G5
        $sheet->setCellValue('G5', number_format(floor($sum_money/$list_sales_count)));
        $sheet->getStyle('G5')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('G5')->applyFromArray($styleArray);


        //H5
        $sheet->mergeCells("H5:I5");
        $sheet->setCellValue('H5', number_format($sum_money/$avg_person,2));
        $sheet->getStyle('H5')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('H5')->applyFromArray($styleArray);
        $sheet->getStyle('I5')->applyFromArray($styleArray);

        //H5
        $sheet->mergeCells("J5:K5");
        $sheet->setCellValue('J5', number_format(floor($sum_money/$total_staff)));
        $sheet->getStyle('J5')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('J5')->applyFromArray($styleArray);
        $sheet->getStyle('K5')->applyFromArray($styleArray);

        //F9
        $sheet->setCellValue('F9', '■個人実績');
        $sheet->getStyle('F9')->getAlignment()->setHorizontal('left');
        $sheet->getStyle("F9")->getFont()->setName($font_family)->setSize(10);


        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                ),
            ),
            'font'  => array(
                'size'  => 10,
                'name'  => $font_family
            )
        );

        $sheet->mergeCells("E10:E11");
        $sheet->setCellValue('E10', 'No.');
        $sheet->getStyle('E10')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('E10')->getAlignment()->setVertical('center');
        $sheet->getStyle('E10')->applyFromArray($styleArray);
        $sheet->getStyle('E11')->applyFromArray($styleArray);

        //F10
        $sheet->mergeCells("F10:F11");
        $sheet->setCellValue('F10', '氏名');
        $sheet->getStyle('F10')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('F10')->getAlignment()->setVertical('center');
        $sheet->getStyle('F10')->applyFromArray($styleArray);
        $sheet->getStyle('F11')->applyFromArray($styleArray);

        //G10
        $sheet->mergeCells("G10:G11");
        $sheet->setCellValue('G10', '氏名カナ');
        $sheet->getStyle('G10')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('G10')->getAlignment()->setVertical('center');
        $sheet->getStyle('G10')->applyFromArray($styleArray);
        $sheet->getStyle('G11')->applyFromArray($styleArray);

        //H10
        $sheet->mergeCells("H10:H11");
        $sheet->setCellValue('H10', '実績売上');
        $sheet->getStyle('H10')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('H10')->getAlignment()->setVertical('center');
        $sheet->getStyle('H10')->applyFromArray($styleArray);
        $sheet->getStyle('H11')->applyFromArray($styleArray);

        $column = 10;
        $column11 = 11;
        $col = 'I';
        foreach($list_options as $option){
            $sheet->getColumnDimension($col)->setWidth(36);
            $a = $col;
            $a++;
            $sheet->mergeCells($col."10:".$a."10");
            $sheet->setCellValue($col.$column, $option['op_name']);
            $sheet->getStyle($col.$column)->getAlignment()->setHorizontal('center');
            $sheet->getStyle($col.$column)->applyFromArray($styleArray);
          
            $sheet->setCellValue($col.$column11, "件数");
            $sheet->getColumnDimension($col)->setWidth(18);
            $sheet->getStyle($col.$column11)->getAlignment()->setHorizontal('center');
            $sheet->getStyle($col.$column11)->applyFromArray($styleArray);
            $sheet->getStyle($col.$column)->applyFromArray($styleArray);

            $col++;

            $sheet->setCellValue($col.$column11, "売上");
            $sheet->getColumnDimension($col)->setWidth(18);
            $sheet->getStyle($col.$column11)->getAlignment()->setHorizontal('center');
            $sheet->getStyle($col.$column11)->applyFromArray($styleArray);
            $sheet->getStyle($col.$column)->applyFromArray($styleArray);

            $col++;
        }

        $sheet->setCellValue($col.$column, chr(32));

        $sheet->mergeCells($col."10:".$col."11");
        $sheet->setCellValue($col.'10', '特１');
        $sheet->getColumnDimension($col)->setWidth(18);
        $sheet->getStyle($col.'10')->getAlignment()->setHorizontal('center');
        $sheet->getStyle($col.'10')->getAlignment()->setVertical('center');
        $sheet->getStyle($col.'10')->applyFromArray($styleArray);
        $sheet->getStyle($col.'11')->applyFromArray($styleArray);

        $col++;

        $sheet->mergeCells($col."10:".$col."11");
        $sheet->setCellValue($col.'10', '特２');
        $sheet->getColumnDimension($col)->setWidth(18);
        $sheet->getStyle($col.'10')->getAlignment()->setHorizontal('center');
        $sheet->getStyle($col.'10')->getAlignment()->setVertical('center');
        $sheet->getStyle($col.'10')->applyFromArray($styleArray);
        $sheet->getStyle($col.'11')->applyFromArray($styleArray);

        $column = 12;
        $index = 1;
        foreach($list_staff as $staff){
            $staff_id = $staff['s_id'];
            $option_staff_id = $list_staff_data[$staff_id]['co_id'];

            $sheet->setCellValue('E'.$column, $index);
            $sheet->getStyle('E'.$column)->getFont()->setName($font_family)->setSize(10);
            $sheet->getStyle('E'.$column)->applyFromArray($styleArray);
            $sheet->getStyle('E'.$column)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');

            $sheet->setCellValue('F'.$column, $staff['s_lastname'].' '. $staff['s_firstname']);
            $sheet->getStyle('F'.$column)->getAlignment()->setHorizontal('left');
            $sheet->getStyle('F'.$column)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');
            $sheet->getStyle('F'.$column)->applyFromArray($styleArray);

            $sheet->setCellValue('G'.$column, $staff['s_lastname'].' '. $staff['s_firstname']);
            $sheet->getStyle('G'.$column)->getAlignment()->setHorizontal('left');
            $sheet->getStyle('G'.$column)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');
            $sheet->getStyle('G'.$column)->applyFromArray($styleArray);

            $col = 'I';
            $total_amount = 0;
            foreach($list_options as $option){
                $op_id = $option['op_id'];
                $op_amount = $option['op_amount'];
                $list_option_staff_id = array_keys($option_staff_id);
                if (in_array($op_id, $list_option_staff_id)) {
                    if (in_array($op_id, array(9999, 99999, 99998))){
                        $op_amount = !empty($list_staff_data[$staff_id]['amount'][$op_id]) ? $list_staff_data[$staff_id]['amount'][$op_id] : 0 ;                       
                    }else{
                        $op_amount = $option_staff_id[$op_id] * $op_amount;
                    }

                    $total_amount += $op_amount;
                    $sheet->setCellValue($col . $column, $option_staff_id[$op_id]);
                }
                $sheet->getStyle($col.$column)->getAlignment()->setHorizontal('right');
                $sheet->getStyle($col.$column)->applyFromArray($styleArray);
                $sheet->getStyle($col.$column)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');
                $col++;               
                if (in_array($op_id, $list_option_staff_id)) {
                    $sheet->setCellValue($col . $column, number_format($op_amount));
                }
                $sheet->getStyle($col.$column)->getAlignment()->setHorizontal('right');
                $sheet->getStyle($col.$column)->applyFromArray($styleArray);
                $sheet->getStyle($col.$column)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');   

                $col++;
            }

            $sheet->setCellValue($col . $column, '');
            $sheet->getStyle($col.$column)->getAlignment()->setHorizontal('right');
            $sheet->getStyle($col.$column)->applyFromArray($styleArray);
            $sheet->getStyle($col.$column)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');
            $col++;

            $sheet->setCellValue($col . $column, '');
            $sheet->getStyle($col.$column)->getAlignment()->setHorizontal('right');
            $sheet->getStyle($col.$column)->applyFromArray($styleArray);
            $sheet->getStyle($col.$column)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');           

            $sheet->setCellValue('H'.$column, number_format($total_amount));
            $sheet->getStyle('H'.$column)->getAlignment()->setHorizontal('right');
            $sheet->getStyle('H'.$column)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');
            $sheet->getStyle('H'.$column)->applyFromArray($styleArray);

            $column++;
            $index++;
        }

        $sheet->getStyle('D10:D'.($column-1))->getBorders()->getAllBorders()->applyFromArray($styleArray2);
        $sheet->getStyle('D10:D'.($column-1))->getBorders()->getRight()->applyFromArray($styleArray1);

        $sheet->getStyle('E9:'.$col.'9')->getBorders()->getAllBorders()->applyFromArray($styleArray2);
        $sheet->getStyle('E9:'.$col.'9')->getBorders()->getBottom()->applyFromArray($styleArray1);

        $sheet->getStyle($col.'9')->getBorders()->getAllBorders()->applyFromArray($styleArray2);

        $sheet->setCellValue('A26', chr(32));

        $writer = new Xlsx($spreadsheet);
        $fileName = '集計出力_'.date('Ymd').'.xlsx';
        $writer->save($fileName);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($fileName));
        readfile($fileName);
        unlink($fileName);
        exit();
    }
    public function exportCSV(Request $req)
    {
        if(!empty($req->str_date)&&!empty($req->end_date)&&!empty($req->shop_id)){
            $str_date = str_replace('/','-',$req->str_date) . ' 00:00:00';
            $end_date = str_replace('/','-',$req->end_date) . ' 23:59:59';

            $list_sales = Sales::where('sale_date','>=',$str_date)
                ->where('sale_date','<=',$end_date)
                ->where('s_sh_id',$req->shop_id)
                ->orderBy('s_id', 'DESC')
                ->where('s_del_flg', 0)->paginate(1000000);
        }else{
            $list_sales = Sales::where('s_del_flg', 0)->orderBy('s_id', 'DESC')->paginate(1000000);
        }

        $filename = '会計出力_'.date('Ymd').'.csv';
        $spreadsheet = new Spreadsheet();
        $writer = new Csv($spreadsheet);
        $writer->setUseBOM(true);
        $writer->setDelimiter(',');
        $writer->setEnclosure('"');
        $writer->setLineEnding("\r\n");
        $writer->setSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $row = 1;
        $sheet->setCellValue('A'.$row, 'STT');
        $sheet->setCellValue('B'.$row, 'Ngày tháng');
        $sheet->setCellValue('C'.$row, 'Phương thức thanh toán');
        $sheet->setCellValue('D'.$row, 'Tên hàng hóa & dịch vụ');
        $sheet->setCellValue('E'.$row, 'Đơn vị tính');
        $sheet->setCellValue('F'.$row, 'Số lượng');
        $sheet->setCellValue('G'.$row, 'Đơn giá');
        $sheet->setCellValue('H'.$row, 'Thành tiền');
        $row++;
        $index = 1;
        foreach($list_sales as $sale) {
            $sale_date = empty($sale->sale_date)? '' : date('Y/m/d', strtotime($sale->sale_date));
            $s_pay = ((int)$sale->s_pay === 0 ?  'キャッシュ' : 'カード') ;                
            $unit = 'Gói';
            $quantity = 1;
            $saleDetails = $sale->SaleDetails;
            foreach($saleDetails as $sDetail) {
                $co_name = empty( $sDetail->Course->co_name)? ( $sDetail->s_co_id == 0 ? 'フリー' : '商品販売') :  $sDetail->Course->co_name;
                if ($co_name == 'フリー' && $sDetail->s_money < 0){
                    $co_name = 'フリー(値引分)';
                }
                $s_money = empty($sDetail->s_money)? 0 : $sDetail->s_money;
                $total = number_format($s_money * (int)$quantity);

                $sheet->setCellValue('A'.$row, $index);
                $sheet->setCellValue('B'.$row, $sale_date);
                $sheet->setCellValue('C'.$row, $s_pay);
                $sheet->setCellValue('D'.$row, $co_name);
                $sheet->setCellValue('E'.$row, $unit);
                $sheet->setCellValue('F'.$row, $quantity);
                $sheet->setCellValue('G'.$row, number_format($s_money));
                $sheet->setCellValue('H'.$row, $total);

                $index++;
                $row++;
            }
        }

        $writer->save($filename);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.basename($filename).'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        readfile($filename);
        unlink($filename);
        exit();        
    }
}