<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;
use App\Shop;
use Carbon\Carbon;

class StaffController extends Controller
{
    public function index() {
        // get all staff have del_flg = 1 and soft by update time
        $list_staff = Staff::where('s_del_flg', 1)->orderBy('s_update', 'DESC')->paginate(10);
        return view('pages.staff', compact('list_staff'));
    }    

    public function getStaffNew() {
        $list_shop = Shop::all();
        return view('pages.staff_new', compact('list_shop'));
    }

    public function postStaffNew(Request $request) {
        $validator = $request->validate([
            's_firstname'   => 'required',
            's_lastname'    => 'required',
            's_charge'      => 'required',
        ], [
            's_firstname.required'  => '入力してください!',
            's_lastname.required'   => '入力してください!',
            's_charge.required'     => '入力してください!'
        ]);

        // get current time
        $currentTime = Carbon::now();

        $staff = new Staff([
            's_firstname'   => $request->get('s_firstname'),
            's_lastname'    => $request->get('s_lastname'),
            's_shop'        => $request->get('s_shop'),
            's_charge'      => $request->get('s_charge'),
            's_text'        => $request->get('s_text'),
            's_date'        => $currentTime,
            's_update'      => $currentTime
        ]);
        $staff->save();
        return redirect('staff')->with('success', 'Added staff successfully!');
    }

    public function getStaffEdit($id) {
        $staff = Staff::where('s_id', $id)->first();
        $list_shop = Shop::all();
        return view('pages.staff_edit', compact('staff', 'list_shop'));
    }

    public function postStaffEdit(Request $request) {
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
        return redirect('staff')->with('success', 'Updated staff successfully!');
    }

    public function getStaffDelete($id) {
        $staff = Staff::find($id);
        $staff->s_del_flg = 0;
        $staff->s_update  = Carbon::now();
        $staff->save();
        return redirect()->back()->with('success', 'Deleted staff successfully!');
    }
}
