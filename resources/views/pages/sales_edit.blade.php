@extends('master')
@section('title','売上管理編集')
@section('menu')
@parent
@endsection
@section('content')
</br>
    <div class="container" style="padding: 20px;">
        <div class="row">
            <div id="sales_new_edit_frm" class="col-10">
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
                            @php
                                $c_id = $sales->Customer->c_id;
                                if ($c_id < 10) {
                                    $c_id = '000' . $c_id;
                                } else {
                                    if ($c_id >= 10 && $c_id < 100) {
                                        $c_id = '00' . $c_id;
                                    }
                                    if ($c_id >= 100 && $c_id < 1000) {
                                        $c_id = '0' . $c_id;
                                    }
                                }
                            @endphp
                            <input type="hidden" id="save_s_c_id" name="save_s_c_id" value="{{ old('save_s_c_id') == null ? (!empty($sales->Customer->c_id)?($c_id .' - '.$sales->Customer->c_lastname.' '.$sales->Customer->c_firstname):'') : old('save_s_c_id') }}">
                            <input type="hidden" id="hid_s_c_id" name="s_c_id" value="{{ old('s_c_id') == null ? $sales->Customer->c_id : old('s_c_id') }}" onchange="onCustomerChange({{ $list_customer }})">
                            <input type="text" autocomplete="off" class="form-control {{ ($errors->first('s_c_id')) ? 'is-invalid'  :'' }}" id="input_s_c_id" name = "input_s_c_id" value="{{ old('input_s_c_id') == null ? (!empty($sales->Customer->c_id)?($c_id .' - '.$sales->Customer->c_lastname.' '.$sales->Customer->c_firstname):'') : old('input_s_c_id') }}">
                            <div id="countryList"></div>        

                            <div id="check_customer_list" class="invalid-feedback">
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

                    <div id="course_group_1" class="course_group">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">コース</span>
                                </div>
                                <div class="form-control wrapper-select {{ ($errors->first('s_co_id1')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name="s_co_id1" id ="s_co_id1" onchange="onCourseChange(1,'s_co_id1',{{ $list_course }},{{ $list_option }})">
                                        <option value = ''></option>
                                        @foreach($list_course as $course)
                                            <option value = '{{$course->co_id}}' {{ old('s_co_id1') == null ? ((isset($sale_details[0]->s_co_id) ? $sale_details[0]->s_co_id : '')  == $course->co_id ? 'selected' : '') : (old('s_co_id1') == $course->co_id ? 'selected' : '') }}>
                                                {{$course->co_name}}
                                            </option>
                                        @endforeach
                                        <option value = 0 {{ old('s_co_id1') == null ? ((isset($sale_details[0]->s_co_id) ? $sale_details[0]->s_co_id : '')  == '0' ? 'selected' : '') : (old('s_co_id1') == '0' ? 'selected' : '') }}>フリー</option>
                                        <option value = 9999 {{ old('s_co_id1') == null ? ((isset($sale_details[0]->s_co_id) ? $sale_details[0]->s_co_id : '')  == '9999' ? 'selected' : '') : (old('s_co_id1') == '9999' ? 'selected' : '') }}>商品販売</option>
                                    </select>
                                </div>
                                <div class="invalid-feedback">
                                    @error('s_co_id1')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細１</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt1_1" value="{{ (isset($sale_details[0]->s_co_id) ? $sale_details[0]->s_co_id : '-1')  == 0 ? 'フリー' : ( (isset($sale_details[0]->s_co_id) ? $sale_details[0]->s_co_id : '')  == 9999 ? '商品販売'  : (($errors->first('customer_error1_1') || $errors->first('customer_error2_1') || $errors->first('customer_error3_1') || $errors->first('customer_error4_1') || $errors->first('customer_error5_1'))  ? (old('s_opt1_1') == null ? '' : old('s_opt1_1') ) :(old('s_opt1_1') == null ? (!empty($sale_details[0]->Option1->op_name)?$sale_details[0]->Option1->op_name:'') : old('s_opt1_1')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error1_1')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts1_1">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{   ($errors->first('customer_error1_1') || $errors->first('customer_error2_1') || $errors->first('customer_error3_1') || $errors->first('customer_error4_1') || $errors->first('customer_error5_1'))  ? (old('s_opts1_1') == null ? '' : (old('s_opts1_1') == $staff->s_id ? 'selected' : '')) :  (old('s_opts1_1') == null ? ( (isset($sale_details[0]->s_opts1) ? $sale_details[0]->s_opts1 : '')  == $staff->s_id ? 'selected' : '') : (old('s_opts1_1') == $staff->s_id ? 'selected' : '')) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error1_1')))
                                        {{ $errors->first('customer_error1_1') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細２</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt2_1" value="{{ old('s_co_id1') == '0' ? '' : ( old('s_co_id1') == '9999' ? '商品販売'  :(($errors->first('customer_error1_1') || $errors->first('customer_error2_1') || $errors->first('customer_error3_1') || $errors->first('customer_error4_1') || $errors->first('customer_error5_1'))  ? (old('s_opt2_1') == null ? '' : old('s_opt2_1') ) :(old('s_opt2_1') == null ? (!empty($sale_details[0]->Option2->op_name)?$sale_details[0]->Option2->op_name:'') : old('s_opt2_1')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error2_1')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts2_1"{{ (isset($sale_details[0]->s_co_id) && ($sale_details[0]->s_co_id == 0 || $sale_details[0]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id1') == '0' ? '' : (($errors->first('customer_error1_1') || $errors->first('customer_error2_1') || $errors->first('customer_error3_1') || $errors->first('customer_error4_1') || $errors->first('customer_error5_1'))  ? (old('s_opts2_1') == null ? '' : (old('s_opts2_1') == $staff->s_id ? 'selected' : '')) :  (old('s_opts2_1') == null ? ( (isset($sale_details[0]->s_opts2) ? $sale_details[0]->s_opts2 : '') == $staff->s_id ? 'selected' : '') : (old('s_opts2_1') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error2_1')))
                                        {{ $errors->first('customer_error2_1') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細３</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt3_1" value="{{ old('s_co_id1') == '0' ? '' : ( old('s_co_id1') == '9999' ? '商品販売'  :(($errors->first('customer_error1_1') || $errors->first('customer_error2_1') || $errors->first('customer_error3_1') || $errors->first('customer_error4_1') || $errors->first('customer_error5_1'))  ? (old('s_opt3_1') == null ? '' : old('s_opt3_1') ) :(old('s_opt3_1') == null ? (!empty($sale_details[0]->Option3->op_name)?$sale_details[0]->Option3->op_name:'') : old('s_opt3_1')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error3_1')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts3_1"{{ (isset($sale_details[0]->s_co_id) && ($sale_details[0]->s_co_id == 0 || $sale_details[0]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id1') == '0' ? '' : (($errors->first('customer_error1_1') || $errors->first('customer_error2_1') || $errors->first('customer_error3_1') || $errors->first('customer_error4_1') || $errors->first('customer_error5_1'))  ? (old('s_opts3_1') == null ? '' : (old('s_opts3_1') == $staff->s_id ? 'selected' : '')) :  (old('s_opts3_1') == null ? ( (isset($sale_details[0]->s_opts3) ? $sale_details[0]->s_opts3 : '') == $staff->s_id ? 'selected' : '') : (old('s_opts3_1') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error3_1')))
                                        {{ $errors->first('customer_error3_1') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細４</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt4_1" value="{{ old('s_co_id1') == '0' ? '' : (old('s_co_id1') == '9999'? '商品販売'  :(($errors->first('customer_error1_1') || $errors->first('customer_error2_1') || $errors->first('customer_error3_1') || $errors->first('customer_error4_1') || $errors->first('customer_error5_1'))  ? (old('s_opt4_1') == null ? '' : old('s_opt4_1') ) :(old('s_opt4_1') == null ? (!empty($sale_details[0]->Option4->op_name)?$sale_details[0]->Option4->op_name:'') : old('s_opt4_1')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error4_1')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts4_1"{{ (isset($sale_details[0]->s_co_id) && ($sale_details[0]->s_co_id == 0 || $sale_details[0]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id1') == '0' ? '' : (($errors->first('customer_error1_1') || $errors->first('customer_error2_1') || $errors->first('customer_error3_1') || $errors->first('customer_error4_1') || $errors->first('customer_error5_1'))  ? (old('s_opts4_1') == null ? '' : (old('s_opts4_1') == $staff->s_id ? 'selected' : '')) :  (old('s_opts4_1') == null ? ( (isset($sale_details[0]->s_opts4) ? $sale_details[0]->s_opts4 : '') == $staff->s_id ? 'selected' : '') : (old('s_opts4_1') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error4_1')))
                                        {{ $errors->first('customer_error4_1') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細５</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt5_1" value="{{ old('s_co_id1') == '0' ? '' : (old('s_co_id1') == '9999' ? '商品販売'  :(($errors->first('customer_error1_1') || $errors->first('customer_error2_1') || $errors->first('customer_error3_1') || $errors->first('customer_error4_1') || $errors->first('customer_error5_1'))  ? (old('s_opt5_1') == null ? '' : old('s_opt5_1') ) :(old('s_opt5_1') == null ? (!empty($sale_details[0]->Option5->op_name)?$sale_details[0]->Option5->op_name:'') : old('s_opt5_1')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error5_1')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts5_1"{{ (isset($sale_details[0]->s_co_id) && ($sale_details[0]->s_co_id == 0 || $sale_details[0]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id1') == '0' ? '' : (($errors->first('customer_error1_1') || $errors->first('customer_error2_1') || $errors->first('customer_error3_1') || $errors->first('customer_error4_1') || $errors->first('customer_error5_1'))  ? (old('s_opts5_1') == null ? '' : (old('s_opts5_1') == $staff->s_id ? 'selected' : '')) :  (old('s_opts5_1') == null ? ( (isset($sale_details[0]->s_opts5) ? $sale_details[0]->s_opts5 : '')== $staff->s_id ? 'selected' : '') : (old('s_opts5_1') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error5_1')))
                                        {{ $errors->first('customer_error5_1') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">コース金額</span>
                                </div>
                                <input type="text" id="s_money_1"  class="form-control {{ ($errors->first('s_money_1')) ? 'is-invalid': ''}}" value="{{ old('s_money_1') == null ? (number_format((isset($sale_details[0]->s_money) ? $sale_details[0]->s_money : 0))) : old('s_money_1') }}" name="s_money_1" {{ old('s_co_id1') == null ? (((isset($sale_details[0]->s_co_id) ? $sale_details[0]->s_co_id : '') == '0' || (isset($sale_details[0]->s_co_id) ? $sale_details[0]->s_co_id : '') == '9999') ? '' : 'readonly') : ((old('s_co_id1') == '0' || old('s_co_id1') == '9999') ? '' : 'readonly')}}>
                                <input type="hidden" id="s_money-hidden_1" name="s_money-hidden_1" value="{{ old('s_money-hidden_1') == null ? (isset($sale_details[0]->s_money) ? $sale_details[0]->s_money : '') : old('s_money-hidden_1') }}">
                                <div class="invalid-feedback">
                                    @error('s_money_1')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="course_group_2" class="course_group" style="display: {{ old('hd-block') > 1 ? 'block' : ($total_detail > 1 ? 'block' : 'none') }}">
                        <div class="form-group">
                            <span class="pull-right btn-remove-course"><i class="fa fa-remove"></i></span>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">コース</span>
                                </div>
                                <div class="form-control wrapper-select {{ ($errors->first('s_co_id2')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name="s_co_id2" id ="s_co_id2" onchange="onCourseChange(2,'s_co_id2',{{ $list_course }},{{ $list_option }})">
                                        <option value = ''></option>
                                        @foreach($list_course as $course)
                                            <option value = '{{$course->co_id}}' {{ old('s_co_id2') == null ? ((isset($sale_details[1]->s_co_id) ? $sale_details[1]->s_co_id : '')  == $course->co_id ? 'selected' : '') : (old('s_co_id2') == $course->co_id ? 'selected' : '') }}>
                                                {{$course->co_name}}
                                            </option>
                                        @endforeach
                                        <option value = 0 {{ old('s_co_id2') == null ? ((isset($sale_details[1]->s_co_id) ? $sale_details[1]->s_co_id : '-1')  == '0' ? 'selected' : '') : (old('s_co_id2') == '0' ? 'selected' : '') }}>フリー</option>
                                        <option value = 9999 {{ old('s_co_id2') == null ? ((isset($sale_details[1]->s_co_id) ? $sale_details[1]->s_co_id : '')  == '9999' ? 'selected' : '') : (old('s_co_id2') == '9999' ? 'selected' : '') }}>商品販売</option>
                                    </select>
                                </div>
                                <div class="invalid-feedback">
                                    @error('s_co_id2')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細１</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt1_2" value="{{ (isset($sale_details[1]->s_co_id) ? $sale_details[1]->s_co_id : '-1')  == 0 ? 'フリー' : ( (isset($sale_details[1]->s_co_id) ? $sale_details[1]->s_co_id : '')  == 9999 ? '商品販売'  : (($errors->first('customer_error1_2') || $errors->first('customer_error2_2') || $errors->first('customer_error3_2') || $errors->first('customer_error4_2') || $errors->first('customer_error5_2'))  ? (old('s_opt1_2') == null ? '' : old('s_opt1_2') ) :(old('s_opt1_2') == null ? (!empty($sale_details[1]->Option1->op_name)?$sale_details[1]->Option1->op_name:'') : old('s_opt1_2')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error1_2')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts1_2">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{   ($errors->first('customer_error1_2') || $errors->first('customer_error2_2') || $errors->first('customer_error3_2') || $errors->first('customer_error4_2') || $errors->first('customer_error5_2'))  ? (old('s_opts1_2') == null ? '' : (old('s_opts1_2') == $staff->s_id ? 'selected' : '')) :  (old('s_opts1_2') == null ? ( (isset($sale_details[1]->s_opts1) ? $sale_details[1]->s_opts1 : '')  == $staff->s_id ? 'selected' : '') : (old('s_opts1_2') == $staff->s_id ? 'selected' : '')) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error1_2')))
                                        {{ $errors->first('customer_error1_2') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細２</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt2_2" value="{{ old('s_co_id2') == '0' ? '' : ( old('s_co_id2') == '9999' ? '商品販売'  :(($errors->first('customer_error1_2') || $errors->first('customer_error2_2') || $errors->first('customer_error3_2') || $errors->first('customer_error4_2') || $errors->first('customer_error5_2'))  ? (old('s_opt2_2') == null ? '' : old('s_opt2_2') ) :(old('s_opt2_2') == null ? (!empty($sale_details[1]->Option2->op_name)?$sale_details[1]->Option2->op_name:'') : old('s_opt2_2')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error2_2')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts2_2"{{ (isset($sale_details[1]->s_co_id) && ($sale_details[1]->s_co_id == 0 || $sale_details[1]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id2') == '0' ? '' : (($errors->first('customer_error1_2') || $errors->first('customer_error2_2') || $errors->first('customer_error3_2') || $errors->first('customer_error4_2') || $errors->first('customer_error5_2'))  ? (old('s_opts2_2') == null ? '' : (old('s_opts2_2') == $staff->s_id ? 'selected' : '')) :  (old('s_opts2_2') == null ? ( (isset($sale_details[1]->s_opts2) ? $sale_details[1]->s_opts2 : '') == $staff->s_id ? 'selected' : '') : (old('s_opts2_2') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error2_2')))
                                        {{ $errors->first('customer_error2_2') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細３</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt3_2" value="{{ old('s_co_id2') == '0' ? '' : ( old('s_co_id2') == '9999' ? '商品販売'  :(($errors->first('customer_error1_2') || $errors->first('customer_error2_2') || $errors->first('customer_error3_2') || $errors->first('customer_error4_2') || $errors->first('customer_error5_2'))  ? (old('s_opt3_2') == null ? '' : old('s_opt3_2') ) :(old('s_opt3_2') == null ? (!empty($sale_details[1]->Option3->op_name)?$sale_details[1]->Option3->op_name:'') : old('s_opt3_2')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error3_2')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts3_2"{{ (isset($sale_details[1]->s_co_id) && ($sale_details[1]->s_co_id == 0 || $sale_details[1]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id2') == '0' ? '' : (($errors->first('customer_error1_2') || $errors->first('customer_error2_2') || $errors->first('customer_error3_2') || $errors->first('customer_error4_2') || $errors->first('customer_error5_2'))  ? (old('s_opts3_2') == null ? '' : (old('s_opts3_2') == $staff->s_id ? 'selected' : '')) :  (old('s_opts3_2') == null ? ( (isset($sale_details[1]->s_opts3) ? $sale_details[1]->s_opts3 : '') == $staff->s_id ? 'selected' : '') : (old('s_opts3_2') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error3_2')))
                                        {{ $errors->first('customer_error3_2') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細４</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt4_2" value="{{ old('s_co_id2') == '0' ? '' : (old('s_co_id2') == '9999'? '商品販売'  :(($errors->first('customer_error1_2') || $errors->first('customer_error2_2') || $errors->first('customer_error3_2') || $errors->first('customer_error4_2') || $errors->first('customer_error5_2'))  ? (old('s_opt4_2') == null ? '' : old('s_opt4_2') ) :(old('s_opt4_2') == null ? (!empty($sale_details[1]->Option4->op_name)?$sale_details[1]->Option4->op_name:'') : old('s_opt4_2')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error4_2')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts4_2"{{ (isset($sale_details[1]->s_co_id) && ($sale_details[1]->s_co_id == 0 || $sale_details[1]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id2') == '0' ? '' : (($errors->first('customer_error1_2') || $errors->first('customer_error2_2') || $errors->first('customer_error3_2') || $errors->first('customer_error4_2') || $errors->first('customer_error5_2'))  ? (old('s_opts4_2') == null ? '' : (old('s_opts4_2') == $staff->s_id ? 'selected' : '')) :  (old('s_opts4_2') == null ? ( (isset($sale_details[1]->s_opts4) ? $sale_details[1]->s_opts4 : '') == $staff->s_id ? 'selected' : '') : (old('s_opts4_2') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error4_2')))
                                        {{ $errors->first('customer_error4_2') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細５</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt5_2" value="{{ old('s_co_id2') == '0' ? '' : (old('s_co_id2') == '9999' ? '商品販売'  :(($errors->first('customer_error1_2') || $errors->first('customer_error2_2') || $errors->first('customer_error3_2') || $errors->first('customer_error4_2') || $errors->first('customer_error5_2'))  ? (old('s_opt5_2') == null ? '' : old('s_opt5_2') ) :(old('s_opt5_2') == null ? (!empty($sale_details[1]->Option5->op_name)?$sale_details[1]->Option5->op_name:'') : old('s_opt5_2')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error5_2')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts5_2"{{ (isset($sale_details[1]->s_co_id) && ($sale_details[1]->s_co_id == 0 || $sale_details[1]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id2') == '0' ? '' : (($errors->first('customer_error1_2') || $errors->first('customer_error2_2') || $errors->first('customer_error3_2') || $errors->first('customer_error4_2') || $errors->first('customer_error5_2'))  ? (old('s_opts5_2') == null ? '' : (old('s_opts5_2') == $staff->s_id ? 'selected' : '')) :  (old('s_opts5_2') == null ? ( (isset($sale_details[1]->s_opts5) ? $sale_details[1]->s_opts5 : '')== $staff->s_id ? 'selected' : '') : (old('s_opts5_2') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error5_2')))
                                        {{ $errors->first('customer_error5_2') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">コース金額</span>
                                </div>
                                <input type="text" id="s_money_2"  class="form-control {{ ($errors->first('s_money_2')) ? 'is-invalid': ''}}" value="{{ old('s_money_2') == null ? ((isset($sale_details[1]->s_money) ? number_format($sale_details[1]->s_money) : '')) : old('s_money_2') }}" name="s_money_2" {{ old('s_co_id2') == null ? (((isset($sale_details[1]->s_co_id) ? $sale_details[1]->s_co_id : '') == '0' || (isset($sale_details[1]->s_co_id) ? $sale_details[1]->s_co_id : '') == '9999')  ? '' : 'readonly') : ((old('s_co_id2') == '0' || old('s_co_id2') == '9999') ? '' : 'readonly')}}>
                                <input type="hidden" id="s_money-hidden_2" name="s_money-hidden_2" value="{{ old('s_money-hidden_2') == null ? (isset($sale_details[1]->s_money) ? $sale_details[1]->s_money : '') : old('s_money-hidden_2') }}">
                                <div class="invalid-feedback">
                                    @error('s_money_2')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="course_group_3" class="course_group mt-3" style="display: {{ old('hd-block') > 2 ? 'block' : ($total_detail > 2 ? 'block' : 'none') }}">
                        <div class="form-group">
                            <span class="pull-right btn-remove-course"><i class="fa fa-remove"></i></span>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">コース</span>
                                </div>
                                <div class="form-control wrapper-select {{ ($errors->first('s_co_id3')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name="s_co_id3" id ="s_co_id3" onchange="onCourseChange(3,'s_co_id3',{{ $list_course }},{{ $list_option }})">
                                        <option value = ''></option>
                                        @foreach($list_course as $course)
                                            <option value = '{{$course->co_id}}' {{ old('s_co_id3') == null ? ((isset($sale_details[2]->s_co_id) ? $sale_details[2]->s_co_id : '')  == $course->co_id ? 'selected' : '') : (old('s_co_id3') == $course->co_id ? 'selected' : '') }}>
                                                {{$course->co_name}}
                                            </option>
                                        @endforeach
                                        <option value = 0 {{ old('s_co_id3') == null ? ((isset($sale_details[2]->s_co_id) ? $sale_details[2]->s_co_id : '')  == '0' ? 'selected' : '') : (old('s_co_id3') == '0' ? 'selected' : '') }}>フリー</option>
                                        <option value = 9999 {{ old('s_co_id3') == null ? ((isset($sale_details[2]->s_co_id) ? $sale_details[2]->s_co_id : '')  == '9999' ? 'selected' : '') : (old('s_co_id3') == '9999' ? 'selected' : '') }}>商品販売</option>
                                    </select>
                                </div>
                                <div class="invalid-feedback">
                                    @error('s_co_id3')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細１</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt1_3" value="{{ (isset($sale_details[2]->s_co_id) ? $sale_details[2]->s_co_id : '-1')  == 0 ? 'フリー' : ( (isset($sale_details[2]->s_co_id) ? $sale_details[2]->s_co_id : '')  == 9999 ? '商品販売'  : (($errors->first('customer_error1_3') || $errors->first('customer_error2_3') || $errors->first('customer_error3_3') || $errors->first('customer_error4_3') || $errors->first('customer_error5_3'))  ? (old('s_opt1_3') == null ? '' : old('s_opt1_3') ) :(old('s_opt1_3') == null ? (!empty($sale_details[2]->Option1->op_name)?$sale_details[2]->Option1->op_name:'') : old('s_opt1_3')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error1_3')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts1_3">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{   ($errors->first('customer_error1_3') || $errors->first('customer_error2_3') || $errors->first('customer_error3_3') || $errors->first('customer_error4_3') || $errors->first('customer_error5_3'))  ? (old('s_opts1_3') == null ? '' : (old('s_opts1_3') == $staff->s_id ? 'selected' : '')) :  (old('s_opts1_3') == null ? ( (isset($sale_details[2]->s_opts1) ? $sale_details[2]->s_opts1 : '')  == $staff->s_id ? 'selected' : '') : (old('s_opts1_3') == $staff->s_id ? 'selected' : '')) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error1_3')))
                                        {{ $errors->first('customer_error1_3') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細２</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt2_3" value="{{ old('s_co_id3') == '0' ? '' : ( old('s_co_id3') == '9999' ? '商品販売'  :(($errors->first('customer_error1_3') || $errors->first('customer_error2_3') || $errors->first('customer_error3_3') || $errors->first('customer_error4_3') || $errors->first('customer_error5_3'))  ? (old('s_opt2_3') == null ? '' : old('s_opt2_3') ) :(old('s_opt2_3') == null ? (!empty($sale_details[2]->Option2->op_name)?$sale_details[2]->Option2->op_name:'') : old('s_opt2_3')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error2_3')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts2_3"{{ (isset($sale_details[2]->s_co_id) && ($sale_details[2]->s_co_id == 0 || $sale_details[2]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id3') == '0' ? '' : (($errors->first('customer_error1_3') || $errors->first('customer_error2_3') || $errors->first('customer_error3_3') || $errors->first('customer_error4_3') || $errors->first('customer_error5_3'))  ? (old('s_opts2_3') == null ? '' : (old('s_opts2_3') == $staff->s_id ? 'selected' : '')) :  (old('s_opts2_3') == null ? ( (isset($sale_details[2]->s_opts2) ? $sale_details[2]->s_opts2 : '') == $staff->s_id ? 'selected' : '') : (old('s_opts2_3') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error2_3')))
                                        {{ $errors->first('customer_error2_3') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細３</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt3_3" value="{{ old('s_co_id3') == '0' ? '' : ( old('s_co_id3') == '9999' ? '商品販売'  :(($errors->first('customer_error1_3') || $errors->first('customer_error2_3') || $errors->first('customer_error3_3') || $errors->first('customer_error4_3') || $errors->first('customer_error5_3'))  ? (old('s_opt3_3') == null ? '' : old('s_opt3_3') ) :(old('s_opt3_3') == null ? (!empty($sale_details[2]->Option3->op_name)?$sale_details[2]->Option3->op_name:'') : old('s_opt3_3')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error3_3')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts3_3"{{ (isset($sale_details[2]->s_co_id) && ($sale_details[2]->s_co_id == 0 || $sale_details[2]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id3') == '0' ? '' : (($errors->first('customer_error1_3') || $errors->first('customer_error2_3') || $errors->first('customer_error3_3') || $errors->first('customer_error4_3') || $errors->first('customer_error5_3'))  ? (old('s_opts3_3') == null ? '' : (old('s_opts3_3') == $staff->s_id ? 'selected' : '')) :  (old('s_opts3_3') == null ? ( (isset($sale_details[2]->s_opts3) ? $sale_details[2]->s_opts3 : '') == $staff->s_id ? 'selected' : '') : (old('s_opts3_3') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error3_3')))
                                        {{ $errors->first('customer_error3_3') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細４</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt4_3" value="{{ old('s_co_id3') == '0' ? '' : (old('s_co_id3') == '9999'? '商品販売'  :(($errors->first('customer_error1_3') || $errors->first('customer_error2_3') || $errors->first('customer_error3_3') || $errors->first('customer_error4_3') || $errors->first('customer_error5_3'))  ? (old('s_opt4_3') == null ? '' : old('s_opt4_3') ) :(old('s_opt4_3') == null ? (!empty($sale_details[2]->Option4->op_name)?$sale_details[2]->Option4->op_name:'') : old('s_opt4_3')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error4_3')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts4_3"{{ (isset($sale_details[2]->s_co_id) && ($sale_details[2]->s_co_id == 0 || $sale_details[2]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id3') == '0' ? '' : (($errors->first('customer_error1_3') || $errors->first('customer_error2_3') || $errors->first('customer_error3_3') || $errors->first('customer_error4_3') || $errors->first('customer_error5_3'))  ? (old('s_opts4_3') == null ? '' : (old('s_opts4_3') == $staff->s_id ? 'selected' : '')) :  (old('s_opts4_3') == null ? ( (isset($sale_details[2]->s_opts4) ? $sale_details[2]->s_opts4 : '') == $staff->s_id ? 'selected' : '') : (old('s_opts4_3') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error4_3')))
                                        {{ $errors->first('customer_error4_3') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細５</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt5_3" value="{{ old('s_co_id3') == '0' ? '' : (old('s_co_id3') == '9999' ? '商品販売'  :(($errors->first('customer_error1_3') || $errors->first('customer_error2_3') || $errors->first('customer_error3_3') || $errors->first('customer_error4_3') || $errors->first('customer_error5_3'))  ? (old('s_opt5_3') == null ? '' : old('s_opt5_3') ) :(old('s_opt5_3') == null ? (!empty($sale_details[2]->Option5->op_name)?$sale_details[2]->Option5->op_name:'') : old('s_opt5_3')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error5_3')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts5_3"{{ (isset($sale_details[2]->s_co_id) && ($sale_details[2]->s_co_id == 0 || $sale_details[2]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id3') == '0' ? '' : (($errors->first('customer_error1_3') || $errors->first('customer_error2_3') || $errors->first('customer_error3_3') || $errors->first('customer_error4_3') || $errors->first('customer_error5_3'))  ? (old('s_opts5_3') == null ? '' : (old('s_opts5_3') == $staff->s_id ? 'selected' : '')) :  (old('s_opts5_3') == null ? ( (isset($sale_details[2]->s_opts5) ? $sale_details[2]->s_opts5 : '')== $staff->s_id ? 'selected' : '') : (old('s_opts5_3') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error5_3')))
                                        {{ $errors->first('customer_error5_3') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">コース金額</span>
                                </div>
                                <input type="text" id="s_money_3"  class="form-control {{ ($errors->first('s_money_3')) ? 'is-invalid': ''}}" value="{{ old('s_money_3') == null ? ((isset($sale_details[2]->s_money) ? number_format($sale_details[2]->s_money) : '')) : old('s_money_3') }}" name="s_money_3" {{ old('s_co_id3') == null ? (((isset($sale_details[2]->s_co_id) ? $sale_details[2]->s_co_id : '') == '0' || (isset($sale_details[2]->s_co_id) ? $sale_details[2]->s_co_id : '') == '9999') ? '' : 'readonly') : ((old('s_co_id3') == '0' || old('s_co_id3') == '9999') ? '' : 'readonly')}}>
                                <input type="hidden" id="s_money-hidden_3" name="s_money-hidden_3" value="{{ old('s_money-hidden_3') == null ? (isset($sale_details[2]->s_money) ? $sale_details[2]->s_money : '') : old('s_money-hidden_3') }}">
                                <div class="invalid-feedback">
                                    @error('s_money_3')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="course_group_4" class="course_group mt-3" style="display: {{ old('hd-block') > 3 ? 'block' : ($total_detail > 3 ? 'block' : 'none') }}">
                        <div class="form-group">
                            <span class="pull-right btn-remove-course"><i class="fa fa-remove"></i></span>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">コース</span>
                                </div>
                                <div class="form-control wrapper-select {{ ($errors->first('s_co_id4')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name="s_co_id4" id ="s_co_id4" onchange="onCourseChange(4,'s_co_id4',{{ $list_course }},{{ $list_option }})">
                                        <option value = ''></option>
                                        @foreach($list_course as $course)
                                            <option value = '{{$course->co_id}}' {{ old('s_co_id4') == null ? ((isset($sale_details[3]->s_co_id) ? $sale_details[3]->s_co_id : '')  == $course->co_id ? 'selected' : '') : (old('s_co_id4') == $course->co_id ? 'selected' : '') }}>
                                                {{$course->co_name}}
                                            </option>
                                        @endforeach
                                        <option value = 0 {{ old('s_co_id4') == null ? ((isset($sale_details[3]->s_co_id) ? $sale_details[3]->s_co_id : '')  == '0' ? 'selected' : '') : (old('s_co_id4') == '0' ? 'selected' : '') }}>フリー</option>
                                        <option value = 9999 {{ old('s_co_id4') == null ? ((isset($sale_details[3]->s_co_id) ? $sale_details[3]->s_co_id : '')  == '9999' ? 'selected' : '') : (old('s_co_id4') == '9999' ? 'selected' : '') }}>商品販売</option>
                                    </select>
                                </div>
                                <div class="invalid-feedback">
                                    @error('s_co_id4')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細１</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt1_4" value="{{ (isset($sale_details[3]->s_co_id) ? $sale_details[3]->s_co_id : '-1')  == 0 ? 'フリー' : ( (isset($sale_details[3]->s_co_id) ? $sale_details[3]->s_co_id : '')  == 9999 ? '商品販売'  : (($errors->first('customer_error1_4') || $errors->first('customer_error2_4') || $errors->first('customer_error3_4') || $errors->first('customer_error4_4') || $errors->first('customer_error5_4'))  ? (old('s_opt1_4') == null ? '' : old('s_opt1_4') ) :(old('s_opt1_4') == null ? (!empty($sale_details[3]->Option1->op_name)?$sale_details[3]->Option1->op_name:'') : old('s_opt1_4')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error1_4')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts1_4">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{   ($errors->first('customer_error1_4') || $errors->first('customer_error2_4') || $errors->first('customer_error3_4') || $errors->first('customer_error4_4') || $errors->first('customer_error5_4'))  ? (old('s_opts1_4') == null ? '' : (old('s_opts1_4') == $staff->s_id ? 'selected' : '')) :  (old('s_opts1_4') == null ? ( (isset($sale_details[3]->s_opts1) ? $sale_details[3]->s_opts1 : '')  == $staff->s_id ? 'selected' : '') : (old('s_opts1_4') == $staff->s_id ? 'selected' : '')) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error1_4')))
                                        {{ $errors->first('customer_error1_4') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細２</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt2_4" value="{{ old('s_co_id4') == '0' ? '' : ( old('s_co_id4') == '9999' ? '商品販売'  :(($errors->first('customer_error1_4') || $errors->first('customer_error2_4') || $errors->first('customer_error3_4') || $errors->first('customer_error4_4') || $errors->first('customer_error5_4'))  ? (old('s_opt2_4') == null ? '' : old('s_opt2_4') ) :(old('s_opt2_4') == null ? (!empty($sale_details[3]->Option2->op_name)?$sale_details[3]->Option2->op_name:'') : old('s_opt2_4')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error2_4')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts2_4"{{ (isset($sale_details[3]->s_co_id) && ($sale_details[3]->s_co_id == 0 || $sale_details[3]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id4') == '0' ? '' : (($errors->first('customer_error1_4') || $errors->first('customer_error2_4') || $errors->first('customer_error3_4') || $errors->first('customer_error4_4') || $errors->first('customer_error5_4'))  ? (old('s_opts2_4') == null ? '' : (old('s_opts2_4') == $staff->s_id ? 'selected' : '')) :  (old('s_opts2_4') == null ? ( (isset($sale_details[3]->s_opts2) ? $sale_details[3]->s_opts2 : '') == $staff->s_id ? 'selected' : '') : (old('s_opts2_4') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error2_4')))
                                        {{ $errors->first('customer_error2_4') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細３</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt3_4" value="{{ old('s_co_id4') == '0' ? '' : ( old('s_co_id4') == '9999' ? '商品販売'  :(($errors->first('customer_error1_4') || $errors->first('customer_error2_4') || $errors->first('customer_error3_4') || $errors->first('customer_error4_4') || $errors->first('customer_error5_4'))  ? (old('s_opt3_4') == null ? '' : old('s_opt3_4') ) :(old('s_opt3_4') == null ? (!empty($sale_details[3]->Option3->op_name)?$sale_details[3]->Option3->op_name:'') : old('s_opt3_4')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error3_4')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts3_4"{{ (isset($sale_details[3]->s_co_id) && ($sale_details[3]->s_co_id == 0 || $sale_details[3]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id4') == '0' ? '' : (($errors->first('customer_error1_4') || $errors->first('customer_error2_4') || $errors->first('customer_error3_4') || $errors->first('customer_error4_4') || $errors->first('customer_error5_4'))  ? (old('s_opts3_4') == null ? '' : (old('s_opts3_4') == $staff->s_id ? 'selected' : '')) :  (old('s_opts3_4') == null ? ( (isset($sale_details[3]->s_opts3) ? $sale_details[3]->s_opts3 : '') == $staff->s_id ? 'selected' : '') : (old('s_opts3_4') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error3_4')))
                                        {{ $errors->first('customer_error3_4') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細４</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt4_4" value="{{ old('s_co_id4') == '0' ? '' : (old('s_co_id4') == '9999'? '商品販売'  :(($errors->first('customer_error1_4') || $errors->first('customer_error2_4') || $errors->first('customer_error3_4') || $errors->first('customer_error4_4') || $errors->first('customer_error5_4'))  ? (old('s_opt4_4') == null ? '' : old('s_opt4_4') ) :(old('s_opt4_4') == null ? (!empty($sale_details[3]->Option4->op_name)?$sale_details[3]->Option4->op_name:'') : old('s_opt4_4')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error4_4')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts4_4"{{ (isset($sale_details[3]->s_co_id) && ($sale_details[3]->s_co_id == 0 || $sale_details[3]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id4') == '0' ? '' : (($errors->first('customer_error1_4') || $errors->first('customer_error2_4') || $errors->first('customer_error3_4') || $errors->first('customer_error4_4') || $errors->first('customer_error5_4'))  ? (old('s_opts4_4') == null ? '' : (old('s_opts4_4') == $staff->s_id ? 'selected' : '')) :  (old('s_opts4_4') == null ? ( (isset($sale_details[3]->s_opts4) ? $sale_details[3]->s_opts4 : '') == $staff->s_id ? 'selected' : '') : (old('s_opts4_4') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error4_4')))
                                        {{ $errors->first('customer_error4_4') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細５</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt5_4" value="{{ old('s_co_id4') == '0' ? '' : (old('s_co_id4') == '9999' ? '商品販売'  :(($errors->first('customer_error1_4') || $errors->first('customer_error2_4') || $errors->first('customer_error3_4') || $errors->first('customer_error4_4') || $errors->first('customer_error5_4'))  ? (old('s_opt5_4') == null ? '' : old('s_opt5_4') ) :(old('s_opt5_4') == null ? (!empty($sale_details[3]->Option5->op_name)?$sale_details[3]->Option5->op_name:'') : old('s_opt5_4')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error5_4')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts5_4"{{ (isset($sale_details[3]->s_co_id) && ($sale_details[3]->s_co_id == 0 || $sale_details[3]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id4') == '0' ? '' : (($errors->first('customer_error1_4') || $errors->first('customer_error2_4') || $errors->first('customer_error3_4') || $errors->first('customer_error4_4') || $errors->first('customer_error5_4'))  ? (old('s_opts5_4') == null ? '' : (old('s_opts5_4') == $staff->s_id ? 'selected' : '')) :  (old('s_opts5_4') == null ? ( (isset($sale_details[3]->s_opts5) ? $sale_details[3]->s_opts5 : '')== $staff->s_id ? 'selected' : '') : (old('s_opts5_4') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error5_4')))
                                        {{ $errors->first('customer_error5_4') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">コース金額</span>
                                </div>
                                <input type="text" id="s_money_4"  class="form-control {{ ($errors->first('s_money_4')) ? 'is-invalid': ''}}" value="{{ old('s_money_4') == null ? ((isset($sale_details[3]->s_money) ? number_format($sale_details[3]->s_money) : '')) : old('s_money_4') }}" name="s_money_4" {{ old('s_co_id4') == null ? (((isset($sale_details[3]->s_co_id) ? $sale_details[3]->s_co_id : '') == '0' || (isset($sale_details[3]->s_co_id) ? $sale_details[3]->s_co_id : '') == '9999') ? '' : 'readonly') : ((old('s_co_id4') == '0' || old('s_co_id4') == '9999') ? '' : 'readonly')}}>
                                <input type="hidden" id="s_money-hidden_4" name="s_money-hidden_4" value="{{ old('s_money-hidden_4') == null ? (isset($sale_details[3]->s_money) ? $sale_details[3]->s_money : '') : old('s_money-hidden_4') }}">
                                <div class="invalid-feedback">
                                    @error('s_money_4')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="course_group_5" class="course_group mt-3 mb-3" style="display: {{ old('hd-block') > 4 ? 'block' : ($total_detail > 4 ? 'block' : 'none') }}">
                        <div class="form-group">
                            <span class="pull-right btn-remove-course"><i class="fa fa-remove"></i></span>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">コース</span>
                                </div>
                                <div class="form-control wrapper-select {{ ($errors->first('s_co_id5')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name="s_co_id5" id ="s_co_id5" onchange="onCourseChange(5,'s_co_id5',{{ $list_course }},{{ $list_option }})">
                                        <option value = ''></option>
                                        @foreach($list_course as $course)
                                            <option value = '{{$course->co_id}}' {{ old('s_co_id5') == null ? ((isset($sale_details[4]->s_co_id) ? $sale_details[4]->s_co_id : '')  == $course->co_id ? 'selected' : '') : (old('s_co_id5') == $course->co_id ? 'selected' : '') }}>
                                                {{$course->co_name}}
                                            </option>
                                        @endforeach
                                        <option value = 0 {{ old('s_co_id5') == null ? ((isset($sale_details[4]->s_co_id) ? $sale_details[4]->s_co_id : '')  == '0' ? 'selected' : '') : (old('s_co_id5') == '0' ? 'selected' : '') }}>フリー</option>
                                        <option value = 9999 {{ old('s_co_id5') == null ? ((isset($sale_details[4]->s_co_id) ? $sale_details[4]->s_co_id : '')  == '9999' ? 'selected' : '') : (old('s_co_id5') == '9999' ? 'selected' : '') }}>商品販売</option>
                                    </select>
                                </div>
                                <div class="invalid-feedback">
                                    @error('s_co_id5')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細１</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt1_5" value="{{ (isset($sale_details[4]->s_co_id) ? $sale_details[4]->s_co_id : '-1')  == 0 ? 'フリー' : ( (isset($sale_details[4]->s_co_id) ? $sale_details[4]->s_co_id : '')  == 9999 ? '商品販売'  : (($errors->first('customer_error1_5') || $errors->first('customer_error2_5') || $errors->first('customer_error3_5') || $errors->first('customer_error4_5') || $errors->first('customer_error5_5'))  ? (old('s_opt1_5') == null ? '' : old('s_opt1_5') ) :(old('s_opt1_5') == null ? (!empty($sale_details[4]->Option1->op_name)?$sale_details[4]->Option1->op_name:'') : old('s_opt1_5')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error1_5')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts1_5">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{   ($errors->first('customer_error1_5') || $errors->first('customer_error2_5') || $errors->first('customer_error3_5') || $errors->first('customer_error4_5') || $errors->first('customer_error5_5'))  ? (old('s_opts1_5') == null ? '' : (old('s_opts1_5') == $staff->s_id ? 'selected' : '')) :  (old('s_opts1_5') == null ? ( (isset($sale_details[4]->s_opts1) ? $sale_details[4]->s_opts1 : '')  == $staff->s_id ? 'selected' : '') : (old('s_opts1_5') == $staff->s_id ? 'selected' : '')) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error1_5')))
                                        {{ $errors->first('customer_error1_5') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細２</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt2_5" value="{{ old('s_co_id5') == '0' ? '' : ( old('s_co_id5') == '9999' ? '商品販売'  :(($errors->first('customer_error1_5') || $errors->first('customer_error2_5') || $errors->first('customer_error3_5') || $errors->first('customer_error4_5') || $errors->first('customer_error5_5'))  ? (old('s_opt2_5') == null ? '' : old('s_opt2_5') ) :(old('s_opt2_5') == null ? (!empty($sale_details[4]->Option2->op_name)?$sale_details[4]->Option2->op_name:'') : old('s_opt2_5')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error2_5')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts2_5"{{ (isset($sale_details[4]->s_co_id) && ($sale_details[4]->s_co_id == 0 || $sale_details[4]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id5') == '0' ? '' : (($errors->first('customer_error1_5') || $errors->first('customer_error2_5') || $errors->first('customer_error3_5') || $errors->first('customer_error4_5') || $errors->first('customer_error5_5'))  ? (old('s_opts2_5') == null ? '' : (old('s_opts2_5') == $staff->s_id ? 'selected' : '')) :  (old('s_opts2_5') == null ? ( (isset($sale_details[4]->s_opts2) ? $sale_details[4]->s_opts2 : '') == $staff->s_id ? 'selected' : '') : (old('s_opts2_5') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error2_5')))
                                        {{ $errors->first('customer_error2_5') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細３</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt3_5" value="{{ old('s_co_id5') == '0' ? '' : ( old('s_co_id5') == '9999' ? '商品販売'  :(($errors->first('customer_error1_5') || $errors->first('customer_error2_5') || $errors->first('customer_error3_5') || $errors->first('customer_error4_5') || $errors->first('customer_error5_5'))  ? (old('s_opt3_5') == null ? '' : old('s_opt3_5') ) :(old('s_opt3_5') == null ? (!empty($sale_details[4]->Option3->op_name)?$sale_details[4]->Option3->op_name:'') : old('s_opt3_5')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error3_5')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts3_5"{{ (isset($sale_details[4]->s_co_id) && ($sale_details[4]->s_co_id == 0 || $sale_details[4]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id5') == '0' ? '' : (($errors->first('customer_error1_5') || $errors->first('customer_error2_5') || $errors->first('customer_error3_5') || $errors->first('customer_error4_5') || $errors->first('customer_error5_5'))  ? (old('s_opts3_5') == null ? '' : (old('s_opts3_5') == $staff->s_id ? 'selected' : '')) :  (old('s_opts3_5') == null ? ( (isset($sale_details[4]->s_opts3) ? $sale_details[4]->s_opts3 : '') == $staff->s_id ? 'selected' : '') : (old('s_opts3_5') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error3_5')))
                                        {{ $errors->first('customer_error3_5') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細４</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt4_5" value="{{ old('s_co_id5') == '0' ? '' : (old('s_co_id5') == '9999'? '商品販売'  :(($errors->first('customer_error1_5') || $errors->first('customer_error2_5') || $errors->first('customer_error3_5') || $errors->first('customer_error4_5') || $errors->first('customer_error5_5'))  ? (old('s_opt4_5') == null ? '' : old('s_opt4_5') ) :(old('s_opt4_5') == null ? (!empty($sale_details[4]->Option4->op_name)?$sale_details[4]->Option4->op_name:'') : old('s_opt4_5')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error4_5')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts4_5"{{ (isset($sale_details[4]->s_co_id) && ($sale_details[4]->s_co_id == 0 || $sale_details[4]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id5') == '0' ? '' : (($errors->first('customer_error1_5') || $errors->first('customer_error2_5') || $errors->first('customer_error3_5') || $errors->first('customer_error4_5') || $errors->first('customer_error5_5'))  ? (old('s_opts4_5') == null ? '' : (old('s_opts4_5') == $staff->s_id ? 'selected' : '')) :  (old('s_opts4_5') == null ? ( (isset($sale_details[4]->s_opts4) ? $sale_details[4]->s_opts4 : '') == $staff->s_id ? 'selected' : '') : (old('s_opts4_5') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error4_5')))
                                        {{ $errors->first('customer_error4_5') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">詳細５</span>
                                </div>
                                <input type="text" class="form-control" readonly name = "s_opt5_5" value="{{ old('s_co_id5') == '0' ? '' : (old('s_co_id5') == '9999' ? '商品販売'  :(($errors->first('customer_error1_5') || $errors->first('customer_error2_5') || $errors->first('customer_error3_5') || $errors->first('customer_error4_5') || $errors->first('customer_error5_5'))  ? (old('s_opt5_5') == null ? '' : old('s_opt5_5') ) :(old('s_opt5_5') == null ? (!empty($sale_details[4]->Option5->op_name)?$sale_details[4]->Option5->op_name:'') : old('s_opt5_5')))) }}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error5_5')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts5_5"{{ (isset($sale_details[4]->s_co_id) && ($sale_details[4]->s_co_id == 0 || $sale_details[4]->s_co_id == 9999))  ? ' disabled="disabled"' : ''}}>
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}'  {{ old('s_co_id5') == '0' ? '' : (($errors->first('customer_error1_5') || $errors->first('customer_error2_5') || $errors->first('customer_error3_5') || $errors->first('customer_error4_5') || $errors->first('customer_error5_5'))  ? (old('s_opts5_5') == null ? '' : (old('s_opts5_5') == $staff->s_id ? 'selected' : '')) :  (old('s_opts5_5') == null ? ( (isset($sale_details[4]->s_opts5) ? $sale_details[4]->s_opts5 : '')== $staff->s_id ? 'selected' : '') : (old('s_opts5_5') == $staff->s_id ? 'selected' : ''))) }}>
                                                {{$staff->s_lastname}} {{$staff->s_firstname}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;">
                                    @if (($errors->first('customer_error5_5')))
                                        {{ $errors->first('customer_error5_5') }}
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">コース金額</span>
                                </div>
                                <input type="text" id="s_money_5"  class="form-control {{ ($errors->first('s_money_5')) ? 'is-invalid': ''}}" value="{{ old('s_money_5') == null ? ((isset($sale_details[4]->s_money) ? number_format($sale_details[4]->s_money) : '')) : old('s_money_5') }}" name="s_money_5" {{ old('s_co_id5') == null ? (((isset($sale_details[4]->s_co_id) ? $sale_details[4]->s_co_id : '') == '0' || (isset($sale_details[4]->s_co_id) ? $sale_details[4]->s_co_id : '') == '9999') ? '' : 'readonly') : ((old('s_co_id5') == '0' || old('s_co_id5') == '9') ? '' : 'readonly')}}>
                                <input type="hidden" id="s_money-hidden_5" name="s_money-hidden_5" value="{{ old('s_money-hidden_5') == null ? (isset($sale_details[4]->s_money) ? $sale_details[4]->s_money : '') : old('s_money-hidden_5') }}">
                                <div class="invalid-feedback">
                                    @error('s_money_5')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group form-add-course mt-3" style="display: {{ old('hd-block') == '5' ? 'block' : ( $total_detail < 5 ? 'block' : 'none')}}">
                        <button type="button" id="btn-add-course" class="btn btn-primary mb-3 pull-right"><i class="fa fa-plus"></i> コース</button>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">金額</span>
                            </div>
                            <input type="text" readonly class="form-control {{ ($errors->first('s_total_money')) ? 'is-invalid': ''}}" id="s_total_money" name="s_total_money" value = "{{ old('s_total_money') == null ? number_format($sales->s_money) : old('s_total_money') }}">
                            <input type="hidden" id="s_total_money-hidden" name="s_total_money-hidden" value="{{ old('s_total_money') == null ? number_format($sales->s_money) : old('s_total_money') }}">
                            <div class="invalid-feedback">
                                @error('s_total_money')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">新規顧客</span>
                            </div>
                            <div class="form-control wrapper-select">
                                <input type="checkbox" class="saleoff-checkbox" id="saleoff" name="s_saleoff_flg" value="{{$sales->s_saleoff_flg}}" {{ (old('s_saleoff_flg') == null && old('saleoff-hidden') == null) ? ($sales->s_saleoff_flg ? 'checked' : '') : ((old('s_saleoff_flg') == '0' || old('s_saleoff_flg') == '1') ? 'checked' : '') }}>
                                <input type="hidden" name="saleoff-hidden" value="1">
                            </div> 
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
                            <textarea maxlength="200" class="form-control" rows=4 name="s_text" >{{ old('s_text') == null ? ($sales->s_text) : old('s_text')  }}</textarea>
                        </div>
                    </div>
                    <!-- <input type="hidden" id="urlBack" name="urlBack" value="{{url()->previous()}}"> -->
                    <input type="hidden" name="course_changed" id="course_changed" value="">
                    <input type="hidden" id="hd-block" name="hd-block" value="{{ !empty(old('hd-block')) ? old('hd-block') : $total_detail }}">
                    <div class="clsCenter">
                    <button type="submit" class="btn btn-primary buttonSales btn-left-sales">更新</button>                    
                    <a role="button" href="{{ url('sales')}}" class="btn btn-secondary buttonSales" >キャンセル</a>
                    <div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>

    <script>
  $(document).ready(function(){

    $flag = 0;

    $("#input_s_c_id").keyup(function(){
    var query = $(this).val();
    if(query != '') 
    {
        var _token = $('input[name="_token"]').val(); 
            $.ajax({
                    url:"{{ route('searchCustomerAjax') }}", 
                    method:"POST", 
                    data:{query:query, _token:_token},
                    success:function(data){ 
                    if(data != ''){
                        $('#countryList').show();  
                        $('#countryList').html(data); 
                        $('#input_s_c_id').removeClass("is-invalid");
                        $('#save_s_c_id').val('');
                        $('#hid_s_c_id').val('').trigger('change'); 
                    }else{
                        $('#countryList').hide();                         
                        $("#listCustomerSearch").remove();
                        $('#input_s_c_id').addClass("is-invalid");
                        $('#check_customer_list').html("正しい顧客情報をご入力下さい！");
                    }

                    if($('#save_s_c_id').val() == $("#input_s_c_id").val()){
                        $('#input_s_c_id').removeClass("is-invalid");
                    }                                   
            }
            });
    }   
    });   

    $( "#input_s_c_id" ).focusout(function() {            
        
        if($("#save_s_c_id").val() != ''){
            if($('#save_s_c_id').val() != $("#input_s_c_id").val()){
                $('#hid_s_c_id').val('').trigger('change'); 
                $('#input_s_c_id').removeClass("is-invalid");
                $flag = 0; 
            }else{
                $('#input_s_c_id').removeClass("is-invalid");
            }
        }

        if($("#input_s_c_id").val() != ''){
            if($('#hid_s_c_id').val() == '' & $flag == 0){
                $('#input_s_c_id').addClass("is-invalid");
                $('#check_customer_list').html("正しい顧客情報をご入力下さい！");
                $('#input_s_c_id').val('');

                $("#countryList").hide();
                $("#listCustomerSearch").remove();
                $("#save_s_c_id").val('');
        }  
        }       
    });

    $("#countryList").mouseover(function() {
        $flag = 1;
    });

    $("#countryList").mouseout(function() {
        $flag = 0;
    });

    $("#countryList").on('click', 'li', function(){  
        $('#hid_s_c_id').val($(this).val()).trigger('change');  
        $('#input_s_c_id').val($(this).text());  
        $('#input_s_c_id').removeClass("is-invalid");
        $("#listCustomerSearch").remove();

        $('#save_s_c_id').val($(this).text());
    }); 

    $("#saleoff").change(function() {
        var saleoff = $("#saleoff").val();
        // var course = $("#s_co_id").val();
        var course_changed = $("#course_changed").val();
        if (saleoff == 1 && course_changed == '') {
            if($(this).is(":checked")){
                var old_money = $("#s_total_money-hidden").val();
                if (old_money != '') {
                    $("#s_money").val(numeral(old_money).format('0,0'));

                }
            } else {
                var money =  $("#s_total_money").val();
                money = money.replace(/,/g, '');
                if (money != '') {
                    $("#s_total_money").val(numeral(10*money/9).format('0,0'));
                    $("#s_total_money-hidden").val(numeral(10*money/9).format('0,0'));
                }
                $("#course_changed").val(2);
            }
        } else {
            if($(this).is(":checked")){
                var money =  $("#s_total_money").val();
                money = money.replace(/,/g, '');
                if (money != '') {
                    $("#s_total_money").val(numeral(money * 0.9).format('0,0'));
                }
            } else {
                var old_money = $("#s_total_money-hidden").val();
                if (old_money != '') {
                    $("#s_total_money").val(numeral(old_money).format('0,0'));
                }
            }
        }
        
    });

  $("#s_money_1").change(function() {
      $("#s_money-hidden_1").val($("#s_money_1").val());
      calculatorTotal();
  });

  $("#s_money_2").change(function() {
      $("#s_money-hidden_2").val($("#s_money_2").val());
      calculatorTotal();
  });

  $("#s_money_3").change(function() {
      $("#s_money-hidden_3").val($("#s_money_3").val());
      calculatorTotal();
  });

  $("#s_money_4").change(function() {
      $("#s_money-hidden_4").val($("#s_money_4").val());
      calculatorTotal();
  });

  $("#s_money_5").change(function() {
      $("#s_money-hidden_5").val($("#s_money_5").val());
      calculatorTotal();
  });
 });
</script>
@endsection