@extends('master')
@section('title','顧客を編集する')
@section('menu')
@parent
@endsection
@section('content')
    <div class="container padding20">
        <div class="row">
            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
                <h2 class="border-bottom">
                    顧客を編集する
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
                                <span class="input-group-text">スタッフID</span>
                            </div>
                            <input type="text" readonly class="form-control" name="c_id" value="{{ $customer->c_id }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">姓</span>
                            </div>
                            <input type="text" class="form-control {{ ($errors->first('c_firstname')) ? 'is-invalid'  :'' }}" 
                                name="c_firstname" value="{{ old('c_firstname') ? old('c_firstname') : $customer->c_firstname }}"placeholder="顧客の姓を入力してください">
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
                                <span class="input-group-text">名</span>
                            </div>
                            <input type="text" class="form-control {{ ($errors->first('c_lastname')) ? 'is-invalid'  :'' }}" 
                                name="c_lastname" value="{{ old('c_lastname') ? old('s_lastname') : $customer->c_lastname }}" placeholder="顧客の名前を入力してください">
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
                            <textarea class="form-control" name="c_text" rows=4>{{ old('c_text') ? old('c_text') : $customer->c_text }}</textarea>
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