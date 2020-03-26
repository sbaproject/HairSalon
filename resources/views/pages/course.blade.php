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
                    <span>コース管理</span>
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
           
            <div class="row">
            <div class="col-12">
            @if (isset($list_course))
            <div class="table-responsive">
                <table id="course-table" class="table table-bordered table-hover table-fixed">
                    <thead class="table-header">
                        <tr>
                            <th width="5%" scope="col">No</th>
                            <th width="15%" scope="col">コース名</th>
                            <th width="15%" scope="col">サブ１</th>
                            <th width="15%" scope="col">サブ２</th>
                            <th width="15%" scope="col">サブ３</th>
                            <th width="15%" scope="col">金額</th>
                            <th width="10%" scope="col">備考</th>
                            <th width="10%" scope="col">Actions</th>
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
                            @php
                                $money = 0;
                                !empty($course->Option1) ? $money += $course->Option1->op_amount : '';
                                !empty($course->Option2) ? $money += $course->Option2->op_amount : '';
                                !empty($course->Option3) ? $money += $course->Option3->op_amount : '';
                            @endphp
                            <tr>
                                <th width="5%">{{ $index < 10 ? '0' . $index : $index }}</th>
                                <td width="15%">{{ $course->co_name }}</td>
                                <td width="15%">{{ !empty($course->Option1) ? $course->Option1->op_name : '' }}</td>
                                <td width="15%">{{ !empty($course->Option2) ? $course->Option2->op_name : ''  }}</td>
                                <td width="15%">{{ !empty($course->Option3) ? $course->Option3->op_name : ''  }}</td>
                                <td width="15%">{{ number_format($money) }}</td>
                                <td width="10%">{{ $course->co_text }}</td>
                                <td id="link" width="10%"><a href="{{ url('course/edit/' . $course->co_id) }}">編集</a>&nbsp;<a href="{{ url('course/delete/' . $course->co_id) }}" style="color: red;">削除</a></td>
                            </tr>
                            @php 
                                $index++; 
                            @endphp
                        @endforeach
                    </tbody>
                </table>
                </div>
</div>
</div>
            @endif
        </div>
        <div>
            <div class="header-index">
                <div class="header-title">
                    <span>オプション管理</span>
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
            <div class="row">
            <div class="col-12">
            @if (isset($list_option))
            <div class="table-responsive">
                <table id="option-table" class="table table-bordered table-hover table-fixed">
                    <thead class="table-header">
                        <tr>
                            <th width="5%" scope="col">No</th>
                            <th width="75%" scope="col">オプション名</th>
                            <th width="10%" scope="col">金額</th>
                            <th width="10%" scope="col">Actions</th>
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
                                <th width="5%">{{ $index < 10 ? '0' . $index : $index }}</th>
                                <td width="75%">{{ $option->op_name }}</td>
                                <td width="10%">{{ number_format($option->op_amount) }}</td>
                                <td id="link" width="10%"><a href="{{ url('option/edit/' . $option->op_id) }}">編集</a>&nbsp;<a href="{{ url('option/delete/' . $option->op_id) }}" style="color: red;">削除</a></td>
                            </tr>
                            @php 
                                $index++; 
                            @endphp
                        @endforeach
                    </tbody>
                </table>
                </div>
</div>
</div>
            @endif
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#course-table').DataTable({
                "searching": false,                
                "lengthChange": false,
                "info": false,
                "language": {
                    "paginate": {
                        "previous": "<"  , 
                            "next": ">"
                        }
                }
            });
        });
        $(document).ready(function() {
            $('#option-table').DataTable({
                "searching": false,                
                "lengthChange": false,
                "info": false,
                "language": {
                    "paginate": {
                        "previous": "<"  ,  
                        "next": ">"
                    }
                }
            });
           
        });
    </script>
@endsection