<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>@yield('title')</title>
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/master.css') }}" rel="stylesheet">
  </head>
  <body>
  @section('menu')

    <div class="row">
        <div class="col-sm-2">
            <img src="{{ asset('images/2-1 銀座マツナガロゴPANTONEグリーン.png') }}"  width="100%" alt="" class="img-responsive">
        </div>
        <div class="col-sm-3">
            <b class="text-hair">売上管理システム</b>
            
        </div>
        <div class="col-sm-6">
            <h4 class="user-name">user name</h4>
        </div>
        <div class="col-sm-1">
            <img src="{{ asset('images/user.svg') }}"  width="30%" alt="" class="img-responsive icon-user">
        </div>
    <div>
    <hr >
    <div class="row">
        <div class="col-sm-12">

            <div class="sidenav">
                <a href="{{ asset('pages/login') }}" class="active">顧客管理</a>
                <a href="{{ asset('pages/sales') }}">売上管理</a>
                <a href="{{ asset('pages/manage') }}">スタッフ管理</a>
                <a href="{{ asset('pages/course') }}" >コース管理</a>
            </div>

            <div class="main">
                @show
                @yield('content')
            </div>
        </div>
    </div>
  </body>
</html>