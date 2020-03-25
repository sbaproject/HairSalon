<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Option;
use App\Course;
use Carbon\Carbon;

class OptionController extends Controller
{
    public function getOptionNew() {
        $last_option = Option::orderBy('op_id', 'DESC')->take(1)->first('op_id');
        if ($last_option != null) {
            $last_option_id = $last_option->op_id;
        } else {
            $last_option_id = 0;
        }
        return view('pages.option_new', compact('last_option_id'));
    }

    public function postOptionNew(Request $request) {
        $validator = $request->validate([
            'op_name'   => 'required',
            'op_amount'  => 'required|numeric|gt:0',
        ], [
            'op_name.required'      => '入力してください。',
            'op_amount.required'    => '入力してください。',
            'op_amount.numeric'     => '数字をご入力下さい。',
            'op_amount.gt'          => '数字をご入力下さい。',
        ]);

        $option = new Option([
            'op_name'    => $request->get('op_name'),
            'op_amount'  => $request->get('op_amount'),
            'op_del_flg' => 0,
        ]);
        $option->save();
        return redirect('course')->with('success-option', 'Added option successfully!');
    }

    public function getOptionEdit($id) {
        $option = Option::find($id);
        return view('pages.option_edit', compact('option'));
    }

    public function postOptionEdit(Request $request) {
        $validator = $request->validate([
            'op_name'   => 'required',
            'op_amount'  => 'required|numeric|gt:0',
        ], [
            'op_name.required'      => '入力してください。',
            'op_amount.required'    => '入力してください。',
            'op_amount.numeric'     => '数字をご入力下さい。',
            'op_amount.gt'          => '数字をご入力下さい。',
        ]);

        $option = Option::find($request->op_id);
        $option->op_name = $request->op_name;
        $option->op_amount = $request->op_amount;

        $option->save();
        return redirect('course')->with('success-option', 'Updated option successfully!');
    }

    public function getOptionDelete($id) {
        $option = Option::find($id);
        $option->op_del_flg = 1;
        $option->save();

        // update all courses have this option
        $courses = Course::where('co_opt1', $id)->orWhere('co_opt2', $id)->orWhere('co_opt3', $id)->get();

        if (!empty($courses)) {
            foreach ($courses as $course) {
                if (!empty($course->co_opt1) && $course->co_opt1 == $id) {
                    $course->co_opt1 = null;
                }
                if (!empty($course->co_opt2) && $course->co_opt2 == $id) {
                    $course->co_opt2 = null;
                }
                if (!empty($course->co_opt3) && $course->co_opt3 == $id) {
                    $course->co_opt3 = null;
                }
                $course->co_update = Carbon::now();
                $course->save();
            }
        }
        
        return redirect()->back()->with('success-option', 'Deleted option successfully!');
    }
}
