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
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">コース</span>
                            </div>
                            <div class="form-control wrapper-select {{ ($errors->first('s_co_id')) ? 'is-invalid'  :'' }}">
                            <select class="select-shop2" id="s_co_id"  name="s_co_id" onchange="onCourseChange({{ $list_course }},{{ $list_option }})">
                                <option value = ''></option>
                                @foreach($list_course as $course)
                                <option value = '{{$course->co_id}}' {{ $course->co_id == old('s_co_id') ? 'selected' : '' }}>{{$course->co_name}}</option>
                                @endforeach
                                <option value = 0 {{ old('s_co_id') == '0' ? 'selected' : '' }}>フリー</option>
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
                                <span class="input-group-text">詳細１</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "s_opt1"  value="{{old('s_opt1')}}">
                            <div class="form-control wrapper-select {{ ($errors->first('customer_error')) ? 'is-invalid'  :'' }}">
                            <select class="select-shop2" name = "s_opts1">
                            <option value = ''></option>
                            @foreach($list_staff as $staff)
                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts1') ? 'selected' : '' }}>{{$staff->s_firstname}} {{$staff->s_lastname}}</option>
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
                                <span class="input-group-text">詳細２</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "s_opt2" value="{{old('s_opt2')}}">
                            <div class="form-control wrapper-select {{ ($errors->first('customer_error2')) ? 'is-invalid'  :'' }}">
                            <select class="select-shop2" name = "s_opts2">
                            <option value = ''></option>
                            @foreach($list_staff as $staff)
                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts2') ? 'selected' : '' }}>{{$staff->s_firstname}} {{$staff->s_lastname}}</option>
                            @endforeach
                            </select>
                            </div>
                            <div class="invalid-feedback" style="margin-left: 59%;" >
                                @if (($errors->first('customer_error2')))
                                    {{ $errors->first('customer_error2') }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">詳細３</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "s_opt3" value="{{old('s_opt3')}}">
                            <div class="form-control wrapper-select {{ ($errors->first('customer_error3')) ? 'is-invalid'  :'' }}">
                            <select class="select-shop2" name = "s_opts3">
                            <option value = ''></option>
                            @foreach($list_staff as $staff)
                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts3') ? 'selected' : '' }}>{{$staff->s_firstname}} {{$staff->s_lastname}}</option>
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
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">詳細４</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "s_opt4" value="{{old('s_opt4')}}">
                            <div class="form-control wrapper-select {{ ($errors->first('customer_error4')) ? 'is-invalid'  :'' }}">
                            <select class="select-shop2" name = "s_opts4">
                            <option value = ''></option>
                            @foreach($list_staff as $staff)
                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts4') ? 'selected' : '' }}>{{$staff->s_firstname}} {{$staff->s_lastname}}</option>
                            @endforeach
                            </select>
                            </div>
                            <div class="invalid-feedback" style="margin-left: 59%;">
                                @if (($errors->first('customer_error4')))
                                    {{ $errors->first('customer_error4') }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">詳細５</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "s_opt5" value="{{old('s_opt5')}}">
                            <div class="form-control wrapper-select {{ ($errors->first('customer_error5')) ? 'is-invalid'  :'' }}">
                            <select class="select-shop2" name = "s_opts5">
                            <option value = ''></option>
                            @foreach($list_staff as $staff)
                            <option value = '{{$staff->s_id}}' {{ $staff->s_id == old('s_opts5') ? 'selected' : '' }}>{{$staff->s_firstname}} {{$staff->s_lastname}}</option>
                            @endforeach
                            </select>
                            </div>
                            <div class="invalid-feedback" style="margin-left: 59%;">
                                @if (($errors->first('customer_error5')))
                                    {{ $errors->first('customer_error5') }}
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">金額</span>
                            </div>
                            <input type="text" {{ old('s_co_id') == '0' ? '' : 'disabled' }} class="form-control {{ ($errors->first('s_money')) ? 'is-invalid': ''}}" id="s_money" name="s_money" value = "{{old('s_money')}}">
                            <input type="hidden" id="s_money-hidden-ori" name="s_money-hidden-ori" value="{{old('s_money-hidden-ori')}}">
                            <input type="hidden" id="s_money-hidden" name="s_money-hidden" value="{{old('s_money-hidden')}}">
                            <div class="invalid-feedback">
                                @error('s_money')
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
            var money =  $("#s_money").val();
            if (money != '') {
                $("#s_money").val(money * 0.9);
                $("#s_money-hidden-ori").val(money * 0.9);
                
            }
        } else {
            var old_money = $("#s_money-hidden").val();
            if (old_money != '') {
                $("#s_money").val(old_money);
                $("#s_money-hidden-ori").val(old_money);
            }
        }
    });

    $("#s_money").keyup(function() {
        $("#s_money-hidden").val($("#s_money").val());
        $("#s_money-hidden-ori").val($("#s_money").val());
        
    });

 });
</script>
@endsection