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
                                <span class="input-group-text">売上伝票日付</span>
                            </div>
                            <input id="sale_date" readonly type="text" class="form-control datetimepicker-input col-md-2"
                                         name="sale_date" autocomplete="off"  value="{{ old('sale_date') == null ? $salesDate : old('sale_date') }}">
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
                            <div class="form-control wrapper-select {{ ($errors->first('s_c_id')) ? 'is-invalid'  :'' }}">
                            <select class="select-shop2" id="s_c_id" name="s_c_id" onchange="onCustomerChange({{ $list_customer }})">
                            <option value = ''></option>
                            @foreach($list_customer as $customer)
                            <option value = '{{$customer->c_id}}' {{ old('s_c_id') == null ? ($sales->s_c_id == $customer->c_id ? 'selected' : '') : ($customer->c_id == old('s_c_id') ? 'selected' : '') }} >
                                {{$customer->c_id}} - {{$customer->c_lastname}} {{$customer->c_firstname}}
                            </option>
                            @endforeach
                            </select>
                            </div>
                            <div class="invalid-feedback">
                                @error('s_c_id')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">顧客姓</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "txt_lastname" value="{{ old('txt_lastname') == null ? (!empty($sales->Customer->c_lastname)?$sales->Customer->c_lastname:'') : old('txt_lastname') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">顧客名</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "txt_firstname" value="{{ old('txt_firstname') == null ? (!empty($sales->Customer->c_firstname)?$sales->Customer->c_firstname:'') : old('txt_firstname')}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">コース</span>
                            </div>
                            <div class="form-control wrapper-select {{ ($errors->first('s_co_id')) ? 'is-invalid'  :'' }}">
                            <select class="select-shop2" name="s_co_id" id ="s_co_id" onchange="onCourseChange({{ $list_course }},{{ $list_option }})">
                            <option value = ''></option>
                            @foreach($list_course as $course)
                            <option value = '{{$course->co_id}}' {{ old('s_co_id') == null ? ($sales->s_co_id == $course->co_id ? 'selected' : '') : (old('s_co_id') == $course->co_id ? 'selected' : '') }}>
                                {{$course->co_name}} 
                            </option>
                            @endforeach
                            </select>
                            </div>
                            <div class="invalid-feedback">
                                @error('s_co_id')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">サブ1</span>
                            </div>
                        
                            <input type="text" class="form-control" readonly name = "s_opt1" value="{{ ($errors->first('customer_error') || $errors->first('customer_error2') || $errors->first('customer_error3'))  ? (old('s_opt1') == null ? '' : old('s_opt1') ) :(old('s_opt1') == null ? (!empty($sales->Option1->op_name)?$sales->Option1->op_name:'') : old('s_opt1')) }}">                           
                            <div class="form-control wrapper-select {{ ($errors->first('customer_error')) ? 'is-invalid'  :'' }}">
                            <select class="select-shop2" name = "s_opts1">
                            <option value = ''></option>
                            @foreach($list_staff as $staff)
                            <option value = '{{$staff->s_id}}' {{   ($errors->first('customer_error') || $errors->first('customer_error2') || $errors->first('customer_error3'))  ? (old('s_opts1') == null ? '' : (old('s_opts1') == $staff->s_id ? 'selected' : '')) :  (old('s_opts1') == null ? ( $sales->s_opts1 == $staff->s_id ? 'selected' : '') : (old('s_opts1') == $staff->s_id ? 'selected' : '')) }}>
                            {{$staff->s_firstname}} {{$staff->s_lastname}}
                            </option>
                            @endforeach
                            </select>
                            </div>
                            <div class="invalid-feedback" style="margin-left: 59%;">
                                @if (($errors->first('customer_error')))
                                    {{ $errors->first('customer_error') }}
                                @endif
                            </div>   
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">サブ2</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "s_opt2" value="{{ ($errors->first('customer_error') || $errors->first('customer_error2') || $errors->first('customer_error3'))  ? (old('s_opt2') == null ? '' : old('s_opt2') ) :(old('s_opt2') == null ? (!empty($sales->Option2->op_name)?$sales->Option2->op_name:'') : old('s_opt2')) }}">
                            <div class="form-control wrapper-select {{ ($errors->first('customer_error2')) ? 'is-invalid'  :'' }}">
                            <select class="select-shop2" name = "s_opts2">
                            <option value = ''></option>
                            @foreach($list_staff as $staff)
                            <option value = '{{$staff->s_id}}'  {{   ($errors->first('customer_error') || $errors->first('customer_error2') || $errors->first('customer_error3'))  ? (old('s_opts2') == null ? '' : (old('s_opts2') == $staff->s_id ? 'selected' : '')) :  (old('s_opts2') == null ? ( $sales->s_opts2 == $staff->s_id ? 'selected' : '') : (old('s_opts2') == $staff->s_id ? 'selected' : '')) }}>
                            {{$staff->s_firstname}} {{$staff->s_lastname}}
                            </option>
                            @endforeach
                            </select>
                            </div>
                            <div class="invalid-feedback" style="margin-left: 59%;">
                                @if (($errors->first('customer_error2')))
                                    {{ $errors->first('customer_error2') }}
                                @endif
                            </div>   
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">サブ3</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "s_opt3" value="{{ ($errors->first('customer_error') || $errors->first('customer_error2') || $errors->first('customer_error3'))  ? (old('s_opt3') == null ? '' : old('s_opt3') ) :(old('s_opt3') == null ? (!empty($sales->Option3->op_name)?$sales->Option3->op_name:'') : old('s_opt3')) }}">
                            <div class="form-control wrapper-select {{ ($errors->first('customer_error3')) ? 'is-invalid'  :'' }}">
                            <select class="select-shop2" name = "s_opts3">
                            <option value = ''></option>
                            @foreach($list_staff as $staff)
                            <option value = '{{$staff->s_id}}'  {{   ($errors->first('customer_error') || $errors->first('customer_error2') || $errors->first('customer_error3'))  ? (old('s_opts3') == null ? '' : (old('s_opts3') == $staff->s_id ? 'selected' : '')) :  (old('s_opts3') == null ? ( $sales->s_opts3 == $staff->s_id ? 'selected' : '') : (old('s_opts3') == $staff->s_id ? 'selected' : '')) }}>
                            {{$staff->s_firstname}} {{$staff->s_lastname}}
                            </option>
                            @endforeach
                            </select>
                            </div>
                            <div class="invalid-feedback" style="margin-left: 59%;">
                                @if (($errors->first('customer_error3')))
                                    {{ $errors->first('customer_error3') }}
                                @endif
                            </div>   
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">金額</span>
                            </div>
                            <input type="text" readonly class="form-control" value="{{ old('s_money') == null ? ($sales->s_money) : old('s_money') }}" name="s_money">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">支払い方法</span>
                            </div>
                            <select class="form-control" name="s_pay">
                            
                                <option {{ old('s_pay') == null ? ($sales->s_pay == 0 ? 'selected' : '') : (old('s_pay') == 0 ? 'selected' : '') }} value ="0">キャッシュ</option>
                                <option {{ old('s_pay') == null ? ($sales->s_pay == 1 ? 'selected' : '') : (old('s_pay') == 1 ? 'selected' : '')}} value ="1">カード</option>
                            
                            
                            </select>
                        </div>
                    </div>
                  
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">備考</span>
                            </div>
                            <textarea maxlength="100" class="form-control" rows=4 name="s_text" >{{ old('s_text') == null ? ($sales->s_text) : old('s_text')  }}</textarea>
                        </div>
                    </div>
                    <!-- <input type="hidden" id="urlBack" name="urlBack" value="{{url()->previous()}}"> -->
                    <div class="clsCenter">
                    <button type="submit" class="btn btn-primary buttonSales btn-left-sales">更新</button>                    
                    <a role="button" href="{{ url('sales')}}" class="btn btn-secondary buttonSales" >キャンセル</a>
                    <div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
@endsection