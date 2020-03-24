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
        return view('pages.customer_new');
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
        $data = array();
        $list_customer = Customer::where('c_lastname', 'like', '%'.$request->searchl_name.'%')
        ->select(
            '*',
            DB::raw("(select count(*) from t_sales where t_customer.c_id = t_sales.s_c_id) as c_count")                               
        )
        ->get();
       if($request->searchid != null && $request->searchf_name == null && $request->searchl_name == null)
        {
            $list_customer = Customer::where('c_id', $request->searchid)
                                    ->select(
                                        '*',
                                        DB::raw("(select count(*) from t_sales where t_customer.c_id = t_sales.s_c_id) as c_count")                               
                                    )
                                    ->get();
        }
        else if($request->searchf_name != null && $request->searchid == null && $request->searchl_name == null){
            $list_customer = Customer::where('c_firstname', 'like', '%'.$request->searchf_name.'%')
                                    ->select(
                                        '*',
                                        DB::raw("(select count(*) from t_sales where t_customer.c_id = t_sales.s_c_id) as c_count")                               
                                    )
                                    ->get();
        }
        else if($request->searchl_name != null && $request->searchid == null && $request->searchf_name == null){
            $list_customer = Customer::where('c_lastname', 'like', '%'.$request->searchl_name.'%')
                                    ->select(
                                        '*',
                                        DB::raw("(select count(*) from t_sales where t_customer.c_id = t_sales.s_c_id) as c_count")                               
                                    )
                                    ->get();
        }
        
        echo json_encode($list_customer);
        die;
    }
}