<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
   <!-- Bootstrap CSS -->
   <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/login.css" rel="stylesheet">
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
      <div class="col-6">
        <img src="{{asset('images/2-1 銀座マツナガロゴPANTONEグリーン.png') }}"  width="100%" alt="" class="imagesLogo">
      </div>
      <div class="col-6">
        <form action="{{ asset ('/login')}}" method="post">
          @csrf
          <div class="form-group">
              <label for="u_user"><b>ユーザコード</b></label>
              <input type="text" class="form-control {{ ($errors->first('u_user')) ? 'is-invalid'  :'' }}" 
                  name="u_user" value="{{ old('u_user') }}">
              <div class="invalid-feedback">
                  @error('u_user')
                      {{ $message }}
                  @enderror
              </div>
          </div>
          <div class="form-group">
              <label for="u_pw"><b>パスワード</b></label>
              <input type="password" class="form-control {{ ($errors->first('u_pw')) ? 'is-invalid'  :'' }}" 
                  name="u_pw" value="{{ old('u_pw') }}">
              <div class="invalid-feedback">
                  @error('u_pw')
                      {{ $message }}
                  @enderror
              </div>
          </div>
          <button type="submit" class="btn btn-primary btn-form btn-left login_us">ログイン</button>
          <a href="{{ asset ('/changepassword')}}" class="btn btn-secondary btn-form chang_pw" >PW変更</a>
        </form>
      </div>
    </div>
  </div>

</body>
</html>
