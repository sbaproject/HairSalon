@extends('master')
@section('title','コース管理')
@section('menu')
@parent
@endsection
@section('content')
    <div class="padding-20">
        <div class="course-list">
            <div class="header-index">
                <div class="header-title">
                    <span>コース一覧</span>
                </div>
                <div>
                    <a class="btn btn-primary add-new-btn" href="{{url('course/new')}}" role="button">新規追加</a>
                </div>
                @if (\Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ \Session::get('success') }}
                    </div>    
                @endif
            </div>
           
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
                                <td>{{ $course->Option1->op_name }}</td>
                                <td>{{ $course->Option2->op_name }}</td>
                                <td>{{ $course->Option3->op_name }}</td>
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
                <div class="pagination-container">
                    <div>{{ $list_course->links() }}</div>
                </div>
            @endif
        </div>
        <div>
            <div class="header-index">
                <div class="header-title">
                    <span>オプション一覧</span>
                </div>
                <div>
                    <a class="btn btn-primary add-new-btn" href="{{url('option/new')}}" role="button">新規追加</a>
                </div>
                @if (\Session::has('success-option'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ \Session::get('success-option') }}
                    </div>    
                @endif
            </div>
            
            @if (isset($list_option))
                <table class="table table-bordered">
                    <thead class="table-header">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">オプション名</th>
                            <th scope="col">金額</th>
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

                        @foreach($list_option as $option)
                            <tr>
                                <th>{{ $index < 10 ? '0' . $index : $index }}</th>
                                <td>{{ $option->op_name }}</td>
                                <td>{{ $option->op_amount }}</td>
                                <td><a href="{{ url('option/edit/' . $option->op_id) }}">編集</a>&nbsp;<a href="{{ url('option/delete/' . $option->op_id) }}" style="color: red;">削除</a></td>
                            </tr>
                            @php 
                                $index++; 
                            @endphp
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination-container">
                    <div>{{ $list_option->links() }}</div>
                </div>
            @endif
        </div>
    </div>
@endsection