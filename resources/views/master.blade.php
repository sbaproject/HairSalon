<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>@yield('title')</title>

    <!-- default path  -->
    <base href="{{asset('')}}">
    <!-- font-awesome CSS -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/docs.min.css" rel="stylesheet">    
    <!-- master CSS -->
    <link href="css/master.css" rel="stylesheet">
    <!-- sales CSS -->
    <link href="css/sales.css" rel="stylesheet">
  </head>
  <body>
  @section('menu')
    <div class="row">
        <div class="col-sm-2 logo">
            <img src="images/2-1 銀座マツナガロゴPANTONEグリーン.png"  width="100%" alt="" class="img-responsive">
        </div>
        <div class="col-sm-3">
            <b class="text-hair">売上管理システム</b>
        </div>
        <div class="col-sm-5">
            <h4 class="user-name">
            {{ Session::get('user')->u_user }}
            </h4>
        </div>
        <div class="col-sm-1">
            <img src="images/user.svg"  width="30%" alt="" class="img-responsive icon-user">
        </div>
        <div class="col-sm-1">
        <a class="user-logout" href="{{ asset('/logout')}}">Logout</a>
        </div>
  	</div>
    <hr>
	<div class="sidenav">
		<a href="customer" class="active">顧客管理</a>
		<a href="sales">売上管理</a>
		<a href="staff">スタッフ管理</a>
		<a href="course" >コース管理</a>
	</div>
	<div class="main">
		@show
		@yield('content')
    </div>
    
    <!-- Jquery 3.4.1 -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <!-- Bootstrap JS  -->
    <script src="js/bootstrap.js"></script>
    <!-- Master JS  -->
    <script src="js/app.js"></script>
  </body>
</html>