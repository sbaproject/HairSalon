@extends('master')
@section('title','売上管理登録')
@section('menu')
@parent
@endsection
@section('content')

<link href="css/kronos.css" rel="stylesheet">
    <script src="js/kronos.js"></script>
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
                            <input type="text" id="kronos1" class="form-control" name="sale_date" value="">
                            <script>
                            var d = new Date();
                            var month = d.getMonth()+1;
                            var day = d.getDate();
                            var output = d.getFullYear() + '' +
                                (month<10 ? '0' : '') + month + '' +
                                (day<10 ? '0' : '') + day;                            

                            $('#kronos1').kronos({
                                format: 'yyyy/mm/dd',
                                initDate:  output
                            });                            
            
                        </script>      
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
                            <input type="text" class="form-control" readonly name = "s_opt1"  value="{{ $list_option[0]->op_name }}">                           
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
                            <input type="text" class="form-control" readonly name = "s_opt2" value="{{ $list_course[0]->Option1->op_name }}">
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
                            <input type="text" class="form-control" readonly name = "s_opt3" value="{{ $list_course[0]->Option2->op_name }}">
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
                            <input type="text" class="form-control {{ ($errors->first('s_money')) ? 'is-invalid'  :'' }}" placeholder="" name="s_money">
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
                            <textarea class="form-control" rows=4 name="s_text"></textarea>
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
    <script>

    $( window ).on( "load", function() {
        console.log( "window loaded" );

        $('#s_c_id option[value="{{$list_customer[1]->c_id}}"]').prop('selected', true);
        $('#s_c_id option[value="{{$list_customer[0]->c_id}}"]').prop('selected', true);

        //onCustomerChange(1);
        //onCourseChange(3);
    });

    $("#submit1").hover(function(){
    $('input[name="hid"]').val('1');
  });

    function onCustomerChange(list_customer) {  
        alert('thach');
        let option = document.getElementById("s_c_id").value;
        let newOption;   

        list_customer.forEach((element) => {
            if (element.c_id == option) {
                newOption = element
            }
        })

        if(newOption != null){
            $('input[name="txt_lastname"]').val(newOption.c_lastname);
            $('input[name="txt_firstname"]').val(newOption.c_firstname);
        }else{
            $('input[name="txt_lastname"]').val('');
            $('input[name="txt_firstname"]').val('');
        }        
    }


    function onCourseChange(list_course,list_option) {  
        let option = document.getElementById("s_co_id").value;
        let newOption;
        let optName1,optName2,optName3;

        //alert(list_option);
        list_course.forEach((element) => {
            if (element.co_id == option) {
                newOption = element
            }
        })

        if(newOption != null){
            $('input[name="s_money"]').val(newOption.co_money);
        }else{
            $('input[name="s_money"]').val('');
            return;
        }        

        list_option.forEach((element) => {
            if (element.op_id == newOption.co_opt1) {
                optName1 = element
            }
            if (element.op_id == newOption.co_opt2) {
                optName2 = element
            }
            if (element.op_id == newOption.co_opt3) {
                optName3 = element
            }
        })

        if(optName1 != null){
            $('input[name="s_opt1"]').val(optName1.op_name);
        }else{
            $('input[name="s_opt1"]').val('');
        }

        if(optName2 != null){
            $('input[name="s_opt2"]').val(optName2.op_name);
        }else{
            $('input[name="s_opt2"]').val('');
        }

        if(optName3 != null){
            $('input[name="s_opt3"]').val(optName3.op_name);
        }else{
            $('input[name="s_opt3"]').val('');
        }
    }


$(document).ready(function(){
 

  $("#submit2").hover(function(){
    $('input[name="hid"]').val('2');
  });

 
  
  $("#s_c_aid").change(function(){
        var selectedValue = $(this).children("option:selected").val();        
           
        $.ajax({
                url: "{{ route('getCustomerFirstNameAjax') }}",
                type: 'GET',
                dataType: 'text',
                data: {
                    c_id: selectedValue
                }
            }).done(function(data) {
                $('input[name="txt_firstname"]').val(data);
            });

            $.ajax({
                url: "{{ route('getCustomerLastNameAjax') }}",
                type: 'GET',
                dataType: 'text',
                data: {
                    c_id: selectedValue
                }
            }).done(function(data) {
                $('input[name="txt_lastname"]').val(data);
            });                  
    });

    $("#s_aco_id").change(function(){
        var selectedValue = $(this).children("option:selected").val();        
           
            $.ajax({
                url: "{{ route('getCourseOption1Ajax') }}",
                type: 'GET',
                dataType: 'text',
                data: {
                    co_id: selectedValue
                }
            }).done(function(data) {
                $('input[name="s_opt1"]').val(data);
            });

            $.ajax({
                url: "{{ route('getCourseOption2Ajax') }}",
                type: 'GET',
                dataType: 'text',
                data: {
                    co_id: selectedValue
                }
            }).done(function(data) {
                $('input[name="s_opt2"]').val(data);
            });

            $.ajax({
                url: "{{ route('getCourseOption3Ajax') }}",
                type: 'GET',
                dataType: 'text',
                data: {
                    co_id: selectedValue
                }
            }).done(function(data) {
                $('input[name="s_opt3"]').val(data);
            });

            $.ajax({
                url: "{{ route('getCourseMoneyAjax') }}",
                type: 'GET',
                dataType: 'text',
                data: {
                    co_id: selectedValue
                }
            }).done(function(data) {
                $('input[name="s_money"]').val(data);
            });
                    
    });

});
</script>
    
@endsection