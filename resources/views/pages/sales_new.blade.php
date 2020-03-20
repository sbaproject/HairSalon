@extends('master')
@section('title','売上管理登録')
@section('menu')
@parent
@endsection
@section('content')

    <div class="container" style="padding: 20px;">
        <div class="row">
            <div class="col-10">
                <h2 style="border-bottom: 1px solid #ccc; line-height: normal;">
                売上管理登録
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
                            <input type="text" readonly class="form-control" value="{{$list_sales_count}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Date Sale</span>
                            </div>
                            <input type="text" class="form-control" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">顧客ID</span>
                            </div>
                            <select class="form-control" id="s_co_id" name="s_co_id">
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
                            <input type="text" class="form-control" name = "txt_lastname" placeholder="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">顧客名</span>
                            </div>
                            <input type="text" class="form-control" name = "txt_firstname" placeholder="">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">コース</span>
                            </div>
                            <select class="form-control {{ ($errors->first('s_co_id')) ? 'is-invalid'  :'' }}" name="s_co_id">
                            @foreach($list_course as $course)
                            <option value = '{{$course->co_id}}'>{{$course->co_name}}</option>
                            @endforeach
                            </select>
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
                            <div></div>
                            <select class="form-control">
                            <option></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">サブ2</span>
                            </div>
                            <div></div>
                            <select class="form-control">
                            <option></option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">サブ3</span>
                            </div>
                            <div></div>
                            <select class="form-control">
                            <option></option>
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
$(document).ready(function(){
  $("#submit1").hover(function(){
    $('input[name="hid"]').val('1');
  });

  $("#submit2").hover(function(){
    $('input[name="hid"]').val('2');
  });
  
  $("#s_co_id").change(function(){
       // var selectedCountry = $(this).children("option:selected").val();
        //alert("You have selected the country1 - " );

        
           
            $.ajax({
                url: "{{ route('getCustomerAjax') }}",
                type: 'GET',
                dataType: 'text',
                data: {
                    a:'thach'
                }
            }).done(function(ketqua) {
                alert("You have selected the country - " + ketqua);
            });
            
        

    });

//   $("#s_co_id").change(function(){
//     alert("You have selected the country - ";
//             // $.ajax({
//             //     url: "{{ route('getCustomerAjax') }}",
//             //     type: 'POST',
//             //     dataType: 'text',
//             //     data: {
//             //         a: selectedCountry
//             //     }
//             // }).done(function(ketqua) {
//             //     alert("You have selected the country - " + ketqua);
//             // });
            
//         });
});
</script>
    
@endsection