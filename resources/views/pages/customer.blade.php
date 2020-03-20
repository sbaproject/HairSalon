@extends('master')
@section('title','顧客管理')
@section('menu')
@parent
@endsection
@section('content')
    <div class="padding20">
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
                <thead class="table-header">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">顧客の姓</th>
                        <th scope="col">顧客名</th>
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
                        <tr>
                            <th>{{ $index < 10 ? '0' . $index : $index }}</th>
                            <td>{{ $customer->c_firstname }}</td>
                            <td>{{ $customer->c_lastname }}</td>
                            <td>{{ $customer->c_text }}</td>
                            <td><a href="{{ url('customer/edit/' . $customer->c_id) }}">編集</a>&nbsp;</td>
                        </tr>
                        @php 
                            $index++; 
                        @endphp
                    @endforeach
                </tbody>
            </table>
            {{ $list_customer->links() }}
        @endif
    </div>
@endsection