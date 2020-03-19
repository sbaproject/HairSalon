@extends('master')
@section('title','Sales New')
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
                            <input type="text" readonly class="form-control" value="{{$index}}" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">顧客ID</span>
                            </div>
                            <input type="text" class="form-control {{ ($errors->first('s_c_id')) ? 'is-invalid'  :'' }}" name="s_c_id" value="{{ $sales->s_c_id }}">
                            <div class="invalid-feedback">
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
                            <input type="text" class="form-control" value="{{ $sales->Customer->c_lastname}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">顧客名</span>
                            </div>
                            <input type="text" class="form-control" value="{{ $sales->Customer->c_firstname}}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">支払い方法</span>
                            </div>
                            <select class="form-control" name="s_co_id">
                            @foreach($list_course as $course)
                            @if($course->co_id == $sales->s_co_id) 
                            <option selected value = '{{$course->co_id}}'>{{$course->co_name}}</option>
                            @else
                            <option value = '{{$course->co_id}}'>{{$course->co_name}}</option>
                            @endif
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
@endsection