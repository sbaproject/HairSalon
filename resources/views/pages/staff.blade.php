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
        <table class="table table-bordered">
            <thead>
                <tr style="background-color: #e8e8e8;">
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
                <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>カット</td>
                    <td>テキストテキスト</td>
                    <td><a href="#">編集</a>&nbsp;<a href="#" style="color: red; text-decoration: underline;">削除</a></td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                    <td>カット</td>
                    <td>テキストテキスト</td>
                    <td><a href="#">編集</a>&nbsp;<a href="#" style="color: red; text-decoration: underline;">削除</a></td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>Larry the Bird</td>
                    <td>Thornton</td>
                    <td>@twitter</td>
                    <td>カット</td>
                    <td>テキストテキスト</td>
                    <td><a href="#">編集</a>&nbsp;<a href="#" style="color: red; text-decoration: underline;">削除</a></td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>カット</td>
                    <td>テキストテキスト</td>
                    <td><a href="#">編集</a>&nbsp;<a href="#" style="color: red; text-decoration: underline;">削除</a></td>
                </tr>
                    <tr>
                    <th scope="row">5</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                    <td>カット</td>
                    <td>テキストテキスト</td>
                    <td><a href="#">編集</a>&nbsp;<a href="#" style="color: red; text-decoration: underline;">削除</a></td>
                </tr>
                <tr>
                    <th scope="row">6</th>
                    <td>Larry the Bird</td>
                    <td>Thornton</td>
                    <td>@twitter</td>
                    <td>カット</td>
                    <td>テキストテキスト</td>
                    <td><a href="#">編集</a>&nbsp;<a href="#" style="color: red; text-decoration: underline;">削除</a></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection