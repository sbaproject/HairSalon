@extends('master')
@section('title','売上管理編集')
@section('menu')
@parent
@endsection
@section('content')
</br>
    <div class="container" style="padding: 20px;">
        <div class="row">
            <div class="col-10">
                <h2 style="border-bottom: 1px solid #ccc; line-height: normal;">
                売上管理編集
                </h2>
                <!-- <div id="statusResult" class="{{ Session::has('success') ? 'statusResult' : 'statusBefore' }}">
            @if (\Session::has('success'))            
                    {{ \Session::get('success') }}           
            @endif
        </div>  -->
                <form method="post">
                @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">売上管理ID</span>
                            </div>
                            @php
                                $id = $sales->s_id;
                                if ($id < 10) {
                                    $id = '000' . $id;
                                } else {
                                    if ($id >= 10 && $id < 100) {
                                        $id = '00' . $id;
                                    }
                                    if ($id >= 100 && $id < 1000) {
                                        $id = '0' . $id;
                                    }
                                }
                            @endphp
                            <input type="text" readonly class="form-control" value="{{$id}}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Date Sale</span>
                            </div>
                            <input id="sale_date" readonly type="text" class="form-control datetimepicker-input col-md-2"
                                         name="sale_date" autocomplete="off"  value="{{ $salesDate }}">
                                    <div class="input-group-append" data-target="#sale_date" onclick="$('#sale_date').focus();">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>     
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">顧客ID</span>
                            </div>
                            <div class="form-control wrapper-select">
                            <select class="select-shop2" id="s_c_id" name="s_c_id" onchange="onCustomerChange({{ $list_customer }})">
                            @foreach($list_customer as $customer)
                            <option value = '{{$customer->c_id}}' {{ $sales->s_c_id == $customer->c_id ? 'selected' : '' }} >
                                {{$customer->c_id}} - {{$customer->c_lastname}} {{$customer->c_firstname}}
                            </option>
                            @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">顧客姓</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "txt_lastname" value="{{ !empty($sales->Customer->c_lastname)?$sales->Customer->c_lastname:''}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">顧客名</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "txt_firstname" value="{{ !empty($sales->Customer->c_firstname)?$sales->Customer->c_firstname:''}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">コース</span>
                            </div>
                            <div class="form-control wrapper-select">
                            <select class="select-shop2" name="s_co_id" id ="s_co_id" onchange="onCourseChange({{ $list_course }},{{ $list_option }})">
                            @foreach($list_course as $course)
                            <option value = '{{$course->co_id}}' {{ $sales->s_co_id == $course->co_id ? 'selected' : '' }}>
                                {{$course->co_name}} 
                            </option>
                            @endforeach
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">サブ1</span>
                            </div>
                        
                            <input type="text" class="form-control" readonly name = "s_opt1" value="{{ !empty($sales->Option1->op_name)?$sales->Option1->op_name:''}}">                           
                            <div class="form-control wrapper-select">
                            <select class="select-shop2" name = "s_opts1">
                            @foreach($list_staff as $staff)
                            <option value = '{{$staff->s_id}}' {{ $sales->s_opts1 == $staff->s_id ? 'selected' : '' }}>
                            {{$staff->s_firstname}} {{$staff->s_lastname}}
                            </option>
                            @endforeach
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">サブ2</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "s_opt2" value="{{ !empty($sales->Option2->op_name)?$sales->Option2->op_name:''}}">
                            <div class="form-control wrapper-select">
                            <select class="select-shop2" name = "s_opts2">
                            @foreach($list_staff as $staff)
                            <option value = '{{$staff->s_id}}' {{ $sales->s_opts2 == $staff->s_id ? 'selected' : '' }}>
                            {{$staff->s_firstname}} {{$staff->s_lastname}}
                            </option>
                            @endforeach
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">サブ3</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "s_opt3" value="{{ !empty($sales->Option3->op_name)?$sales->Option3->op_name:''}}">
                            <div class="form-control wrapper-select">
                            <select class="select-shop2" name = "s_opts3">
                            @foreach($list_staff as $staff)
                            <option value = '{{$staff->s_id}}' {{ $sales->s_opts3 == $staff->s_id ? 'selected' : '' }}>
                            {{$staff->s_firstname}} {{$staff->s_lastname}}
                            </option>
                            @endforeach
                            </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">金額</span>
                            </div>
                            <input type="text" readonly class="form-control {{ ($errors->first('s_money')) ? 'is-invalid'  :'' }}" value="{{ $sales->s_money }}" name="s_money">
                            <div class="invalid-feedback">
                                @error('s_money')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">支払い方法</span>
                            </div>
                            <select class="form-control" name="s_pay">
                            @if($sales->s_pay === 0) 
                                <option selected value ="0">キャッシュ</option>
                                <option value ="1">カード</option>
                            @else
                                <option value ="0">キャッシュ</option>
                                <option selected value ="1">カード</option>
                            @endif
                            </select>
                        </div>
                    </div>
                  
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">備考</span>
                            </div>
                            <textarea maxlength="100" class="form-control" rows=4 name="s_text" >{{ $sales->s_text }}</textarea>
                        </div>
                    </div>
                    <input type="hidden" id="urlBack" name="urlBack" value="{{url()->previous()}}">
                    <div class="clsCenter">
                    <button type="submit" class="btn btn-primary buttonSales btn-left-sales">追加</button>                    
                    <a role="button" href="{{ url()->previous() }}" class="btn btn-secondary buttonSales" >キャンセル</a>
                    <div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
@endsection