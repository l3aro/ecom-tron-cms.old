@extends('admin.layout.main')
@section('title', 'User')
@section('content')
<h1>Thông tin User</h1>
<?php  if ($saved) {?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>Lưu dữ liệu thành công!</strong> Dữ liệu đã được lưu vào cơ sở dữ liệu.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<?php  } ?>
<form id="frm-product-action" method="post" action="" enctype="multipart/form-data">
{{ csrf_field() }}
	<div class="save-group-buttons">
		<button name="submit" class="btn btn-success btn-sm"><i class="material-icons">save</i>Lưu</button>
		<a class="btn btn-sm btn-info" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i> </a>
	</div>
	<div class="row">
		<div class="col-lg-4">
			<div class="form-group">
				<h3 style="margin-bottom:0px;">Ảnh đại diện</h3>
				<br> 
                <?php if($profile->image){?>
                <img src="/media/user/<?=$profile->image?>" style="max-width: 100%" />
                <br>
				<?php } ?>
				<br>
				<INPUT class="form-control" type="file" name="image">
				<small class="form-text text-muted">Ảnh avatar.</small>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="form-group">
				<label class="control-label" for="focusedInput">Họ tên</label>
				<input class="form-control" name="name" type="text" required value="<?=$profile->name?>" placeholder="Họ và tên">
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Chức vụ</label>
				<input class="form-control" name="position" type="text" required value="<?=$profile->position?>" placeholder="Chức vụ">
			</div>
            <div class="form-group">
				<label class="control-label" for="focusedInput">Phone number</label>
				<input class="form-control" name="mobile" type="phone" value="<?=$profile->mobile?>"
					placeholder="Số điện thoại">
			</div>
            <div class="form-group">
				<label class="control-label" for="focusedInput">Email</label>
				<input class="form-control" name="email" type="email" value="<?=$profile->email?>"
					placeholder="abc@gmail.com">
			</div>
            <div class="form-group">
				<label class="control-label" for="focusedInput">Address</label>
				<input class="form-control" name="address" type="text" value="<?=$profile->address?>"
					placeholder="Địa chỉ">
			</div>
            <div class="form-group">
				<label class="control-label" for="focusedInput">Skype</label>
				<input class="form-control" name="skype" type="text" value="<?=$profile->skype?>"
					placeholder="Skype">
			</div>
            <div class="form-group">
				<label class="control-label" for="focusedInput">Birth day</label>
				<input class="form-control" name="birthday" type="date" id="birthday" value="<?=$profile->birthday?>"
					placeholder="Sinh nhật">
			</div>
        </div>
    </div>
</form>
<script type="text/javascript">
	$(document).ready(function() {
		$('#btn-delete-image').click(function(e){
				e.preventDefault();
				if (confirm('Bạn muốn xóa ảnh này?')){
				var id = $(this).attr('imgdetailid');
				$.ajax({
					url: '/admin/user/profile/deletelangimage?id=' + id,
					async: false,
					method: 'GET',
					success: function(){
						window.location.href="/admin/user/profile?id=<?=$profile->id ?>";
					}
					});
				} else {
					return false;
				}
			});
	});
</script>
@endsection