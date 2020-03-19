@extends('master')
@section('title','コース管理')
@section('menu')
@parent
@endsection
@section('content')
    <div style="padding: 20px;">
        <div class="flex-container">
            <div class="calendar-picker">
                <input style="width: 100%;" type="text">
            </div>
            <div>
                <a class="btn btn-primary" href="{{url('course/new')}}" role="button">新規追加</a>
            </div>
        </div>
        <br/>
        @if (\Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ \Session::get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>    
        @endif
        @if (isset($list_course))
            <table class="table table-bordered">
                <thead class="table-header">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">コース名</th>
                        <th scope="col">サブ１</th>
                        <th scope="col">サブ２</th>
                        <th scope="col">サブ３</th>
                        <th scope="col">金額</th>
                        <th scope="col">備考</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Đánh số thứ tự theo trang --}}
                    @php
                        $page = request()->get("page");
                        if ($page)
                            $index = $page * 10 - 9;
                        else
                            $index = 1;
                    @endphp

                    @foreach($list_course as $course)
                        <tr>
                            <th>{{ $index < 10 ? '0' . $index : $index }}</th>
                            <td>{{ $course->co_name }}</td>
                            <td>{{ $course->co_opt1 }}</td>
                            <td>{{ $course->co_opt2 }}</td>
                            <td>{{ $course->co_opt3 }}</td>
                            <td>{{ $course->co_money }}</td>
                            <td>{{ $course->co_text }}</td>
                            <td><a href="{{ url('course/edit/' . $course->co_id) }}">編集</a>&nbsp;<a href="{{ url('course/delete/' . $course->co_id) }}" style="color: red;">削除</a></td>
                        </tr>
                        @php 
                            $index++; 
                        @endphp
                    @endforeach
                </tbody>
            </table>
            {{ $list_course->links() }}
        @endif
    </div>
@endsection