@extends('master')
@section('title','Staff')
@section('menu')
@parent
@endsection
@section('content')
    <div style="padding: 20px;">
        <h2 style="border-bottom: 1px solid #ccc; line-height: normal;">
            スタッフ登録
        </h2>
        <br/>
                <!-- <tr style="background-color: #e8e8e8;">
                <th scope="col">No</th>
                <th scope="col">姓</th>
                <th scope="col">名</th>
                <th scope="col">担当店舗</th>
                <th scope="col">主担当</th>
                <th scope="col">備考</th>
                <th scope="col">Actions</th>
                </tr> -->

        <!-- <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">姓</span>
            </div>
            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
        </div> -->
        <form>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection