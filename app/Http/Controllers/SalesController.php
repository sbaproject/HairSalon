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
use PDF;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
            's_c_id'     => 'required',
            's_co_id'    => 'required',
            's_money-hidden-ori'    => 'required',
        ], [
            's_c_id.required'  => '入力してください。',
            's_co_id.required'   => '入力してください。',
            's_money-hidden-ori.required'   => '入力してください。',
        ]);     

        // if s_co_id = 0 then it is フリー course
        if ($request->get('s_co_id') == 0) {
            if ($request->get('s_opts1') === null ) {
                $customer_error = "入力してください。";
                return redirect()->back()->withInput($request->input())->withErrors(['customer_error' => $customer_error]);            
            }   
    
            // get current time
            $currentTime = Carbon::now();

            $sales = new Sales([
                's_c_id'        => $request->get('s_c_id'),
                's_co_id'       => $request->get('s_co_id'),
                's_opt1'        => 0,
                's_opts1'       => $request->get('s_opts1'),
                's_opt2'        => null,
                's_opts2'       => null,
                's_opt3'        => null,
                's_opts3'       => null,    
                's_opt4'        => null,
                's_opts4'       => null, 
                's_opt5'        => null,
                's_opts5'       => null,        
                's_money'       => str_replace(",", "", $request->get('s_money-hidden-ori')),
                's_saleoff_flg' => ($request->has('s_saleoff_flg')) ? 1 : 0,
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

        // s_co_id != 0
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

        // get current time
        $currentTime = Carbon::now();

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
            's_money'       => str_replace(",", "", $request->get('s_money-hidden-ori')),
            's_saleoff_flg' => ($request->has('s_saleoff_flg')) ? 1 : 0,
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
            's_c_id'     => 'required',
            's_co_id'    => 'required',
            's_money-hidden-ori'    => 'required',
        ], [
            's_c_id.required'  => '入力してください。',
            's_co_id.required'   => '入力してください。',
            's_money-hidden-ori.required'   => '入力してください。',
        ]);    

        // if s_co_id = 0 then it is フリー course
        if ($request->get('s_co_id') == 0) {
            if ($request->get('s_opts1') === null ) {
                $customer_error = "入力してください。";
                return redirect()->back()->withInput($request->input())->withErrors(['customer_error' => $customer_error]);            
            }   
    
            $sales = Sales::find($id);

            $sales->s_c_id      = $request->get('s_c_id');
            $sales->s_co_id     = $request->get('s_co_id');
            $sales->s_opt1      = 0;
            $sales->s_opts1     = $request->get('s_opts1');
            $sales->s_opt2      = null;
            $sales->s_opts2     = null;
            $sales->s_opt3      = null;
            $sales->s_opts3     = null;
            $sales->s_opt4      = null;
            $sales->s_opts4     = null;
            $sales->s_opt5      = null;
            $sales->s_opts5     = null;        
            $sales->s_money     = str_replace(",", "", $request->get('s_money-hidden-ori'));
            $sales->s_saleoff_flg = ($request->has('s_saleoff_flg')) ? 1 : 0;
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
        $sales->s_money     = str_replace(",", "", $request->get('s_money-hidden-ori'));
        $sales->s_saleoff_flg = ($request->has('s_saleoff_flg')) ? 1 : 0;
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

        }else{
            $export_date = date('Y-m-d');
            $list_sales = Sales::where('s_del_flg', 0)->orderBy('s_id', 'DESC')->get()->toArray();;
            $shop_name = '全部';
        }
        // process data
        $list_staff_data = array();
        $list_option_id = array();
        $sum_money = 0; //B6
        foreach ($list_sales as $sale){
            $sum_money += $sale['s_money'];
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

            if (!empty($s_opt1)){
                $list_staff_data[$s_opts1]['co_id'][] = $s_opt1;
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
            $list_co_id = array_count_values($list_co_id);
            $list_staff_data[$key]['co_id'] = $list_co_id;
        }

        // get data from database
        $list_options = Option::whereIn('op_id',$list_option_id)->orderBy('op_id', 'ASC')->get()->toArray();
        $list_staff = Staff::whereIn('s_id',$list_staff_id)->orderBy('s_id', 'ASC')->get()->toArray();

        $list_sales_count = count($list_sales); //B7
        $avg_person = ceil($list_sales_count/$day_in_month) ; //B8 = B7 / $day_in_month
        $total_staff = count($list_staff_id); //B9

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

        $sheet->setCellValue('A5', '当月売上');
        $sheet->setCellValue('A6', '当月総客数');
        $sheet->setCellValue('A7', 'のべ人数');
        $sheet->setCellValue('A8', 'スタッフ数');

        $sheet->getStyle('B5')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('B6')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('B7')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('B8')->getAlignment()->setHorizontal('right');
        $sheet->getStyle('B5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');
        $sheet->getStyle('B6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');
        $sheet->getStyle('B7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');
        $sheet->getStyle('B8')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');

        $sheet->setCellValue('B5', number_format($sum_money));
        $sheet->setCellValue('B6', number_format($list_sales_count));
        $sheet->setCellValue('B7', number_format($avg_person));
        $sheet->setCellValue('B8', number_format($total_staff));


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

        $sheet->setCellValue('E10', 'No.');
        $sheet->getStyle('E10')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('E10')->applyFromArray($styleArray);

        //F10
        $sheet->setCellValue('F10', '氏名');
        $sheet->getStyle('F10')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('F10')->applyFromArray($styleArray);

        //G10
        $sheet->setCellValue('G10', '氏名カナ');
        $sheet->getStyle('G10')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('G10')->applyFromArray($styleArray);

        //H10
        $sheet->setCellValue('H10', '実績売上');
        $sheet->getStyle('H10')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('H10')->applyFromArray($styleArray);

        $column = 10;
        $col = 'I';
        foreach($list_options as $option){
            $sheet->getColumnDimension($col)->setWidth(18);
            $sheet->setCellValue($col.$column, $option['op_name']);
            $sheet->getStyle($col.$column)->getAlignment()->setHorizontal('center');
            $sheet->getStyle($col.$column)->applyFromArray($styleArray);
            $col++;
        }

        $sheet->setCellValue($col.$column, chr(32));

        $column = 11;
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
                    $total_amount += $option_staff_id[$op_id] * $op_amount;
                    $sheet->setCellValue($col . $column, $option_staff_id[$op_id]);
                }
                $sheet->getStyle($col.$column)->getAlignment()->setHorizontal('right');
                $sheet->getStyle($col.$column)->applyFromArray($styleArray);
                $sheet->getStyle($col.$column)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('d9ead3');
                $col++;
            }

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
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=".$filename,
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );


        $columns = array('STT ', 'Ngày tháng', 'Phương thức thanh toán', 'Tên hàng hóa, dịch vụ' ,'Đơn vị tính', 'Số lượng', 'Đơn giá', 'Thành tiền');

        $callback = function() use ($list_sales, $columns)
        {
            $BOM = "\xEF\xBB\xBF"; // UTF-8 BOM
            $file = fopen('php://output', 'w');
            fwrite($file, $BOM);
            fputcsv($file, $columns);
            $index = 1;
            foreach($list_sales as $sale) {
                $sale_date = empty($sale->sale_date)? ' ' : date('Y/m/d', strtotime($sale->sale_date)).' ';
                $s_pay = ((int)$sale->s_pay === 0 ?  'キャッシュ' : 'カード') ;
                $co_name = empty($sale->Course->co_name)? '' : $sale->Course->co_name;
                $unit = 'Gói ';
                $quantity = '1 ';
                $s_money = empty($sale->s_money)? 0 : $sale->s_money;
                $total = number_format($s_money * (int)$quantity);
                fputcsv($file, array($index.' ', $sale_date, $s_pay.' ', (string)$co_name.' ', (string)$unit, (string)$quantity, number_format($s_money), $total));
                $index++;
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }
}