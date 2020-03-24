<?php

namespace App\Http\Controllers;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //load page with $id
    public function index()
    {    
        $list_customer = Customer::orderBy('c_date', 'DESC')->paginate(10);

        return view('pages.customer', compact('list_customer'));
    }

    public function getCustomerNew() {      
        $max_c_id = Customer::max('c_id') + 1;    
        
        if ( $max_c_id < 10){
            $max_c_id = "000".$max_c_id;
        } 
        else if ( $max_c_id < 100){
            $max_c_id = "00".$max_c_id;
        }
        else if ( $max_c_id < 1000){
            $max_c_id = "0".$max_c_id;
        }
        
        return view('pages.customer_new', compact('max_c_id'));
    }

    public function postCustomerNew(Request $request) {
        $validator = $request->validate([
            'c_firstname'   => 'required',
            'c_lastname'    => 'required',
        ], [
            'c_firstname.required'  => '入力してください!',
            'c_lastname.required'   => '入力してください!',
        ]);

        // get current time
        $currentTime = Carbon::now();

        $staff = new Customer([
            'c_firstname'   => $request->get('c_firstname'),
            'c_lastname'    => $request->get('c_lastname'),
            'c_text'        => $request->get('c_text'),
            'c_date'        => Carbon::now()
        ]);
        $staff->save();
        return redirect('customer')->with('success', 'Added customer successfully!');
    }

    public function getCustomerEdit($id) {
        $customer = Customer::where('c_id', $id)->first();
        return view('pages.customer_edit', compact('customer'));
    }

    public function postCustomerEdit(Request $request) {
        $request->validate([
            'c_firstname'   => 'required',
            'c_lastname'    => 'required',
        ], [
            'c_firstname.required'  => '入力してください!',
            'c_lastname.required'   => '入力してください!'
        ]);

        $customer = Customer::find($request->get('c_id'));

        $customer->c_firstname = $request->get('c_firstname');
        $customer->c_lastname  = $request->get('c_lastname');
        $customer->c_text      = $request->get('c_text');
        $customer->c_update    = Carbon::now();
        $customer->save();
        return redirect('customer')->with('success', 'Updated Customer successfully!');
    }

    public function postSearch(Request $request)
    {       

        if ($request->type == 'search'){
            $query = Customer::where('c_firstname', 'like', '%'.$request->searchf_name.'%');
            if($request->searchid != null)
            {
                $query->where('c_id', $request->searchid);
            }
    
            if($request->searchl_name != null)
            {
                $query->where('c_lastname', 'like', '%'.$request->searchl_name.'%');
            }
    
            $list_customer = $query->select(
                '*',
                DB::raw("(select count(*) from t_sales where t_customer.c_id = t_sales.s_c_id) as c_count")                               
            )
            ->get();
        
            echo json_encode($list_customer);
            die;
        }
        else  if ($request->type == 'update'){
            $customer = Customer::find($request->c_id);
            if (isset($customer)){
                $customer->c_firstname = $request->c_firstname;
                $customer->c_lastname  = $request->c_lastname;
                $customer->c_text      = $request->c_text;
                $customer->c_update    = Carbon::now();
                $customer->save();
                echo 1;         
            }else{
               echo 0;
            }  
            die;                      
        }        
    }
}