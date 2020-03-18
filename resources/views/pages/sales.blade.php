@extends('master')
@section('title','売上管理')
@section('menu')
@parent
@endsection
@section('content')

            <div class="">

            <form role="search" mothod="get" id="searchform" action="{{route('/sales/search')}}">
                        <div class="">
                        <div class="">期問</div>
                        <input type="text" id="kronos1" name="str_date" style="width: 200px;">
                         ~ <input type="text" id="kronos2" name="end_date" style="width: 200px;">
                        <script>
                            $('#kronos1').kronos({
                                format: 'yyyy/mm/dd'
                            });                            
                            $('#kronos2').kronos({
                                format: 'yyyy/mm/dd'
                            });
                        </script>
                        </div>
                        <div class=""><div class="">店舗</div><select class="" name ="shop_id">
                                @foreach($list_shop as $shop)
                                <option value = '{{$shop->sh_id}}'>{{$shop->sh_name}}</option>
                                @endforeach
                            </select></div>
                        <div class=""><button type="submit" class="btn btn-primary">検索</button></div>                         
            </form>
            </div>


            <div class="">
            <div class="">来客数</div>               
            <div class="">{{count($list_sales)}}</div>      
            </div>
            
            <div class="">
            <div class="">売上</div>               
            <div class="">{{number_format($sum_money)}} VND</div>  
            </div>

            <div class="">
            <button type="button" class="btn btn-primary"><a href="sales/new" style="color: white; text-decoration: none;">新規追加</a></button>
            <button type="button" class="btn btn-primary"><a href="sales/new" style="color: white; text-decoration: none;">PDF出カ</a></button>
            </div>

        <br/>

        

        @if (isset($list_sales))
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
                @foreach($list_sales as $sales)
                <tr>
                    <th scope="row">1</th>
                    <td>{{$sales->Customer->c_firstname}} {{$sales->Customer->c_lastname}}</td>
                    <td>{{$sales->Course->co_name}}</td>
                    <td>{{$sales->s_opts1}}</td>
                    <td>{{$sales->s_opts2}}</td>
                    <td>{{$sales->s_money}}</td>
                    <td>{{$sales->s_text}}</td>
                    <td><a href="{{ url('sales/edit/' . $sales->s_id) }}">編集</a>&nbsp;<a href="{{ url('sales/delete/' . $sales->s_id) }}" style="color: red;">削除</a></td>
                </tr>
                @endforeach               
            </tbody>
        </table>
        @endif
    </div>
@endsection