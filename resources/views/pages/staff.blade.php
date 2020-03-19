@extends('master')
@section('title','スタッフ管理')
@section('menu')
@parent
@endsection
@section('content')
    <div style="padding: 20px;">
        <a class="btn btn-primary" href="{{url('staff/new')}}" role="button">新規追加</a>
        <br/>
        <br/>
        @if (\Session::has('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ \Session::get('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>    
        @endif
        @if (isset($list_staff))
            <table class="table table-bordered">
                <thead class="table-header">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">姓</th>
                        <th scope="col">名</th>
                        <th scope="col">担当店舗</th>
                        <th scope="col">主担当</th>
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

                    @foreach($list_staff as $staff)
                        <tr>
                            <th>{{ $index < 10 ? '0' . $index : $index }}</th>
                            <td>{{ $staff->s_firstname }}</td>
                            <td>{{ $staff->s_lastname }}</td>
                            <td>{{ $staff->Shop->sh_name }}</td>
                            <td>{{ $staff->s_charge }}</td>
                            <td>{{ $staff->s_text }}</td>
                            <td><a href="{{ url('staff/edit/' . $staff->s_id) }}">編集</a>&nbsp;<a href="{{ url('staff/delete/' . $staff->s_id) }}" style="color: red;">削除</a></td>
                        </tr>
                        @php 
                            $index++; 
                        @endphp
                    @endforeach
                </tbody>
            </table>
        @endif
        {{ $list_staff->links() }}
    </div>
@endsection