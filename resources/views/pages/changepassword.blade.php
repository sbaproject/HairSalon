<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password</title>
   <!-- Bootstrap CSS -->
   <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{ asset('css/login.css')}}" rel="stylesheet">

   <!-- Jquery 3.4.1 -->
   <script src="{{ asset('js/jquery-3.4.1.min.js')}}"></script>
  <!-- sales JS -->
  <script src="{{ asset('js/login.js')}}"></script>	
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
        <img src="{{asset('images/logo.png') }}"  width="100%" alt="" class="imagesLogo">
      </div>
      <div id="login_frm" class="col-7">
        <form method="post">
          @csrf
          <div class="form-group">
              <label for="u_user"><b>ユーザコード</b></label>
              <input type="text" class="form-control {{ ($errors->first('u_user')) ? 'is-invalid'  :'' }}" 
                  name="u_user" value="{{ old('u_user') ? old('u_user') : $user->u_user }}">
              <div class="invalid-feedback">
                  @error('u_user')
                      {{ $message }}
                  @enderror
              </div>
          </div>
          <div class="form-group">
              <label for="u_pw"><b>パスワード</b></label>
              <input type="password" class="form-control {{ ($errors->first('u_pw')) ? 'is-invalid'  :'' }}" 
                  name="u_pw" value="{{ old('u_pw') ? old('u_pw') : $user->u_pw }}">
              <div class="invalid-feedback">
                  @error('u_user')
                    {{ $message }}
                  @enderror
              </div>
          </div>
          <div class="form-group">
              <label for="pass_new"><b>新しいパスワード</b></label>
              <input type="password" class="form-control" name="pass_new">
          </div>
          <div class="form-group">
              <label for="pass_confirm"><b>新しいパスワード確認</b></label>
              <input type="password" class="form-control" name="pass_confirm">
          </div>
          <div class="form-btn">
            <button type="submit" class="btn login_us">更新</button>
            <a href="{{asset('login')}}" class="btn chang_pw">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
