<?php

namespace App\Http\Controllers;
use App\Customer;
use Carbon\Carbon;

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
        if($request->searchf_name != null){
            $list_customer = Customer::where('c_firstname', $request->searchf_name)->get();
        }
        else if($request->searchl_name != null){
            $list_customer = Customer::where('c_lastname', $request->searchl_name)->get();
        }
        else if($request->searchid != null){
            $list_customer = Customer::where('c_id', $request->searchid)->get();
        }
        return view('pages.customer',compact('list_customer'));
    }
}