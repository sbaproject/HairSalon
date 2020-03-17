<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>@yield('title')</title>
    <meta name="description" content="">

    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,700' rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/templatemo-style.css') }}" rel="stylesheet">
  </head>
  <body>
  @section('menu')
    <!-- Left column -->
    <div class="templatemo-flex-row">
      <div class="templatemo-sidebar">
        <header class="templatemo-site-header">
        <img style="background: white;" src="" alt="">
        </header>
        <nav class="templatemo-left-nav">          
          <ul>
          <li><a href="{{ asset('pages/login') }}" class="active">顧客管理</a></li>
             <li><a href="{{ asset('pages/sales') }}">売上管理</a></li>
             <li><a href="{{ asset('pages/manage') }}">スタッフ管理</a></li>
             <li><a href="{{ asset('pages/course') }}" >コース管理</a></li>
          </ul>  
        </nav>
      </div>
      <!-- Main content --> 
      <div class="templatemo-content col-1 light-gray-bg">
        <div class="templatemo-top-nav-container">
          <div class="row">
            <nav class="templatemo-top-nav col-lg-12 col-md-12">
              <ul class="text-uppercase">
                <li>売上管理システム</li>
            
                <!-- @if (Auth::guest())
                  <li><a href="{{ url('/auth/login')}}"><i class="fa fa-sign-in"></i>Login</a></li>
                  <li><a href="{{ url('/auth/register')}}">Register</a></li>
                @else
                  <li ><a href="#">{{ Auth::user()->name }} </a></li>
                  <li><a href="{{ url('/auth/logout')}}"><i class="fa fa-sign-out"></i>Logout </a></li>
                @endif -->
              </ul>  
            </nav> 
          </div>
        </div>
        <style type="text/css">
          .olala {
            margin-left: 60px; 
            margin-top: 15px;
          }
        </style>
        <div class="olala">
          <b><h1>@yield('title')</h1></b>
        </div>
        @show
        @yield('content')
        </div>
      </div>
    </div>
    
    <!-- JS -->
    <script type="text/javascript" src="{{ asset('js/jquery-1.11.2.min.js') }}"></script>      <!-- jQuery -->
  </body>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="{{ asset('js/jquery-2.1.4.min.js')}}"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="{{ asset('js/bootstrap.min.js')}}"></script>
</html>