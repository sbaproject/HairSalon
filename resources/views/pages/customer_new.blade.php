@extends('master')
@section('title','顧客を追加する')
@section('menu')
@parent
@endsection
@section('content')
    <div class="container" style="padding-top: 25px;">
        <div class="row">
            <div class="col-10">
                <h2 class="border-bottom">
                顧客を追加する
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
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">顧客の姓</span>
                            </div>
                            <input type="text" class="form-control {{ ($errors->first('c_firstname')) ? 'is-invalid'  :'' }}" 
                                name="c_firstname" value="{{ old('c_firstname') }}" placeholder="顧客の姓を入力してください">
                            <div class="invalid-feedback">
                                @error('c_firstname')
                                    {{ $message }}
                                @enderror
                            </div>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">顧客名</span>
                            </div>
                            <input type="text" class="form-control {{ ($errors->first('c_lastname')) ? 'is-invalid'  :'' }}" 
                                name="c_lastname" value="{{ old('c_lastname') }}" placeholder="顧客の名前を入力してください">
                            <div class="invalid-feedback">
                                @error('c_lastname')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">備考</span>
                            </div>
                            <textarea class="form-control" name="s_text" rows=4>{{ old('c_text') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group-button">
                        <button type="submit" class="btn btn-primary btn-form btn-left">追加</button>
                        <a role="button" href="{{url('customer')}}" class="btn btn-secondary btn-form" >キャンセル</a>
                    </div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
@endsection