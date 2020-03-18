

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
   <!-- Bootstrap CSS -->
   <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/login.css" rel="stylesheet">
</head>
<body>
  <div class="container form-login">
    <div class="row">

      <div class="col-sm-7 divLeft">
        <img src="{{asset('images/2-1 銀座マツナガロゴPANTONEグリーン.png') }}"  width="100%" alt="" class="img-reponsive imagesLogo">
      </div>

      <div class="col-sm-5 divRight">

      <form action="{{ asset ('/login')}}" method="post">
          @csrf

          <div class="divUsername">
            <label for="uname"><b>ユーザコード</b></label>
            <input type="text" class="input"  name="u_user" required>
            </div>
            <div class="divPass">
            <label for="psw"><b>パスワード</b></label>
            <input class="input" type="password"  name="u_pw" required>
            </div>

            <div class="divButtonLogin">
            <button type="submit" class="btn btn-primary">ログイン</button>
            <button type="button" class="btn btn-secondary">PW変更</button>
            
            </div>
            
        </form>
      </div>

    </div>

   </div>


</body>
</html>