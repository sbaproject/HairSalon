@extends('master')
@section('title','コース登録')
@section('menu')
@parent
@endsection
@section('content')
    <div class="container padding20">
        <div class="row">
            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
                <h2 class="border-bottom">
                    コース登録
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
                                <span class="input-group-text">店舗メニュー</span>
                            </div>
                            <div class="form-control wrapper-select">
                                <select class="select-shop" name="co_sh_id">
                                    @if (isset($list_shop))
                                        @foreach ($list_shop as $shop)
                                            <option value="{{ $shop->sh_id }}" {{ $shop->sh_id == old('co_sh_id') ? 'selected' : '' }}>
                                                {{ $shop->sh_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">コース名</span>
                            </div>
                            <input type="text" class="form-control {{ ($errors->first('co_name')) ? 'is-invalid'  :'' }}" 
                                name="co_name" value="{{ old('co_name') }}">
                            <div class="invalid-feedback">
                                @error('co_name')
                                    {{ $message }}
                                @enderror
                            </div>
                            
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">サブ１</span>
                            </div>
                            <div class="form-control wrapper-select">
                                <select class="select-shop" name="co_opt1">
                                    <option>co_opt1 - 1</option>
                                    <option>co_opt1 - 2</option>
                                    <option>co_opt1 - 3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">サブ２</span>
                            </div>
                            <div class="form-control wrapper-select">
                                <select class="select-shop" name="co_opt2">
                                    <option>co_opt2 - 1</option>
                                    <option>co_opt2 - 2</option>
                                    <option>co_opt2 - 3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">サブ３</span>
                            </div>
                            <div class="form-control wrapper-select">
                                <select class="select-shop" name="co_opt3">
                                    <option>co_opt3 - 1</option>
                                    <option>co_opt3 - 2</option>
                                    <option>co_opt3 - 3</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">金額</span>
                            </div>
                            <input type="text" class="form-control {{ ($errors->first('co_money')) ? 'is-invalid'  :'' }}" 
                                name="co_money" value="{{ old('co_money') }}" >
                            <div class="invalid-feedback">
                                @error('co_money')
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
                            <textarea class="form-control" name="co_text" rows=4>{{ old('co_text') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group-button">
                        <button type="submit" class="btn btn-primary btn-form btn-left">追加</button>
                        <a role="button" href="{{url('course')}}" class="btn btn-secondary btn-form" >キャンセル</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection