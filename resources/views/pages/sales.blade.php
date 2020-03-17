@extends('master')
@section('title','売上管理')
@section('menu')
@parent
@endsection
@section('content')

<div style="padding: 20px;">
        <button type="button" class="btn btn-primary"><a href="sales/new" style="color: white; text-decoration: none;">新規追加</a></button>
        <br/>
        <br/>

        @if (isset($list_sales))
        <table class="table table-bordered">
            <thead>
                <tr style="background-color: #e8e8e8;">
                <th scope="col">No</th>
                <th scope="col">1</th>
                <th scope="col">2</th>
                <th scope="col">3</th>
                <th scope="col">4</th>
                <th scope="col">5</th>
                <th scope="col">6</th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($list_sales as $sales)
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>カット</td>
                    <td>{{$sales->s_money}}</td>
                    <td>テキストテキスト</td>
                    <td><a href="#">編集</a>&nbsp;<a href="#" style="color: red; text-decoration: underline;">削除</a></td>
                </tr>
                @endforeach

               
            </tbody>
        </table>
        @endif
    </div>
@endsection