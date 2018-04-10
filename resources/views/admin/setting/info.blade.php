@extends('admin.layout.main')
@section('title', 'Setting')
@section('content')
<h1> Thiết lập thông tin</h1><br>
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
        <label class="control-label" for="focusedInput">Tên miền</label> 
        <input type="text" name="company_website_url" id="website" class="form-control" value="<?=$setting->company_website_url?>" placeholder="Website" required/>
        <small class="form-text text-muted">Tên miền chính của website đang thực chạy</small>
    </div>
    <div class="form-group">
        <label class="control-label" for="focusedInput">Tên công ty</label> 
        <input type="text" name="company_name" id="comname" class="form-control" value="<?=$setting->company_name?>" placeholder="Tên công ty" required/>
        <small class="form-text text-muted">Tên công ty sở hữu website. Thông tin sẽ hiển thị trên website</small>
    </div>
    <div class="form-group">
        <label class="control-label" for="focusedInput">Địa chỉ</label> 
        <input type="text" name="company_address" id="address" class="form-control" value="<?=$setting->company_address?>" placeholder="Địa chỉ" required/>
        <small class="form-text text-muted">Địa chỉ của công ty. Thông tin sẽ hiển thị trên website</small>
    </div>
    <div class="form-group">
        <label class="control-label" for="focusedInput">Điện thoại</label> <br>
        <input type="tel" name="company_tel" id="phone" class="form-control" value="<?=$setting->company_tel?>" placeholder="Điện thoại" required/>
        <small class="form-text text-muted">Điện thoại liên hệ tới công ty (Số máy bàn). Thông tin sẽ hiển thị trên website</small>
    </div>
    <div class="form-group">
        <label class="control-label" for="disabledInput">Hotline</label> 
        <input type="tel" name="company_hotline" id="hotline" class="form-control" value="<?=$setting->company_hotline?>" placeholder="Hotline" required/>
        <small class="form-text text-muted">Số điện thoại hotline. Thông tin sẽ hiển thị trên website, có thể hiển thị đính kèm website và chạy theo dọc trang web để khách hàng luôn nhìn thấy số HOTLINE</small>
    </div>
    <div class="form-group">
        <label class="control-label" for="disabledInput">Điện thoại di động</label> 
        <input type="tel" name="company_mobile" id="mobile" class="form-control" value="<?=$setting->company_mobile?>" placeholder="Mobile" required/>
        <small class="form-text text-muted">Số điện thoại di động để liên hệ với công ty. Thông tin sẽ hiển thị trên website</small>
    </div>
    <div class="form-group">
        <label class="control-label" for="disabledInput">Email</label> 
        <input type="email" name="company_email" id="email" class="form-control" value="<?=$setting->company_email?>" placeholder="Email" required/>
        <small class="form-text text-muted">Địa chỉ email chính của công ty. Thông tin sẽ hiển thị trên website</small>
    </div>
    <div class="form-group">
        <label class="control-label" for="disabledInput">Facebook</label> 
        <input type="text" name="company_facebook_url" id="facebook" class="form-control" value="<?=$setting->company_facebook_url?>" placeholder="Facebook Link" required/>
        <small class="form-text text-muted">Địa chỉ trang facebook của công ty. Thông tin sẽ hiển thị trên website là một đường dẫn tới trang Facebook Fanpage, thông tin này có thể sử dụng để thiết lập Facebook Fanpage Likebox</small>
    </div>
</div>
</div>
</form>
<script type="text/javascript">
$(document).ready(function() {
$('#menu-setting-index').parent('li').addClass('active');
});
</script>
@endsection