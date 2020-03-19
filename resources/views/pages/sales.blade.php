@extends('master')
@section('title','売上管理')
@section('menu')
@parent
@endsection
@section('content')
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
    <link href="css/kronos.css" rel="stylesheet">
    <script src="js/kronos.js"></script>

            <div class="row marBot15">
			<div class="searchSales col-md-5"> 		
            
            <form method="post">
            @csrf
            <div class="row marBot15">        
            <div class="col-md-2">期問</div>    
             <div class="col-md-4"><input type="text" id="kronos1" name="str_date" style="width: 150px;" class="form-control"></div>
             <div class="col-md-1">~</div>
			 <div class="col-md-3"><input type="text" id="kronos2" name="end_date" style="width: 150px;" class="form-control"></div>
                        <script>
                            $('#kronos1').kronos({
                                format: 'yyyy/mm/dd'                                
                            });                            
                            $('#kronos2').kronos({
                                format: 'yyyy/mm/dd'                                
                            });
                        </script>         

            </div>
            
			 <div class="row marBot15">                        
                        <div class="col-md-2">店舗</div>
						<div class="col-md-4">
						<select name ="shop_id" class="form-control">
                                @foreach($list_shop as $shop)
                                <option value = '{{$shop->sh_id}}'>{{$shop->sh_name}}</option>
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

        <br/>

        

        @if (isset($list_sales) && $list_sales_count>0)
        <table class="table table-bordered">
            <thead>
                <tr style="background-color: #e8e8e8;">
                <th scope="col">No</th>
                <th scope="col">名前</th>
                <th scope="col">コース</th>
                <th scope="col">サブ1</th>
                <th scope="col">サブ2</th>
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
                    <td>{{$sales->Customer->c_firstname}} {{$sales->Customer->c_lastname}}</td>
                    <td>{{$sales->Course->co_name}}</td>
                    <td>{{$sales->s_opts1}}</td>
                    <td>{{$sales->s_opts2}}</td>
                    <td>{{number_format($sales->s_money)}} VND</td>
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
        {{ $list_sales->links() }}
    </div>
   
@endsection