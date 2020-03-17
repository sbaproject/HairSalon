@extends('master')
@section('title','Sales New')
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
                                <span class="input-group-text">1</span>
                            </div>
                            <input type="text" class="form-control" placeholder="1">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">2</span>
                            </div>
                            <input type="text" class="form-control" placeholder="2">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">2</span>
                            </div>
                            <input type="text" class="form-control" placeholder="2">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">2</span>
                            </div>
                            <input type="text" class="form-control" placeholder="2">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">2</span>
                            </div>
                            <input type="text" class="form-control" placeholder="2">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">3</span>
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
                                <span class="input-group-text">4</span>
                            </div>
                            <input type="text" class="form-control" placeholder="4" >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">5</span>
                            </div>
                            <textarea class="form-control" rows=4></textarea>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">追加追加</button>
                    <button type="submit" class="btn btn-primary">追加</button>
                    <button type="reset" class="btn btn-secondary">キャンセル</button>
                </form>
            </div>
            <div class="col"></div>
        </div>
    </div>
@endsection