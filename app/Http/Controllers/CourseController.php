<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Shop;
use Carbon\Carbon;

class CourseController extends Controller
{
    public function index() {
        // get all course have del_flg = 1 and soft by update time
        $list_course = Course::where('co_del_flg', 1)->orderBy('co_update', 'DESC')->paginate(10);
        return view('pages.course', compact('list_course'));
    }

    public function getCourseNew() {
        $list_shop = Shop::all();
        return view('pages.course_new', compact('list_shop'));
    }

    public function postCourseNew(Request $request) {
        $validator = $request->validate([
            'co_name'   => 'required',
            'co_money'  => 'required',
        ], [
            'co_name.required'  => '入力してください!',
            'co_money.required' => '入力してください!',
        ]);

        // get current time
        $currentTime = Carbon::now();

        $course = new Course([
            'co_name'   => $request->get('co_name'),
            'co_sh_id'  => $request->get('co_sh_id'),
            'co_opt1'   => $request->get('co_opt1'),
            'co_opt2'   => $request->get('co_opt2'),
            'co_opt3'   => $request->get('co_opt3'),
            'co_money'  => $request->get('co_money'),
            'co_text'   => $request->get('co_text'),
            'co_date'   => $currentTime,
            'co_update' => $currentTime
        ]);
        $course->save();
        return redirect('course')->with('success', 'Added course successfully!');
    }

    public function getCourseDelete($id) {
        $course = Course::find($id);
        $course->co_del_flg = 0;
        $course->co_update  = Carbon::now();
        $course->save();
        return redirect()->back()->with('success', 'Deleted course successfully!');
    }
}
