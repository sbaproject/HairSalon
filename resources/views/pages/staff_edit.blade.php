@extends('master')
@section('title','スタッフ編集')
@section('menu')
@parent
@endsection
@section('content')
    <div class="container padding-20">
        <div class="row">
            <div class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
                <h2 class="border-bottom">
                    スタッフ編集
                </h2>
                <form method="post">
                    @csrf
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">スタッフID</span>
                            </div>
                            @php
                                $id = $staff->s_id;
                                if ($id < 10) {
                                    $id = '000' . $id;
                                } 
                                if ($id >= 10 && $id < 100) {
                                    $id = '00' . $id;
                                }
                                if ($id >= 100 && $id < 1000) {
                                    $id = '0' . $id;
                                }
                            @endphp
                            <input type="text" readonly class="form-control" name="s_id" value="{{ $id }}">
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
                            <div class="form-control wrapper-select">
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
                        <button type="submit" class="btn btn-primary btn-form btn-left">更新</button>
                        <a role="button" href="{{url('staff')}}" class="btn btn-secondary btn-form" >キャンセル</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection