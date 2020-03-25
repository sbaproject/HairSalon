@extends('master')
@section('title','スタッフ管理')
@section('menu')
@parent
@endsection
@section('content')
    <div class="padding-20">
        <div class="header-index">
        <div class="header-title">
                    <span>スタッフ管理</span>
                </div>
            <a class="btn btn-primary add-new-btn" href="{{url('staff/new')}}" role="button">新規追加</a>
            @if (\Session::has('success'))
                <div class=" alert alert-success alert-dismissible fade show">
                    {{ \Session::get('success') }}
                </div>    
            @endif
        </div>
        
        @if (isset($list_staff))
            <table class="table table-bordered table-hover table-fixed">
                <thead class="table-header">
                    <tr>
                        <th width="5%" scope="col">No</th>
                        <th width="10%" scope="col">姓</th>
                        <th width="10%" scope="col">名</th>
                        <th width="14%" scope="col">担当店舗</th>
                        <th width="12%" scope="col">主担当</th>
                        <th width="39%" scope="col">備考</th>
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

                    @foreach($list_staff as $staff)
                        <tr>
                            <th width="5%">{{ $index < 10 ? '0' . $index : $index }}</th>
                            <td width="10%">{{ $staff->s_lastname }}</td>
                            <td width="10%">{{ $staff->s_firstname }}</td>
                            <td width="14%">{{ $staff->Shop->sh_name }}</td>
                            <td width="12%">{{ $staff->s_charge }}</td>
                            <td width="39%">{{ $staff->s_text }}</td>
                            <td id="link" width="10%"><a href="{{ url('staff/edit/' . $staff->s_id) }}">編集</a>&nbsp;<a href="{{ url('staff/delete/' . $staff->s_id) }}" style="color: red;">削除</a></td>
                        </tr>
                        @php 
                            $index++; 
                        @endphp
                    @endforeach
                </tbody>
            </table>
            <div class="pagination-container">
                <div>{{ $list_staff->links() }}</div>
            </div>
        @endif
    </div>
@endsection