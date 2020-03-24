@extends('master')
@section('title','顧客管理')
@section('menu')
@parent
@endsection
@section('content')
<label>新規追加</label>
<form method="post" id="formSearch" style="width:50%" >
@csrf
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">No</span>
      </div>
      <input type="text" class="form-control" name="searchid"></input>
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">顧客の姓</span>
      </div>
      <input type="text" class="form-control" name="searchf_name"></input>
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">顧客名</span>
      </div>
      <input type="text" class="form-control"name="searchl_name"></input>
    </div>

    <div class="form-btn" style="text-align:center;">
        <button type="submit" class="btn btn-primary" style="margin-bottom:15px;">検索</button>  
    </div>
</form>

<label>新規追加</label>

<form method="post" id="formSearchload" style="width:50%" >
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">No</span>
      </div>
      <input type="text" class="form-control" >
    </div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">顧客の姓</span>
      </div>
      <input type="text" class="form-control">
    </div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" >顧客名</span>
      </div>
      <input type="text" class="form-control" >
    </div>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text" >備考</span>
      </div>
      <input type="text" class="form-control">
    </div>
    <div class="input-group input-group-lg">
        <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-lg">Large</span>
    </div>
  <input type="text" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
</div>
    <div class="form-btn" style="text-align:center;">
       <button type="submit" class="btn">ログイン</button>
        <a href="#" class="btn chang_pw" onClick="changepassword()">PW変更</a>
    </div>
</form>



@endsection