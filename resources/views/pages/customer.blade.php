@extends('master')
@section('title','売上管理')
@section('menu')
@parent
@endsection
@section('content')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
    <link href="css/kronos.css" rel="stylesheet">
    <script src="js/kronos.js"></script>    
            

    <div style="padding: 20px;">
    <a class="btn btn-primary" href="{{url('customer/new')}}" role="button">新規追加</a>
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
        @if (isset($list_customer))
        <table class="table table-bordered">
            <thead>
                <tr style="background-color: #e8e8e8;">
                <th scope="col">No</th>
                <th scope="col">顧客姓</th>
                <th scope="col">顧客名</th>
                <th scope="col">来客回数</th>
                <th scope="col">備考</th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                        $page = request()->get("page");
                        if ($page)
                            $index = $page * 10 - 9;
                        else
                            $index = 1;
                @endphp
                @foreach($list_customer as $customer)
                @php
                    if ($index < 10)
                        $index = '0' . $index               

                @endphp
                <tr>
                    <th>{{ $index }}</th>
                    <td>{{$customer->c_lastname}}</td>
                    <td>{{$customer->c_firstname}}</td>
                    <td></td>
                    <td>{{$customer->s_text}}</td>
                    <td><a href="{{ url('customer/edit/' . $customer->c_id.'/'.$index) }}">編集</a>&nbsp;<a href="{{ url('customer/delete/' . $customer->c_id) }}" style="color: red;">削除</a></td>
                </tr>
                @php 
                    $index++; 
                @endphp
                @endforeach               
            </tbody>
        </table>
        @endif
        {{ $list_customer->links() }}
    </div>
   
@endsection