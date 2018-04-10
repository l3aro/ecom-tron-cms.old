@extends('admin.layout.main')
@section('title', 'Setting')
@section('content')
<h1> Thiết lập gửi Email</h1><br>
<?php  if ($saved) {?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>Lưu dữ liệu thành công!</strong> Dữ liệu đã được lưu vào cơ sở dữ liệu.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<?php  } ?>
<form id="formvalidate" name="form_system" action="" method="post" enctype="multipart/form-data" >
{{ csrf_field() }}
<div class="save-group-buttons">
<button name="submit" class="btn btn-sm btn-success"><i class="material-icons">save</i> Lưu</button>
<a class="btn btn-sm btn-info" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i> </a>
</div>
<div class="row">
<div class="col-sm-12">
    <div class="form-group">
        <label class="control-label" for="focusedInput">SMTP server address</label> 
        <input type="text" name="email_smtp_server" id="mailhost" class="form-control" value="<?=$setting->email_smtp_server?>" placeholder="smtp.gmail.com" required/>
        <small class="form-text text-muted">Địa chỉ STMP server là địa chỉ của host để gửi email. Với email là tài khoản của GOOGLE, chỉ cần nhập địa chỉ là "smtp.gmail.com". Đối với những tài khoản email khác, có thể nhập là: "mail.tenmien.com"</small>
    </div>
    <div class="form-group">
        <label class="control-label" for="focusedInput">SMTP Port</label> 
        <input type="text" name="email_smtp_port" id="mailport" class="form-control" value="<?=$setting->email_smtp_port?>" placeholder="465" required/>
        <small class="form-text text-muted">Cổng SMTP để gửi email. Với tài khoản google thì nhập cổng 465, với email server khác thì để là 25 hoặc 465 tùy theo cấu hình của email server</small>
    </div>
    <div class="form-group">
        <label class="control-label" for="focusedInput">Username</label> 
        <input type="text" name="email_smtp_user" id="mailuser" class="form-control" value="<?=$setting->email_smtp_user?>" placeholder="Địa chỉ" required/>
        <small class="form-text text-muted">Username đăng nhập email</small>
    </div>
    <div class="form-group">
        <label class="control-label" for="focusedInput">Password</label> <br>
        <input type="password" name="email_smtp_pass" id="mailpass" class="form-control" value="<?=$setting->email_smtp_pass?>" placeholder="Điện thoại" required/>
        <small class="form-text text-muted">Mật khẩu của tài khoản gửi email</small>
    </div>
    <div class="form-group">
        <label class="control-label" for="disabledInput">Tên tài khoản gửi đi</label> 
        <input type="text" name="email_smtp_name" id="mailname" class="form-control" value="<?=$setting->email_smtp_name?>" placeholder="Hotline" required/>
        <small class="form-text text-muted">Khi một email được gửi đi, tên này sẽ được hiển thị như tên người gửi</small>
    </div>
    <div class="form-group">
        <label class="control-label" for="disabledInput">Địa chỉ email gửi đi</label> 
        <input type="email" name="email_smtp_email_address" id="mailaddress" class="form-control" value="<?=$setting->email_smtp_email_address?>" placeholder="Email" required/>
        <small class="form-text text-muted">Có thể thay đổi địa chỉ email gửi đi, thiết lập này chỉ có tác dụng với các server email thông thường, không áp dụng cho server của Google</small>
    </div>
</div>
</div>
</form>
<script type="text/javascript">
$(document).ready(function() {
$('#menu-setting-email').parent('li').addClass('active');
});
</script>
@endsection