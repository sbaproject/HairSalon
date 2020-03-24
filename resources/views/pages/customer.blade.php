@extends('master')
@section('title','顧客管理')
@section('menu')
@parent
@endsection
@section('content')
<div style="padding:20px;">
<a class="btn btn-primary" href="{{url('customer/new')}}" role="button" style="margin-bottom:20px">新規追加</a>
<form method="post" id="formSearch" style="width:50%" >
@csrf
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">No</span>
      </div>
      <input type="text" class="form-control" id="searchid" name="searchid"></input>
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">顧客の姓</span>
      </div>
      <input type="text" class="form-control" id="searchf_name" name="searchf_name"></input>
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">顧客名</span>
      </div>
      <input type="text" class="form-control" id="searchl_name" name="searchl_name"></input>
    </div>

    <div class="form-btn" style="text-align:center;">
        <button type="button" id="btnSearch" class="btn btn-primary" style="margin-bottom:15px;">探している</button>  
    </div>
</form>

<div id="divResults" style="display:none">
<label><span id="page">1</span>/<span id="totalPage"></span></label>
<br/>
<label>新規追加</label>
<form method="post" id="formSearchload" style="width:50%" >
@csrf
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">No</span>
      </div>
      <input type="text" id="c_id" readonly="" name="c_id" class="form-control" >
    </div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">顧客の姓</span>
      </div>
      <input type="text" id="c_firstname" readonly="" name="c_firstname" class="form-control" value="">
    </div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" >顧客名</span>
      </div>
      <input type="text" id="c_lastname" readonly="" name="c_lastname" class="form-control" >
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" >備考</span>
      </div>
      <input type="text" id="c_count" readonly="" name="c_count" class="form-control">
    </div>
    <div class="input-group input-group-lg">
        <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-lg">Large</span>
    </div>
  <input type="text" id="c_text" readonly="" name="c_text" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
</div>
<div class="form-btn" style="text-align:center; margin-top:20px">
        <a type="button" onClick="customeredit()" class="btn btn-primary" style="margin-bottom:15px;color:#fff;">編集</a>  
  </div>
<script type="text/javascript">
                function customeredit(){
                  var result = document.getElementById("c_id").value;
                  window.location.href = "customer/edit/" + result;
                }
              </script>
<div class="form-btn" style="text-align:center;">
    <button type="button" id="btnPrev" disabled="disabled" class="btn">Prev</button>    
    <button type="button" id="btnNext" class="btn">Next</button>
</div>
</form>
</div>
<label id="notFound" style="display:none">Not Found Data.</label>
</div>

<script type="text/javascript">
$( document ).ready(function() {
    var arrData =  null;
    var index = 0;
    loaddata();
    $('#btnSearch').click(function(e){
        e.preventDefault(); 
        loaddata();
    });

    $('#btnNext').click(function(e){
        index = index + 1;       
        if ( index < arrData.length){
            $("#c_id").val(arrData[index].c_id);
            $("#c_firstname").val(arrData[index].c_firstname);
            $("#c_lastname").val(arrData[index].c_lastname);
            $("#c_count").val(arrData[index].c_count);
            $("#c_text").val(arrData[index].c_text);
            if ((arrData.length - 1) == index){
                $("#btnNext").attr("disabled","disabled");     
            }  
            $("#formSearchload").fadeIn( "slow" );           
            $("#page").html(index + 1);   
            $("#btnPrev").removeAttr("disabled");             
        }
    });

    $('#btnPrev').click(function(e){
        index = index - 1;       
        if ( index >= 0){
            $("#c_id").val(arrData[index].c_id);
            $("#c_firstname").val(arrData[index].c_firstname);
            $("#c_lastname").val(arrData[index].c_lastname);
            $("#c_count").val(arrData[index].c_count);
            $("#c_text").val(arrData[index].c_text);
            if (index == 0){
                $("#btnPrev").attr("disabled","disabled");     
            }             
            $("#page").html(index + 1);   
            $("#btnNext").removeAttr("disabled");             
        }
    });

    function loaddata(){
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
                searchid: $('#searchid').val(),
                searchf_name: $('#searchf_name').val(),
                searchl_name: $('#searchl_name').val()
            },
            success: function(result){
                arrData = result;    
                $("#divResults").css("display", "none");    
                $("#notFound").css("display", "none");                
                if (arrData.length > 0){     
                    $("#totalPage").html(arrData.length);
                    $("#divResults").css("display", "");              
                    $("#c_id").val(arrData[0].c_id);
                    $("#c_firstname").val(arrData[0].c_firstname);
                    $("#c_lastname").val(arrData[0].c_lastname);
                    $("#c_count").val(arrData[0].c_count);
                    $("#c_text").val(arrData[0].c_text);
                }
                else{
                    $("#notFound").css("display", "");
                }
                if (arrData.length == 1){
                    $("#btnNext").attr("disabled","disabled");     
                }  

                
        }});
    }
});
</script>

@endsection