<!DOCTYPE html>
<html>
<head>
    <title>Leotive Reset password</title>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="{{ URL::asset('admins/css/login.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ URL::asset('admins/css/bootstrap.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ URL::asset('admins/css/lux.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('admins/css/open-iconic-bootstrap.min.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ URL::asset('admins/css/admin.css') }}" type="text/css" rel="stylesheet">

    <script src="{{ URL::asset('admins/js/bootstrap.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    
</head>
<body>
    <section class="content-center">
        <div class="card">
            <form class="form-signin" role="form" action="{{ route('admin.change_password') }}" method="post">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-3"><div class="text-center logo"><img src="{{ URL::asset('admins/images/logo.png') }}" width="80"></div></div>
                    <div class="col-md-9"><h3><br><br>ADMIN RESET PASSWORD</h3></div>
                </div>
                @if($errors->has('password') != null)
                <div class="alert alert-danger">
                        <p class="mb-0">{{ $errors->first('password') }}</p>
                </div>
                @endif
                @if($errors->has('password_confirmation') != null)
                <div class="alert alert-danger">
                        <p class="mb-0">{{ $errors->first('password_confirmation') }}</p>
                </div>
                @endif
                <p>Nhập email của bạn</p>
                <div class="input-group">
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon2" required autofocus value="{{ $email or old('email') }}">
                    <span class="input-group-addon" id="basic-addon2"><span class="oi oi-person" title="icon name" aria-hidden="true"></span></span>
                </div>
                <br>
                <p>Nhập mật khẩu mới</p>
                
                <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu" aria-label="Mật khẩu" aria-describedby="basic-addon3" required>
                    <span class="input-group-addon" id="basic-addon3"><span class="oi oi-lock-locked" title="icon name" aria-hidden="true"></span></span>
                </div>
                <br>
                <p>Nhập lại mật khẩu mới</p>

                <div class="input-group">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Mật khẩu" aria-label="Mật khẩu" aria-describedby="basic-addon3" required>
                    <span class="input-group-addon" id="basic-addon3"><span class="oi oi-lock-locked" title="icon name" aria-hidden="true"></span></span>
                </div>
                <br>
                <br>
                <button class="btn btn-success btn-block" type="submit">Đổi mật khẩu</button>
                <br>
                <div class="alert alert-info">
                    * Hệ thống sử dụng tốt nhất với <a target="_blank" href="https://www.google.com/chrome">Google Chrome</a>
                </div>
            </form>
        </div>
    </section>
</body>
</html>