@extends('master')
@section('title','売上管理登録')
@section('menu')
@parent
@endsection
@section('content')
    </br>
    <div class="container" style="padding: 20px;">
        <div class="row">
            <div class="col-10">
                <h2 style="border-bottom: 1px solid #ccc; line-height: normal;">
                売上管理登録
                </h2>
                @if (\Session::has('success'))
                <div class="searchResult">
                    {{ \Session::get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>    
                @endif
                <form method="post">
                @csrf
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">No</span>
                            </div>
                            <input type="text" readonly class="form-control" value="{{$list_sales_count}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Date Sale</span>
                            </div>                            
                                    <input id="sale_date" readonly type="text" class="form-control datetimepicker-input col-md-2"
                                         name="sale_date" autocomplete="off"  value="{{ $currentTime }}">
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
                            <select class="form-control" id="s_c_id" name="s_c_id"  onchange="onCustomerChange({{ $list_customer }})">
                            @foreach($list_customer as $customer)
                            <option value = '{{$customer->c_id}}'>{{$customer->c_id}} - {{$customer->c_lastname}} {{$customer->c_firstname}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">顧客姓</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "txt_lastname" value="{{ $list_customer[0]->c_lastname }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">顧客名</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "txt_firstname" value="{{ $list_customer[0]->c_firstname }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">コース</span>
                            </div>
                            <select class="form-control" id="s_co_id"  name="s_co_id" onchange="onCourseChange({{ $list_course }},{{ $list_option }})">
                            @foreach($list_course as $course)
                            <option value = '{{$course->co_id}}'>{{$course->co_name}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">サブ1</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "s_opt1"  value="{{ $list_course[0]->Option1->op_name }}">                           
                            <select class="form-control" name = "s_opts1">
                            @foreach($list_staff as $staff)
                            <option value = '{{$staff->s_id}}'>{{$staff->s_firstname}} {{$staff->s_lastname}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">サブ2</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "s_opt2" value="{{ $list_course[0]->Option2->op_name }}">
                            <select class="form-control" name = "s_opts2">
                            @foreach($list_staff as $staff)
                            <option value = '{{$staff->s_id}}'>{{$staff->s_firstname}} {{$staff->s_lastname}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">サブ3</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "s_opt3" value="{{ $list_course[0]->Option3->op_name }}">
                            <select class="form-control" name = "s_opts3">
                            @foreach($list_staff as $staff)
                            <option value = '{{$staff->s_id}}'>{{$staff->s_firstname}} {{$staff->s_lastname}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">金額</span>
                            </div>
                            <input type="text" readonly class="form-control {{ ($errors->first('s_money')) ? 'is-invalid'  :'' }}" name="s_money" value = "{{ $list_course[0]->Option1->op_amount + $list_course[0]->Option2->op_amount + $list_course[0]->Option3->op_amount}}">
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
                                <option value ="0">キャッシュ</option>
                                <option value ="1">カード</option>
                            </select>
                        </div>
                    </div>
                  
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">備考</span>
                            </div>
                            <textarea maxlength="100" class="form-control" rows=4 name="s_text"></textarea>
                        </div>
                    </div>
                    <input type="hidden" id="hid" name="hid" value="">
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
@endsection