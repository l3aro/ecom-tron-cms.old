@extends('admin.layout.main')
@section('title', 'Change Password')
@section('content')
<div class="container" style="max-width: 400px; margin-top: 30px">
<h2 class="form-signin-heading">Đổi mật khẩu</h2>
<form class="form-signin" role="form" action="" method="post">
{{ csrf_field() }}
		<?php if($passwordMessage) { ?>
			<div class="alert alert-danger">
		  		<h4>Lỗi!</h4>
				<p><?php echo $passwordMessage?></p>
			</div>
		<?php } ?>
		<?php if($message) { ?>
			<div class="alert alert-success">
		  		<h4>Thành công</h4>
				<p><?php echo $message?></p>
			</div>
		<?php } ?>
		
		<div class="form-group">
		  <label class="control-label" for="focusedInput">Mật khẩu cũ</label>
		  <input class="form-control" id="password" type="password" name="password" value="" required pattern=".{4,20}"  title="4 đến 20 ký tự">
		</div>
		<div class="form-group">
		  <label class="control-label" for="focusedInput">Mật khẩu mới</label>
		  <input class="form-control" id="focusedInput" type="password" name="newpassword" value="" required pattern=".{4,20}"  title="4 đến 20 ký tự">
		</div>
		<div class="form-group">
		  <label class="control-label" for="focusedInput">Nhập lại mật khẩu</label>
		  <input class="form-control" id="focusedInput" type="password" name="confirmpassword" value="" required pattern=".{4,20}"  title="4 đến 20 ký tự">
		</div>
        <button class="btn btn-success btn-block"  type="submit">SAVE</button>
        <br>
		</form>
		<?php // echo $this->passwordform?>
		<div class="alert alert-dismissable alert-warning">
		  <button type="button" class="close" data-dismiss="alert">×</button>
		  <h4>Chú ý!</h4>
		  <p>* Sau khi thay đổi mật khẩu thành công, bạn phải đăng nhập lại hệ thống!</p>
		</div>
	</div>						
@endsection



