<!DOCTYPE html>
<html>
<head>
    <title>Leotive Forgot Password</title>

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
        <form class="form-signin" role="form" action="{{ route('admin.send_reset_link') }}" method="post">
            {{ csrf_field() }}
            <div class="row">
            <div class="col-md-3"><div class="text-center logo"><img src="{{ URL::asset('admins/images/logo.png') }}" width="80"></div></div>
            <div class="col-md-9"><h3><br><br>ADMIN FORGOT PASSWORD</h3></div>
        </div>
            @if(session('status'))
            <div class="alert alert-success">
                    <p class="mb-0">{{ session('status') }}</p>
            </div>
            @endif
            @if($errors->has('email') != null)
            <div class="alert alert-danger">
                    <p class="mb-0">{{ $errors->first('email') }}</p>
            </div>
            @endif
            <p>Vui lòng nhập email</p>

            <div class="input-group">
            <input type="email" name="email" class="form-control" placeholder="Email" aria-label="Email" aria-describedby="basic-addon2" required autofocus>
            <span class="input-group-addon" id="basic-addon2"><span class="oi oi-envelope-closed"></span></span>
            </div>	
            <br>
            <div class="text-right"><a href="login">Đăng nhập</a></div>
            <br>
            <button class="btn btn-success btn-block" type="submit">Yêu cầu khôi phục mật khẩu</button>
            <br>
            <br>
            <div class="alert alert-info">
            * Hệ thống sử dụng tốt nhất với <a target="_blank" href="https://www.google.com/chrome">Google Chrome</a>
            </div>
        </form>
        </div>
    </section>
</body>
</html>