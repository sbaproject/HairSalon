@extends('master')
@section('title','顧客管理')
@section('menu')
@parent
@endsection
@section('content')
<link href="{{ asset('css/customer.css')}}" rel="stylesheet">
<div class="form-customer">
<div class="row">
  <div class="col-md-2"><label>検索</label></div>
</div>
<form method="post" id="formSearch" >
@csrf
  <div class="formser">
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">顧客ID</span>
      </div>
      <input type="text" class="form-control" maxlength="4" id="searchid" name="searchid"></input>
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">顧客姓</span>
      </div>
      <input type="text" class="form-control" maxlength="100" id="searchl_name" name="searchl_name"></input>
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">顧客名</span>
      </div>
      <input type="text" class="form-control" maxlength="100" id="searchf_name" name="searchf_name"></input>
    </div>
  </div>
    <div class="form-btn">
        <button type="button" id="btnSearch" class="btn btn-primary">検索</button>
        <button type="button" id="btnCancelSearch" class="btn btn-secondary" >クリア</button>
    </div>
</form>
</br>
<div class="row">
     <div id="customer_search_error" class="col-md-6" style="padding-top:30px;position:relative;">
        <label id="messageDanger" style="color:#FF0000;position: absolute;margin-top: -30px;display:none;">検索条件に該当するデータが見つかりません。</label>
        <label id="messageSuccess" style="color:#0066FF;position: absolute;margin-top: -30px;display:none;">顧客情報を更新出来ました。</label>
    </div>
</div>
</br>
<div class="row">
  <div id="customer_title_result" class="col-md-2">
    <label>顧客詳細</label>
  </div>
  <div class="col-md-2"><a class="btn btn-primary btn-addcustomer" href="{{url('customer/new')}}" role="button">新規追加</a></div>
  <div class="col-md-3">
    <label id="lblPaging" style="display:none" class="float-right" >
      <span id="page">1</span>/<span id="totalPage"></span>
    </label>
  </div>
</div>
<form method="post" id="formSearchload">
@csrf
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">顧客ID</span>
      </div>
      <input type="text" id="c_id" readonly="" value="0000" name="c_id" class="form-control" >
    </div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">顧客姓</span>
      </div>
      <input type="text" id="c_lastname" maxlength="100" readonly="" name="c_lastname" class="form-control" value="GINZA">
    </div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" >顧客名</span>
      </div>
      <input type="text" id="c_firstname" maxlength="100" readonly="" name="c_firstname" class="form-control" value="TARO">
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" >来客回数</span>
      </div>
      <input type="text" id="c_count" readonly="" name="c_count" class="form-control" value="4">
    </div>
    <div class="input-group input-group-lg">
        <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-lg">備考</span>
    </div>
  <input type="text" id="c_text" maxlength="200" readonly="" name="c_text" value="テストテストテスト" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
</div>
<div class="form-btnprcess" id="divUpCancel" style="display:none">
       <button type="button" id="btnUpdate" class="btn btn-primary">更新</button>  
       <button type="button" id="btnCancel" class="btn btn-secondary">キャンセル</button>  
  </div>
<div class="form-btnnextpre" id="divButton" style="display:none">
    <button type="button" id="btnPrev" disabled="disabled" class="btn">前</button>    
    <button type="button" id="btnNext" class="btn">次</button>
</div>
</form>
</div>

<script type="text/javascript">
$( document ).ready(function() {
    var arrData =  null;
    var index = 0;   
    $('#btnSearch').click(function(e){
        e.preventDefault(); 
        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('#formSearch input[name="_token"]').val()
                }
            });             
        $.ajax({
            url: "{{ url('/customer') }}",
            method: 'post',
            dataType: "json",
            data: {
                type: 'search',  
                searchid: $('#searchid').val(),
                searchf_name: $('#searchf_name').val(),
                searchl_name: $('#searchl_name').val()
            },
            success: function(result){
                arrData = result;    
                $("#page").html('1');      
                $("#lblPaging").css("display", "none");
                $("#divUpCancel").css("display", "none");
                $("#divButton").css("display", "none");
                $("#btnPrev").attr("disabled","disabled");     
                $("#btnNext").removeAttr("disabled");  
                $("#searchid").val(formatID($.trim($('#searchid').val())));    
                if (arrData.length > 0){     
                    $("#totalPage").html(arrData.length);
                    $("#lblPaging").css("display", "");
                    $("#divUpCancel").css("display", "");
                    $("#divButton").css("display", "");            
                    $("#c_id").val(formatID(arrData[0].c_id));
                    $("#c_lastname").val(arrData[0].c_lastname);
                    $("#c_firstname").val(arrData[0].c_firstname);
                    $("#c_count").val(arrData[0].c_count);
                    $("#c_text").val(arrData[0].c_text);  
                    
                    $("#c_lastname").removeAttr("readonly");
                    $("#c_firstname").removeAttr("readonly");                             
                    $("#c_text").removeAttr("readonly");    
                    if (arrData.length == 1){
                      $("#btnNext").attr("disabled","disabled");     
                    }         
                }  
                else{
                    index = 0; 
                    arrData = null;
                    $("#c_id").val("0000");
                    $("#c_lastname").val("GINZA");
                    $("#c_firstname").val("TARO");
                    $("#c_count").val("4");
                    $("#c_text").val('テストテストテスト');
                    $("#c_lastname").attr("readonly","");   
                    $("#c_firstname").attr("readonly",""); 
                    $("#c_text").attr("readonly","");
                    $("#messageDanger").css("display", "");  
                    $("#messageDanger").fadeOut(5000);            
                }                                             
        }});
    });

    $('#btnCancelSearch').click(function(e){     
      index = 0; 
      arrData = null;
      $('#searchid').val('');
      $('#searchl_name').val('');
      $('#searchf_name').val('');
      $("#lblPaging").css("display", "none");
      $("#divUpCancel").css("display", "none");
      $("#divButton").css("display", "none");

      $("#c_id").val("0000");
      $("#c_firstname").val("TARO");
      $("#c_lastname").val("GINZA");
      $("#c_count").val("4");
      $("#c_text").val('テストテストテスト');   
      $("#c_firstname").attr("readonly",""); 
      $("#c_lastname").attr("readonly","");                            
      $("#c_text").attr("readonly","");   
    });

    $('#btnNext').click(function(e){
        index = index + 1;       
        if ( index < arrData.length){
            $("#c_id").val(formatID(arrData[index].c_id));
            $("#c_firstname").val(arrData[index].c_firstname);
            $("#c_lastname").val(arrData[index].c_lastname);
            $("#c_count").val(arrData[index].c_count);
            $("#c_text").val(arrData[index].c_text);
            if ((arrData.length - 1) == index){
                $("#btnNext").attr("disabled","disabled");     
            }  
                  
            $("#page").html(index + 1);   
            $("#btnPrev").removeAttr("disabled");    
            
            $("#c_firstname").removeAttr("readonly"); 
            $("#c_lastname").removeAttr("readonly");                            
            $("#c_text").removeAttr("readonly");    
        }
    });

    $('#btnPrev').click(function(e){
        index = index - 1;       
        if ( index >= 0){
            $("#c_id").val(formatID(arrData[index].c_id));
            $("#c_firstname").val(arrData[index].c_firstname);
            $("#c_lastname").val(arrData[index].c_lastname);
            $("#c_count").val(arrData[index].c_count);
            $("#c_text").val(arrData[index].c_text);
            if (index == 0){
                $("#btnPrev").attr("disabled","disabled");     
            }             
            $("#page").html(index + 1);   
            $("#btnNext").removeAttr("disabled");   
            
            $("#c_firstname").removeAttr("readonly"); 
            $("#c_lastname").removeAttr("readonly");                            
            $("#c_text").removeAttr("readonly");    
        }
    });

    $('#btnCancel').click(function(e){
      if (arrData != null)
      {
        $("#c_firstname").val(arrData[index].c_firstname);
        $("#c_lastname").val(arrData[index].c_lastname);    
        $("#c_text").val(arrData[index].c_text); 
      }    
    }); 

    $('#btnUpdate').click(function(e){
      e.preventDefault(); 
      if (arrData != null)
      {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('#formSearch input[name="_token"]').val()
            }
        });             
        $.ajax({
            url: "{{ url('/customer') }}",
            method: 'post',
            dataType: "json",
            data: {
                type: 'update',   
                c_id: $('#c_id').val(),
                c_firstname: $('#c_firstname').val(),
                c_lastname: $('#c_lastname').val(),
                c_text: $('#c_text').val()
            },
            success: function(result){
              if (result == 1){
                arrData[index].c_firstname = $('#c_firstname').val();
                arrData[index].c_lastname= $("#c_lastname").val();              
                arrData[index].c_text= $("#c_text").val();
              } 
              $("#messageSuccess").css("display", "");
              $("#messageSuccess").fadeOut(5000);
        }});
      }       
    }); 

    function formatID(val){
      var id = val;
      if (!isNaN(id) && id != '' && val.length < 4){
        id = parseInt(val);
        if (id < 10){
          id = "000" + val;
        }
        else if (id >= 10 && id < 100){
          id = "00" + val;
        }
        else if (id >= 100 && id < 1000){
          id = "0" + val;
        }
      }
      return id;
    }
});
</script>

@endsection