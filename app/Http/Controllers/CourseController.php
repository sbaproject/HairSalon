<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Shop;
use App\Option;
use Carbon\Carbon;

class CourseController extends Controller
{
    public function index() {
        // get all course have del_flg = 0 and soft by update time
        $list_course = Course::where('co_del_flg', 0)->orderBy('co_id', 'DESC')->get();
        $list_option = Option::where('op_del_flg', 0)->orderBy('op_id', 'DESC')->get();
        return view('pages.course', compact('list_course', 'list_option'));
    }

    public function getCourseNew() {
        $list_option = Option::where('op_del_flg', 0)->get();
        $last_course = Course::orderBy('co_id', 'DESC')->take(1)->first('co_id');
        if ($last_course != null) {
            $last_course_id = $last_course->co_id;
        } else {
            $last_course_id = 0;
        }
        return view('pages.course_new', compact('list_option', 'last_course_id'));
    }

    public function postCourseNew(Request $request) {
        $validator = $request->validate([
            'co_name'   => 'required',
        ], [
            'co_name.required'  => '入力してください。',
        ]);

        // check must choose at least 1 option
        if ($validator && ($request->co_opt1 == NULL) && ($request->co_opt2 == NULL) && ($request->co_opt3 == NULL)) {
            $option_error = "一つ以上のオプションを選択してください。";
            return redirect()->back()->withInput($request->input())->withErrors(['option_error' => $option_error]);
        }

        // get current time
        $currentTime = Carbon::now();

        $course = new Course([
            'co_name'   => $request->co_name,
            'co_opt1'   => $request->co_opt1,
            'co_opt2'   => $request->co_opt2,
            'co_opt3'   => $request->co_opt3,
            'co_text'   => $request->co_text,
            'co_sh_id'  => session('user')->u_shop,
            'co_del_flg'=> 0,
            'co_date'   => $currentTime,
            'co_update' => $currentTime
        ]);
        $course->save();
        return redirect('course')->with('success', 'Added course successfully!');
    }

    public function getCourseEdit($id) {
        $list_option = Option::where('op_del_flg', 0)->get();
        $course = Course::find($id);
        return view('pages.course_edit', compact('list_option', 'course'));
    }

    public function postCourseEdit(Request $request) {
        $validator = $request->validate([
            'co_name'   => 'required',
        ], [
            'co_name.required'  => '入力してください!',
        ]);

        // check must choose at least 1 option
        if ($validator && ($request->co_opt1 == NULL) && ($request->co_opt2 == NULL) && ($request->co_opt3 == NULL)) {
            $option_error = "少なくとも1つのオプションを選択してください。";
            return redirect()->back()->with('option_error', $option_error);
        }

        $course = Course::find($request->co_id);

        $course->co_name = $request->co_name;
        $course->co_opt1 = $request->co_opt1;
        $course->co_opt2 = $request->co_opt2;
        $course->co_opt3 = $request->co_opt3;
        $course->co_text = $request->co_text;
        $course->co_update = Carbon::now();

        $course->save();
        return redirect('course')->with('success', 'Updated course successfully!');
    }

    public function getCourseDelete($id) {
        $course = Course::find($id);
        $course->co_del_flg = 1;
        $course->co_update  = Carbon::now();
        $course->save();
        return redirect()->back()->with('success', 'Deleted course successfully!');
    }
}
