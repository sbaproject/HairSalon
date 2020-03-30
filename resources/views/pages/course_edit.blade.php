@extends('master')
@section('title','コース編集')
@section('menu')
@parent
@endsection
@section('content')
    <div class="container padding-20">
        <div class="row">
            <div id="course_new_edit_frm" class="col-xl-10 col-lg-10 col-md-10 col-sm-12">
                <div class="header-index border-bottom">
                    <h2 style="margin-right: 1rem; margin-bottom: 0.25rem">
                        コース編集
                    </h2>
                    @if (\Session::has('option_error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ \Session::get('option_error') }}
                        </div>    
                    @endif
                </div>
                <form method="post">
                    @csrf
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">コースID</span>
                            </div>
                            @php
                                $id = $course->co_id;
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
                                name="co_name" value="{{ old('co_name') ? old('co_name') : $course->co_name }}">
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
                            <div class="form-control wrapper-select">
                                <select class="select-shop" name="co_opt1" id="select-option-1" onchange="onOption1Change({{ $list_option }})">
                                    <option value=""></option>
                                    @if (isset($list_option))
                                        @foreach ($list_option as $option)
                                            <option value="{{ $option->op_id }}" {{ $option->op_id == $course->co_opt1 ? 'selected' : '' }}>
                                                {{ $option->op_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="option-amount" id="option-amount-1">{{ !empty($course->Option1) ? number_format($course->Option1->op_amount) : '' }}</span>
                                <span style="display: none;" id="option-amount-1-hidden">{{ !empty($course->Option1) ? $course->Option1->op_amount : 0 }} </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">詳細２</span>
                            </div>
                            <div class="form-control wrapper-select">
                                <select class="select-shop" name="co_opt2" id="select-option-2" onchange="onOption2Change({{ $list_option }})">
                                    <option value=""></option>
                                    @if (isset($list_option))
                                        @foreach ($list_option as $option)
                                            <option value="{{ $option->op_id }}" {{ $option->op_id == $course->co_opt2 ? 'selected' : '' }}>
                                                {{ $option->op_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="option-amount" id="option-amount-2">{{ !empty($course->Option2) ? number_format($course->Option2->op_amount) : '' }}</span>
                                <span style="display: none;" id="option-amount-2-hidden">{{ !empty($course->Option2) ? $course->Option2->op_amount : 0 }} </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">詳細３</span>
                            </div>
                            <div class="form-control wrapper-select">
                                <select class="select-shop" name="co_opt3" id="select-option-3" onchange="onOption3Change({{ $list_option }})">
                                    <option value=""></option>
                                    @if (isset($list_option))
                                        @foreach ($list_option as $option)
                                            <option value="{{ $option->op_id }}" {{ $option->op_id == $course->co_opt3 ? 'selected' : '' }}>
                                                {{ $option->op_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="option-amount" id="option-amount-3">{{ !empty($course->Option3) ? number_format($course->Option3->op_amount) : '' }}</span>
                                <span style="display: none;" id="option-amount-3-hidden">{{ !empty($course->Option3) ? $course->Option3->op_amount : 0 }} </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">詳細４</span>
                            </div>
                            <div class="form-control wrapper-select">
                                <select class="select-shop" name="co_opt4" id="select-option-4" onchange="onOption4Change({{ $list_option }})">
                                    <option value=""></option>
                                    @if (isset($list_option))
                                        @foreach ($list_option as $option)
                                            <option value="{{ $option->op_id }}" {{ $option->op_id == $course->co_opt4? 'selected' : '' }}>
                                                {{ $option->op_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="option-amount" id="option-amount-4">{{ !empty($course->Option4) ? number_format($course->Option4->op_amount) : '' }}</span>
                                <span style="display: none;" id="option-amount-4-hidden">{{ !empty($course->Option4) ? $course->Option4->op_amount : 0 }} </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">詳細５</span>
                            </div>
                            <div class="form-control wrapper-select">
                                <select class="select-shop" name="co_opt5" id="select-option-5" onchange="onOption5Change({{ $list_option }})">
                                    <option value=""></option>
                                    @if (isset($list_option))
                                        @foreach ($list_option as $option)
                                            <option value="{{ $option->op_id }}" {{ $option->op_id == $course->co_opt5 ? 'selected' : '' }}>
                                                {{ $option->op_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="option-amount" id="option-amount-5">{{ !empty($course->Option5) ? number_format($course->Option5->op_amount) : '' }}</span>
                                <span style="display: none;" id="option-amount-5-hidden">{{ !empty($course->Option5) ? $course->Option5->op_amount : 0 }} </span>
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
                                !empty($course->Option1) ? $money += $course->Option1->op_amount : '';
                                !empty($course->Option2) ? $money += $course->Option2->op_amount : '';
                                !empty($course->Option3) ? $money += $course->Option3->op_amount : '';
                                !empty($course->Option4) ? $money += $course->Option4->op_amount : '';
                                !empty($course->Option5) ? $money += $course->Option5->op_amount : '';
                            @endphp
                            <input readonly type="text" class="form-control {{ ($errors->first('co_money')) ? 'is-invalid'  :'' }}" 
                                name="co_money" id="co_money" value="{{ number_format($money) }}" >
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
                            <textarea class="form-control" maxlength="200" name="co_text" rows=4>{{ old('co_text') ? old('co_text') : $course->co_text }}</textarea>
                        </div>
                    </div>
                    <div class="form-group-button">
                        <button type="submit" class="btn btn-primary btn-form btn-left">更新</button>
                        <a role="button" href="{{url('course')}}" class="btn btn-secondary btn-form" >キャンセル</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="js/course.js"></script>
@endsection
