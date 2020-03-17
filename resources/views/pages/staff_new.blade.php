@extends('master')
@section('title','Staff')
@section('menu')
@parent
@endsection
@section('content')
    <div class="container" style="padding: 20px;">
        <div class="row">
            <div class="col-8">
                <h2 style="border-bottom: 1px solid #ccc; line-height: normal;">
                    スタッフ登録
                </h2>
                <form>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">姓</span>
                            </div>
                            <input type="text" class="form-control" placeholder="GINZA">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">名</span>
                            </div>
                            <input type="text" class="form-control" placeholder="TARO">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">担当店舗</span>
                            </div>
                            <select class="form-control">
                                <option>Thai Van Lung</option>
                                <option>InterContinental</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">主担当</span>
                            </div>
                            <input type="text" class="form-control" placeholder="カット" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">備考</span>
                            </div>
                            <textarea class="form-control" rows=4></textarea>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">追加</button>
                    <button type="reset" class="btn btn-secondary">キャンセル</button>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
@endsection