@extends('master')
@section('title','売上管理')
@section('menu')
@parent
@endsection
@section('content')
</br>    
            <div class="row marBot15">
			<div class="searchSales col-md-5"> 	           
       
            <div class="{{ Session::has('search') ? 'searchResult' : 'searchBefore' }}">
                @if (\Session::has('search'))
                検索出来た件数: {{ \Session::get('search') }} 件
                {{ \Session::forget('search') }}
                @endif

                                @error('end_date')
                                <div class = 'searchBeforeError'>
                                    {{ $message }}
                                </div>  
                                @enderror
            </div>    
           

            <form method="post" id="formSearch">
            @csrf
            <div class="row marBot15">        
            <div class="col-md-2">期問</div>    
             <div class="col-md-4">
             <div class="input-group date">
                                    <input id="str_date" readonly type="text" class="form-control datetimepicker-input"
                                         name="str_date" autocomplete="off" value="{{ !empty($str_date) ? $str_date : $currentTime }}"> 
                                    <div class="input-group-append" data-target="#str_date" onclick="$('#str_date').focus();">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
             </div>
             <div class="col-md-1">-</div>
			 <div class="col-md-4">
             <div class="input-group date">
                                    <input id="end_date" readonly type="text" class="form-control datetimepicker-input"
                                         name="end_date" autocomplete="off"  value="{{ !empty($end_date) ? $end_date:  $currentTime }}">
                                    <div class="input-group-append" data-target="#end_date" onclick="$('#end_date').focus();">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
             </div>    

            </div>          
            
            
			 <div class="row marBot15">                        
                        <div class="col-md-2">店舗</div>
						<div class="col-md-5">
						<select name ="shop_id" class="form-control">
                                @foreach($list_shop as $shop)
                                <option value = '{{$shop->sh_id}}' {{ !empty($shopId) ? ( $shopId == $shop->sh_id  ? 'selected' : '' ) : (Session::get('user')->u_shop == $shop->sh_id ? 'selected' : '' ) }}>{{$shop->sh_name}}</option>
                                @endforeach
                            </select>
							</div>
			</div>
                            
                        <div class="col-md-12">
						<div class="marBot15"><button type="submit" class="btn btn-primary buttonSales" >検索</button></div>
                        </div>      
                        
                        </form>
                        
			</div>
			</div>
			<div class="row">	
			
			
            <div class="col-md-2 searchSales status">
            <div class="marBot15">来客数</div>               
            <div class="">{{$list_sales_count}}</div>      
            </div>

            <div class="col-md-1"></div>
            
            <div class="col-md-2 boderStatus">
            <div class="marBot15">売上</div>               
            <div class="">{{number_format($sum_money)}} VND</div>
			</div>
			
			</div>
            <br/>
            <div class="">
            <button type="button" class="btn btn-primary buttonSales"><a href="sales/new" style="color: white; text-decoration: none;">新規追加</a></button>
            <button type="button" class="btn btn-primary buttonSales"><a href="sales/new" style="color: white; text-decoration: none;">PDF出カ</a></button>
            </div>

        

        <!-- <div class="alert-success alert-dismissible fade show"> -->
        <div id="statusResult" class="{{ Session::has('success') ? 'statusResult' : 'statusBefore' }}">
            @if (\Session::has('success'))            
                    {{ \Session::get('success') }}           
            @endif
        </div>    

        @if (isset($list_sales) && $list_sales_count>0)
        <table class="table table-bordered table-hover">
            <thead>
                <tr style="background-color: #e8e8e8;">
                <th scope="col">No</th>
                <th scope="col">顧客名前</th>
                <th scope="col">コース</th>
                <th scope="col">サブ1</th>
                <th scope="col">サブ2</th>
                <th scope="col">サブ3</th>
                <th scope="col">金額</th>
                <th scope="col">備考</th>
                <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                        $page = request()->get("page");
                        if ($page)
                            $index = $page * 10 - 9;
                        else
                            $index = 1;
                @endphp
                @foreach($list_sales as $sales)
                @php
                    if ($index < 10)
                        $index = '0' . $index               

                @endphp
                <tr>
                    <th>{{ $index }}</th>
                    <td>{{!empty($sales->Customer->c_firstname)?$sales->Customer->c_firstname:''}} {{!empty($sales->Customer->c_lastname)?$sales->Customer->c_lastname:''}}</td>
                    <td>{{ !empty($sales->Course->co_name) ? $sales->Course->co_name : '' }}</td>
                    <td>{{ !empty($sales->Option1->op_name) ? $sales->Option1->op_name : ''}}</td>
                    <td>{{ !empty($sales->Option2->op_name) ? $sales->Option2->op_name : ''}}</td>
                    <td>{{ !empty($sales->Option3->op_name) ? $sales->Option3->op_name : ''}}</td>
                    <td>{{number_format($sales->s_money)}}</td>
                    <td>{{$sales->s_text}}</td>
                    <td><a href="{{ url('sales/edit/' . $sales->s_id.'/'.$index) }}">編集</a>&nbsp;<a href="{{ url('sales/delete/' . $sales->s_id) }}" style="color: red;">削除</a></td>
                </tr>
                @php 
                    $index++; 
                @endphp
                @endforeach               
            </tbody>
        </table>
        @endif
        <div class="pagination-container">
                <div>{{ $list_sales->links() }}</div>
            </div>
    </div>

@endsection