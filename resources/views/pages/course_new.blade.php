@extends('master')
@section('title','コース登録')
@section('menu')
@parent
@endsection
@section('content')
    <div class="container padding-20">
        <div class="row">
            <div id="course_new_edit_frm" class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
                <h2 class="border-bottom">
                    コース登録
                </h2>
                <form method="post">
                    @csrf
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">コースID</span>
                            </div>
                            @php
                                $id = $last_course_id + 1;
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
                            <input type="text" readonly class="form-control" name="co_id" value="{{ $id }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">コース名</span>
                            </div>
                            <input type="text" maxlength="100" class="form-control {{ ($errors->first('co_name')) ? 'is-invalid'  :'' }}" 
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
                                <span class="input-group-text">詳細１</span>
                            </div>
                            <div class="form-control wrapper-select {{ ($errors->first('option_error')) ? 'is-invalid' : '' }}">
                                <select class="select-shop" name="co_opt1" id="select-option-1" onchange="onOption1Change({{ $list_option }})">
                                    <option value=""></option>
                                    @if (isset($list_option))
                                        @foreach ($list_option as $option)
                                            <option value="{{ $option->op_id }}" {{ $option->op_id == old('co_opt1') ? 'selected' : '' }}>
                                                {{ $option->op_name }}
                                            </option>
                                            @php
                                                if (old('co_opt1') == $option->op_id) {
                                                    $op1_amount = $option->op_amount;    
                                                }
                                            @endphp
                                        @endforeach
                                    @endif
                                </select>
                               
                                <input type="text" readonly class="option-amount" id="option-amount-1" name="option-amount-1" value="{{ old('option-amount-1', '') }}">
                                <input type="hidden" id="option-amount-1-hidden" value="{{ isset($op1_amount) ? $op1_amount : 0 }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">詳細２</span>
                            </div>
                            <div class="form-control wrapper-select {{ ($errors->first('option_error')) ? 'is-invalid'  :'' }}">
                                <select class="select-shop" name="co_opt2" id="select-option-2" onchange="onOption2Change({{ $list_option }})">
                                    <option value=""></option>
                                    @if (isset($list_option))
                                        @foreach ($list_option as $option)
                                            <option value="{{ $option->op_id }}" {{ $option->op_id == old('co_opt2') ? 'selected' : '' }}>
                                                {{ $option->op_name }}
                                            </option>
                                            @php
                                                if (old('co_opt2') == $option->op_id) {
                                                    $op2_amount = $option->op_amount;    
                                                }
                                            @endphp
                                        @endforeach
                                    @endif
                                </select>
                                <input type="text" readonly class="option-amount" id="option-amount-2" name="option-amount-2" value="{{ old('option-amount-2', '') }}">
                                <input type="hidden" id="option-amount-2-hidden" value="{{ isset($op2_amount) ? $op2_amount : 0 }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">詳細３</span>
                            </div>
                            <div class="form-control wrapper-select {{ ($errors->first('option_error')) ? 'is-invalid'  :'' }}">
                                <select class="select-shop" name="co_opt3" id="select-option-3" onchange="onOption3Change({{ $list_option }})">
                                    <option value=""></option>
                                    @if (isset($list_option))
                                        @foreach ($list_option as $option)
                                            <option value="{{ $option->op_id }}" {{ $option->op_id == old('co_opt3') ? 'selected' : '' }}>
                                                {{ $option->op_name }}
                                            </option>
                                            @php
                                                if (old('co_opt3') == $option->op_id) {
                                                    $op3_amount = $option->op_amount;    
                                                }
                                            @endphp
                                        @endforeach
                                    @endif
                                </select>
                                <input type="text" readonly class="option-amount" id="option-amount-3" name="option-amount-3" value="{{ old('option-amount-3', '') }}">
                                <input type="hidden" id="option-amount-3-hidden" value="{{ isset($op3_amount) ? $op3_amount : 0  }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">詳細４</span>
                            </div>
                            <div class="form-control wrapper-select {{ ($errors->first('option_error')) ? 'is-invalid' : '' }}">
                                <select class="select-shop" name="co_opt4" id="select-option-4" onchange="onOption4Change({{ $list_option }})">
                                    <option value=""></option>
                                    @if (isset($list_option))
                                        @foreach ($list_option as $option)
                                            <option value="{{ $option->op_id }}" {{ $option->op_id == old('co_opt4') ? 'selected' : '' }}>
                                                {{ $option->op_name }}
                                            </option>
                                            @php
                                                if (old('co_opt4') == $option->op_id) {
                                                    $op4_amount = $option->op_amount;    
                                                }
                                            @endphp
                                        @endforeach
                                    @endif
                                </select>
                                <input type="text" readonly class="option-amount" id="option-amount-4" name="option-amount-4" value="{{ old('option-amount-4', '') }}">
                                <input type="hidden" id="option-amount-4-hidden" value="{{ isset($op1_amount) ? $op1_amount : 0  }}">                
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">詳細５</span>
                            </div>
                            <div class="form-control wrapper-select {{ ($errors->first('option_error')) ? 'is-invalid' : '' }}">
                                <select class="select-shop" name="co_opt5" id="select-option-5" onchange="onOption5Change({{ $list_option }})">
                                    <option value=""></option>
                                    @if (isset($list_option))
                                        @foreach ($list_option as $option)
                                            <option value="{{ $option->op_id }}" {{ $option->op_id == old('co_opt5') ? 'selected' : '' }}>
                                                {{ $option->op_name }}
                                            </option>
                                            @php
                                                if (old('co_opt5') == $option->op_id) {
                                                    $op5_amount = $option->op_amount;    
                                                }
                                            @endphp
                                        @endforeach
                                    @endif
                                </select>
                                <input type="text" readonly class="option-amount" id="option-amount-5" name="option-amount-5" value="{{ old('option-amount-5', '') }}">
                                <input type="hidden" id="option-amount-5-hidden" value="{{ isset($op5_amount) ? $op5_amount : 0 }}">                
                            </div>
                            <div class="invalid-feedback">
                                @if (($errors->first('option_error')))
                                    {{ $errors->first('option_error') }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">金額</span>
                            </div> 
                            @php
                                $money = 0;             
                                if (isset($op1_amount)) $money += $op1_amount;
                                if (isset($op2_amount)) $money += $op2_amount;
                                if (isset($op3_amount)) $money += $op3_amount;
                                if (isset($op4_amount)) $money += $op4_amount;
                                if (isset($op5_amount)) $money += $op5_amount;
                            @endphp
                            <input readonly type="text" class="form-control" 
                                name="co_money" id="co_money" value="{{ old('co_money', number_format($money)) }}">
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
                            <textarea class="form-control" maxlength="200" name="co_text" rows=4>{{ old('co_text') }}</textarea>
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
    <script src="js/course.js"></script>
@endsection
