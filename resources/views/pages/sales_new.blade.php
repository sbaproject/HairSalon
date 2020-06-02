@extends('master')
@section('title','売上管理登録')
@section('menu')
@parent
@endsection
@section('content')
    </br>
    <div class="container" style="padding: 20px;">
        <div class="row">
            <div id="sales_new_edit_frm" class="col-10">

            <div class="buttonAdd2" style="border-bottom: 1px solid #ccc; line-height: normal;">
                <h2 class="H2buttonAdd2 add-new-btn" >
                売上管理登録
                </h2>
                @if (\Session::has('success'))
                <div class=" alert alert-success alert-dismissible fade show">
                    {{ \Session::get('success') }}
                </div>

            @endif
        </div>

                <form method="post">
                @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">売上管理ID</span>
                            </div>
                            @php
                                $id = $last_sales_id + 1;
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
                            <input type="text" readonly class="form-control" value="{{$id}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">売上伝票日付</span>
                            </div>
                                    <input id="sale_date" readonly type="text" class="form-control datetimepicker-input col-md-2"
                                         name="sale_date" autocomplete="off"  value="{{ old('sale_date') == null ? $currentTime : old('sale_date') }}">
                                    <div class="input-group-append" data-target="#sale_date" onclick="$('#sale_date').focus();">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">顧客検索</span>
                            </div>
                            <input type="hidden" id="save_s_c_id" name="save_s_c_id" value="">
                            <input type="hidden" id="hid_s_c_id" name="s_c_id" value="{{old('s_c_id')}}" onchange="onCustomerChange({{ $list_customer }})">
                            <input type="text" autocomplete="off" class="form-control {{ ($errors->first('s_c_id')) ? 'is-invalid'  :'' }}" id="input_s_c_id" name = "input_s_c_id" value="{{old('input_s_c_id')}}">
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
                            <input type="text" class="form-control" readonly name = "txt_lastname" value="{{old('txt_lastname')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">顧客名</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "txt_firstname" value="{{old('txt_firstname')}}">
                        </div>
                    </div>
                    <div id="course_group_1" class="course_group">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">コース</span>
                                </div>
                                <div class="form-control wrapper-select {{ ($errors->first('s_co_id1')) ? 'is-invalid'  :'' }}">
                                <select class="select-shop2" id="s_co_id1"  name="s_co_id1" onchange="onCourseChange(1,'s_co_id1',{{ $list_course }},{{ $list_option }})">
                                    <option value = ''></option>
                                    @foreach($list_course as $course)
                                    <option value = '{{$course->co_id}}' {{ $course->co_id == old('s_co_id1') ? 'selected' : '' }}>{{$course->co_name}}</option>
                                    @endforeach
                                    <option value = 0 {{ old('s_co_id1') == '0' ? 'selected' : '' }}>フリー</option>
                                    <option value = 9999 {{ old('s_co_id1') == '9999' ? 'selected' : '' }}>商品販売</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt1_1"  value="{{old('s_opt1_1')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error1_1')) ? 'is-invalid'  :'' }}">
                                <select class="select-shop2" name = "s_opts1_1">
                                <option value = ''></option>
                                @foreach($list_staff as $staff)
                                <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts1_1') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt2_1" value="{{old('s_opt2_1')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error2')) ? 'is-invalid'  :'' }}">
                                <select class="select-shop2" name = "s_opts2_1">
                                <option value = ''></option>
                                @foreach($list_staff as $staff)
                                <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts2_1') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
                                @endforeach
                                </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;" >
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
                                <input type="text" class="form-control" readonly name = "s_opt3_1" value="{{old('s_opt3_1')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error3')) ? 'is-invalid'  :'' }}">
                                <select class="select-shop2" name = "s_opts3_1">
                                <option value = ''></option>
                                @foreach($list_staff as $staff)
                                <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts3_1') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt4_1" value="{{old('s_opt4_1')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error4')) ? 'is-invalid'  :'' }}">
                                <select class="select-shop2" name = "s_opts4_1">
                                <option value = ''></option>
                                @foreach($list_staff as $staff)
                                <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts4_1') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt5_1" value="{{old('s_opt5_1')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error5')) ? 'is-invalid'  :'' }}">
                                <select class="select-shop2" name = "s_opts5_1">
                                <option value = ''></option>
                                @foreach($list_staff as $staff)
                                <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts5_1') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" {{ (old('s_co_id1') == '0' || old('s_co_id1') == '9999') ? '' : 'readonly' }} class="form-control {{ ($errors->first('s_money_1')) ? 'is-invalid': ''}}" id="s_money_1" name="s_money_1" value = "{{old('s_money_1')}}">
                                <input type="hidden" id="s_money-hidden_1" name="s_money-hidden_1" value="{{old('s_money-hidden_1')}}">
                                <div class="invalid-feedback">
                                    @error('s_money_1')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="course_group_2" class="course_group" style="display: {{ old('hd-block') > 1 ? 'block' : 'none' }}">
                        <div class="form-group">
                            <span class="pull-right btn-remove-course"><i class="fa fa-remove"></i></span>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">コース</span>
                                </div>
                                <div class="form-control wrapper-select {{ ($errors->first('s_co_id2')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" id="s_co_id2"  name="s_co_id2" onchange="onCourseChange(2,'s_co_id2',{{ $list_course }},{{ $list_option }})">
                                        <option value = ''></option>
                                        @foreach($list_course as $course)
                                            <option value = '{{$course->co_id}}' {{ $course->co_id == old('s_co_id2') ? 'selected' : '' }}>{{$course->co_name}}</option>
                                        @endforeach
                                        <option value = 0 {{ old('s_co_id2') == '0' ? 'selected' : '' }}>フリー</option>
                                        <option value = 9999 {{ old('s_co_id2') == '9999' ? 'selected' : '' }}>商品販売</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt1_2"  value="{{old('s_opt1_2')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error1_2')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts1_2">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts1_2') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt2_2" value="{{old('s_opt2_2')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error2')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts2_2">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts2_2') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;" >
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
                                <input type="text" class="form-control" readonly name = "s_opt3_2" value="{{old('s_opt3_2')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error3')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts3_2">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts3_2') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt4_2" value="{{old('s_opt4_2')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error4')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts4_2">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts4_2') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt5_2" value="{{old('s_opt5_2')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error5')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts5_2">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts5_2') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" {{ (old('s_co_id2') == '0' || old('s_co_id2') == '9999') ? '' : 'readonly' }} class="form-control {{ ($errors->first('s_money_2')) ? 'is-invalid': ''}}" id="s_money_2" name="s_money_2" value = "{{old('s_money_2')}}">
                                <input type="hidden" id="s_money-hidden_2" name="s_money-hidden_2" value="{{old('s_money-hidden_2')}}">
                                <div class="invalid-feedback">
                                    @error('s_money_2')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="course_group_3" class="course_group mt-3" style="display: {{ old('hd-block') > 2 ? 'block' : 'none' }}">
                        <div class="form-group">
                            <span class="pull-right btn-remove-course"><i class="fa fa-remove"></i></span>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">コース</span>
                                </div>
                                <div class="form-control wrapper-select {{ ($errors->first('s_co_id3')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" id="s_co_id3"  name="s_co_id3" onchange="onCourseChange(3,'s_co_id3',{{ $list_course }},{{ $list_option }})">
                                        <option value = ''></option>
                                        @foreach($list_course as $course)
                                            <option value = '{{$course->co_id}}' {{ $course->co_id == old('s_co_id3') ? 'selected' : '' }}>{{$course->co_name}}</option>
                                        @endforeach
                                        <option value = 0 {{ old('s_co_id3') == '0' ? 'selected' : '' }}>フリー</option>
                                        <option value = 9999 {{ old('s_co_id3') == '9999' ? 'selected' : '' }}>商品販売</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt1_3"  value="{{old('s_opt1_3')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error1_3')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts1_3">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts1_3') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt2_3" value="{{old('s_opt2_3')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error2')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts2_3">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts2_3') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;" >
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
                                <input type="text" class="form-control" readonly name = "s_opt3_3" value="{{old('s_opt3_3')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error3')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts3_3">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts3_3') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt4_3" value="{{old('s_opt4_3')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error4')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts4_3">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts4_3') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt5_3" value="{{old('s_opt5_3')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error5')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts5_3">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts5_3') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" {{ (old('s_co_id3') == '0' || old('s_co_id3') == '9999') ? '' : 'readonly' }} class="form-control {{ ($errors->first('s_money_3')) ? 'is-invalid': ''}}" id="s_money_3" name="s_money_3" value = "{{old('s_money_3')}}">
                                <input type="hidden" id="s_money-hidden_3" name="s_money-hidden_3" value="{{old('s_money-hidden_3')}}">
                                <div class="invalid-feedback">
                                    @error('s_money_3')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="course_group_4" class="course_group mt-3" style="display: {{ old('hd-block') > 3 ? 'block' : 'none' }}">
                        <div class="form-group">
                            <span class="pull-right btn-remove-course"><i class="fa fa-remove"></i></span>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">コース</span>
                                </div>
                                <div class="form-control wrapper-select {{ ($errors->first('s_co_id4')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" id="s_co_id4"  name="s_co_id4" onchange="onCourseChange(4,'s_co_id4',{{ $list_course }},{{ $list_option }})">
                                        <option value = ''></option>
                                        @foreach($list_course as $course)
                                            <option value = '{{$course->co_id}}' {{ $course->co_id == old('s_co_id4') ? 'selected' : '' }}>{{$course->co_name}}</option>
                                        @endforeach
                                        <option value = 0 {{ old('s_co_id4') == '0' ? 'selected' : '' }}>フリー</option>
                                        <option value = 9999 {{ old('s_co_id4') == '9999' ? 'selected' : '' }}>商品販売</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt1_4"  value="{{old('s_opt1_4')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error1_4')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts1_4">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts1_4') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt2_4" value="{{old('s_opt2_4')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error2')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts2_4">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts2_4') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;" >
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
                                <input type="text" class="form-control" readonly name = "s_opt3_4" value="{{old('s_opt3_4')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error3')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts3_4">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts3_4') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt4_4" value="{{old('s_opt4_4')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error4')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts4_4">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts4_4') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt5_4" value="{{old('s_opt5_4')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error5')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts5_4">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts5_4') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" {{ (old('s_co_id4') == '0' || old('s_co_id4') == '9999') ? '' : 'readonly' }} class="form-control {{ ($errors->first('s_money_4')) ? 'is-invalid': ''}}" id="s_money_4" name="s_money_4" value = "{{old('s_money_4')}}">
                                <input type="hidden" id="s_money-hidden_4" name="s_money-hidden_4" value="{{old('s_money-hidden_4')}}">
                                <div class="invalid-feedback">
                                    @error('s_money_4')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="course_group_5" class="course_group mt-3 mb-3" style="display: {{ old('hd-block') > 4 ? 'block' : 'none' }}">
                        <div class="form-group">
                            <span class="pull-right btn-remove-course"><i class="fa fa-remove"></i></span>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">コース</span>
                                </div>
                                <div class="form-control wrapper-select {{ ($errors->first('s_co_id5')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" id="s_co_id5"  name="s_co_id5" onchange="onCourseChange(5,'s_co_id5',{{ $list_course }},{{ $list_option }})">
                                        <option value = ''></option>
                                        @foreach($list_course as $course)
                                            <option value = '{{$course->co_id}}' {{ $course->co_id == old('s_co_id5') ? 'selected' : '' }}>{{$course->co_name}}</option>
                                        @endforeach
                                        <option value = 0 {{ old('s_co_id5') == '0' ? 'selected' : '' }}>フリー</option>
                                        <option value = 9999 {{ old('s_co_id5') == '9999' ? 'selected' : '' }}>商品販売</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt1_5"  value="{{old('s_opt1_5')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error1_5')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts1_5">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts1_5') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt2_5" value="{{old('s_opt2_5')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error2')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts2_5">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts2_5') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="invalid-feedback" style="margin-left: 59%;" >
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
                                <input type="text" class="form-control" readonly name = "s_opt3_5" value="{{old('s_opt3_5')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error3')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts3_5">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts3_5') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt4_5" value="{{old('s_opt4_5')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error4')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts4_5">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts4_5') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" class="form-control" readonly name = "s_opt5_5" value="{{old('s_opt5_5')}}">
                                <div class="form-control wrapper-select {{ ($errors->first('customer_error5')) ? 'is-invalid'  :'' }}">
                                    <select class="select-shop2" name = "s_opts5_5">
                                        <option value = ''></option>
                                        @foreach($list_staff as $staff)
                                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts5_5') ? 'selected' : '' }}>{{$staff->s_lastname}} {{$staff->s_firstname}}</option>
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
                                <input type="text" {{ (old('s_co_id5') == '0' || old('s_co_id5') == '9999') ? '' : 'readonly' }} class="form-control {{ ($errors->first('s_money_4')) ? 'is-invalid': ''}}" id="s_money_5" name="s_money_5" value = "{{old('s_money_5')}}">
                                <input type="hidden" id="s_money-hidden_5" name="s_money-hidden_5" value="{{old('s_money-hidden_5')}}">
                                <div class="invalid-feedback">
                                    @error('s_money_5')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-add-course mt-3" style="display: {{ old('hd-block') < 5 ? 'block' : 'none' }}">
                        <button type="button" id="btn-add-course" class="btn btn-primary mb-3 pull-right"><i class="fa fa-plus"></i> コース</button>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">金額</span>
                            </div>
                            <input type="text" readonly class="form-control {{ ($errors->first('s_total_money')) ? 'is-invalid': ''}}" id="s_total_money" name="s_total_money" value = "{{old('s_total_money')}}">
                            <input type="hidden" id="s_total_money-hidden" name="s_total_money-hidden" value="{{old('s_total_money-hidden')}}">
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
                                <input type="checkbox" class="saleoff-checkbox" id="saleoff" name="s_saleoff_flg" {{ old('s_saleoff_flg') ? 'checked' : '' }}>
                            </div> 
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">支払い方法</span>
                            </div>
                            <select class="form-control" name="s_pay">
                                <option value ="0" {{ old('s_pay') == 0 ? 'selected' : '' }}>キャッシュ</option>
                                <option value ="1" {{ old('s_pay') == 1 ? 'selected' : '' }}>カード</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">備考</span>
                            </div>
                            <textarea maxlength="200" class="form-control" rows=4 name="s_text">{{old('s_text')}}</textarea>
                        </div>
                    </div>
                    <input type="hidden" id="hid" name="hid" value="">
                    <!-- <input type="hidden" id="urlBack" name="urlBack" value="{{url()->previous()}}"> -->
                    <input type="hidden" id="hd-block" name="hd-block" value="{{ old('hd-block')}}">
                    <div class="clsCenter">
                    <button type="submit" id="submit1" class="btn btn-primary buttonSales btn-left-sales">連続追加</button>
                    <button type="submit" id="submit2" class="btn btn-primary buttonSales btn-left-sales">追加</button>
                    <a role="button" href="{{url('sales')}}" class="btn btn-secondary buttonSales" >キャンセル</a>

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
        if($(this).is(":checked")){
            var money =  $("#s_total_money").val();
            money = money.replace(/,/g, '');
            if (money != '') {
                $("#s_total_money").val(numeral(money * 0.9).format('0,0'));
            }
        } else {
            var old_money = $("#s_total_money-hidden").val();
            if (old_money != '') {
                $("#s_total_money").val(old_money);
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