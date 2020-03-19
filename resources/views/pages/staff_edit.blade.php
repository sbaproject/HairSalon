@extends('master')
@section('title','スタッフ編集')
@section('menu')
@parent
@endsection
@section('content')
    <div class="container" style="padding: 20px;">
        <div class="row">
            <div class="col-10">
                <h2 class="border-bottom">
                    スタッフ編集
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
                            <input type="text" readonly class="form-control" name="s_id" value="{{ $staff->s_id }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">姓</span>
                            </div>
                            <input type="text" class="form-control {{ ($errors->first('s_firstname')) ? 'is-invalid'  :'' }}" 
                                name="s_firstname" value="{{ old('s_firstname') ? old('s_firstname') : $staff->s_firstname }}" placeholder="GINZA">
                            <div class="invalid-feedback">
                                @error('s_firstname')
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
                            <input type="text" class="form-control {{ ($errors->first('s_lastname')) ? 'is-invalid'  :'' }}" 
                                name="s_lastname" value="{{ old('s_lastname') ? old('s_lastname') : $staff->s_lastname }}" placeholder="TARO">
                            <div class="invalid-feedback">
                                @error('s_lastname')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">担当店舗</span>
                            </div>
                            <div class="form-control">
                                <select class="select-shop" name="s_shop">
                                    @if (isset($list_shop))
                                        @foreach ($list_shop as $shop)
                                            <option value="{{ $shop->sh_id }}" {{ $staff->s_shop == $shop->sh_id ? 'selected' : '' }}>
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
                                <span class="input-group-text">主担当</span>
                            </div>
                            <input type="text" class="form-control {{ ($errors->first('s_charge')) ? 'is-invalid'  :'' }}" 
                                name="s_charge" value="{{ old('s_charge') ? old('s_charge') : $staff->s_charge }}" placeholder="カット" >
                            <div class="invalid-feedback">
                                @error('s_charge')
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
                            <textarea class="form-control" name="s_text" rows=4>{{ old('s_text') ? old('s_text') : $staff->s_text }}</textarea>
                        </div>
                    </div>
                    <div class="form-group-button">
                        <button type="submit" class="btn btn-primary btn-form btn-left">追加</button>
                        <a role="button" href="{{url('staff')}}" class="btn btn-secondary btn-form" >キャンセル</a>
                    </div>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
@endsection