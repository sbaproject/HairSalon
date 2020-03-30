@if (Session::get('user') == null)
<script type="text/javascript">
    window.location = "{{ url('/login') }}" //if not login -> back to login page
</script>
@endif
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>@yield('title')</title>

    <!-- CSS  -->
    <base href="{{asset('')}}">
    <!-- font-awesome CSS -->
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- master CSS -->
    <link href="css/master.css" rel="stylesheet">
    <!-- sales CSS -->
    <link href="css/sales.css" rel="stylesheet">
    <!-- staff CSS -->
    <link href="css/staff.css" rel="stylesheet">
    <!-- course CSS -->
    <link href="css/course.css" rel="stylesheet">   
    <!-- jquery CSS -->
	  <link href="css/jquery-ui.css" rel="stylesheet"> 
	
	  <!-- JavaScript-->
	  <!-- Jquery 3.4.1 -->
    <script src="js/jquery-3.4.1.min.js"></script>
	  <script src="js/jquery-ui.js"></script>
    <script src="js/jquery.number.min.js"></script>
    <!-- Bootstrap JS  -->
    <script src="js/bootstrap.js"></script>
    <!-- Master JS  -->
    <script src="js/app.js"></script>  
    <!-- sales JS -->
    <script src="js/sales.js"></script>	
     <!-- Datatable JS -->
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>	
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>

  </head>
  <body>
  @section('menu')
    <div class="row">
        <div id="logo" class="col-3 logo">
            <img src="images/2-1 銀座マツナガロゴPANTONEグリーン.png"  width="100%" alt="" class="img-responsive">
        </div>
        <div id="title" class="col-4">
        <div id="title_cls" class="title_cls">売上管理システム</div>
        </div>
        <div id="username" class="col-3">
            <div id="user-name" class="user-name">
            @if (Session::get('user'))
            {{ Session::get('user')->u_name }}
            @endif
        </div>
        </div>
        <div id="user-img" class="col-1">
            <img src="images/user.svg"  class="img-responsive icon-user clswidthimg">
        </div>
        <a id="user-logout" class="user-logout" href="{{ asset('/logout')}}">Logout</a>
        <!-- <div class="col-1">
          <a class="user-logout" href="{{ asset('/logout')}}">Logout</a>
        </div> -->
  	</div>
    <hr>

    <div class="row">
        <div class="col-2 res-menu">
          <div class="menu">
            <ul class="menu-left">
              <li><a class="{{ (request()->is('customer*')) ? 'active' : '' }}" href="customer" >顧客管理</a></li>
              <li><a class="{{ (request()->is('sales*')) ? 'active' : '' }}" href="sales" >売上管理</a></li>
              <li><a class="{{ (request()->is('staff*')) ? 'active' : '' }}" href="staff" >スタッフ管理</a></li>
              <li><a class="{{ (request()->is('course*')) ? 'active' : '' }}" href="course">コース管理</a></li>
            </ul>
          </div>

        </div>
        <div class="col-10">
          <div class="main">
    		    @show
    		    @yield('content')
          </div>
        </div>
    </div>
  </body>
</html>

