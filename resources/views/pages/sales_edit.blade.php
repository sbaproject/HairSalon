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
                @if (\Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show">
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
                            <input type="text" readonly class="form-control" value="{{$index}}" >
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
                            <select class="form-control" id="s_c_id" name="s_c_id">
                            @foreach($list_customer as $customer)
                            <option value = '{{$customer->c_id}}' {{ $sales->s_c_id == $customer->c_id ? 'selected' : '' }} >
                                {{$customer->c_id}} - {{$customer->c_lastname}} {{$customer->c_firstname}}
                            </option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">顧客姓</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "txt_lastname" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">顧客名</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "txt_firstname" value="{{ $sales->Customer->c_firstname}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">コース</span>
                            </div>
                            <select class="form-control" name="s_co_id" id ="s_co_id">
                            @foreach($list_course as $course)
                            <option value = '{{$course->co_id}}' {{ $sales->s_co_id == $course->co_id ? 'selected' : '' }}>
                                {{$course->co_name}} 
                            </option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">サブ1</span>
                            </div>
                            <div></div>
                            <input type="text" class="form-control" readonly name = "s_opt1" placeholder="" value="{{ $sales->Option1->op_name}}">                           
                            <select class="form-control" name = "s_opts1">
                            @foreach($list_staff as $staff)
                            <option value = '{{$staff->s_id}}' {{ $sales->s_opts1 == $staff->s_id ? 'selected' : '' }}>
                            {{$staff->s_firstname}} {{$staff->s_lastname}}
                            </option>
                            @endforeach
                            </select>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">サブ2</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "s_opt2" placeholder="" value="{{ $sales->Option2->op_name}}">
                            <select class="form-control" name = "s_opts2">
                            @foreach($list_staff as $staff)
                            <option value = '{{$staff->s_id}}' {{ $sales->s_opts2 == $staff->s_id ? 'selected' : '' }}>
                            {{$staff->s_firstname}} {{$staff->s_lastname}}
                            </option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">サブ3</span>
                            </div>
                            <input type="text" class="form-control" readonly name = "s_opt3" placeholder="" value="{{ $sales->Option3->op_name}}">
                            <select class="form-control" name = "s_opts3">
                            @foreach($list_staff as $staff)
                            <option value = '{{$staff->s_id}}' {{ $sales->s_opts3 == $staff->s_id ? 'selected' : '' }}>
                            {{$staff->s_firstname}} {{$staff->s_lastname}}
                            </option>
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">金額</span>
                            </div>
                            <input type="text" class="form-control {{ ($errors->first('s_money')) ? 'is-invalid'  :'' }}" value="{{ $sales->s_money }}" name="s_money">
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
                            <textarea class="form-control" rows=4 name="s_text" >{{ $sales->s_text }}</textarea>
                        </div>
                    </div>
                    
                    <div class="clsCenter">
                    <button type="" class="btn btn-primary buttonSales btn-left-sales">連続追加</button>
                    <button type="submit" class="btn btn-primary buttonSales btn-left-sales">追加</button>                    
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
        myFunction(3);
    });


    function myFunction(a) {
  alert("thaac");

        $('input[name="txt_firstname"]').val("thach");           // Function returns the product of a and b

        $.ajax({
                url: "{{ route('getCustomerFirstNameAjax') }}",
                type: 'GET',
                dataType: 'text',
                data: {
                    c_id: a
                }
            }).done(function(data) {
                $('input[name="txt_firstname"]').val(data);
            });

            $.ajax({
                url: "{{ route('getCustomerLastNameAjax') }}",
                type: 'GET',
                dataType: 'text',
                data: {
                    c_id: 1
                }
            }).done(function(data) {
                $('input[name="txt_lastname"]').val(data);
            });   
}


    $(document).ready(function(){
  $("#submit1").hover(function(){
    $('input[name="hid"]').val('1');
    alert("thac");
  });

  $("#submit2").hover(function(){
    $('input[name="hid"]').val('2');
  });

  

  
  $("#s_c_id").change(function(){
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

    $("#s_co_id").change(function(){
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