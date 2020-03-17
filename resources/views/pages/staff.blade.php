@extends('master')
@section('title','スタッフ登録')
@section('menu')
@parent
@endsection
@section('content')
    <div style="padding: 20px;">
        <button type="button" class="btn btn-primary"><a href="staff/new" style="color: white; text-decoration: none;">新規追加</a></button>
        <br/>
        <br/>
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
                    @foreach($list_staff as $staff)
                        <tr>
                            <th scope="row">{{$staff->s_id}}</th>
                            <td>{{$staff->s_firstname}}</td>
                            <td>{{$staff->s_lastname}}</td>
                            <td>{{$staff->Shop->sh_name}}</td>
                            <td>{{$staff->s_charge}}</td>
                            <td>{{$staff->s_text}}</td>
                            <td><a href="#">編集</a>&nbsp;<a href="#" style="color: red; text-decoration: underline;">削除</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection