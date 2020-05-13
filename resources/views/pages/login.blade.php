<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
   <!-- Bootstrap CSS -->
   <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/login.css" rel="stylesheet">

  <!-- Jquery 3.4.1 -->
  <script src="js/jquery-3.4.1.min.js"></script>
  <!-- sales JS -->
  <script src="js/login.js"></script>	
</head>
<body>
  <div class="container form-login">
    @if (\Session::has('danger'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ \Session::get('danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
             </button>
        </div>
    @endif
    <div class="row">
      <div id="login_img" class="col-5">
        <img src="{{asset('images/logo.png') }}"  width="100%" alt="銀座マツナガロゴPANTONEグリーン" class="imagesLogo">
      </div>
      <div id="login_frm" class="col-7">
        <form action="{{ asset ('/login')}}" method="post">
          @csrf
          <div class="form-group">
              <label for="u_user"><b>ユーザコード</b></label>
              <input type="text" class="form-control {{ ($errors->first('u_user')) ? 'is-invalid'  :'' }}" 
              id="u_user" name="u_user" value="{{ old('u_user') }}">
              <div class="invalid-feedback">
                  @error('u_user')
                      {{ $message }}
                  @enderror
              </div>


          </div>
          <div class="form-group">
              <label for="u_pw"><b>パスワード</b></label>
              <input type="password" class="form-control {{ ($errors->first('u_pw')) ? 'is-invalid'  :'' }}" 
              id="u_pw" name="u_pw" value="{{ old('u_pw') }}">
              <div class="invalid-feedback">
                  @error('u_pw')
                      {{ $message }}
                  @enderror
              </div>
          </div>
          <div class="form-btn">
              <button type="submit" class="btn login_us">ログイン</button>
              <a class="btn chang_pw" onClick="changepassword()">PW変更</a>
              <script type="text/javascript">
                function changepassword(){
                  var re_userName = document.getElementById("u_user").value;
                  var re_passWord = document.getElementById("u_pw").value;
                  if(re_userName != "" && re_passWord != "")
                  {
                    window.location.href = "changepassword/" + re_userName + "/" + re_passWord;
                  }
                }
              </script>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</body>
</html>
