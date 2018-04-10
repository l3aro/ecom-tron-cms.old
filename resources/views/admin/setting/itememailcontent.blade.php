@extends('admin.layout.main')
@section('title', 'Setting')
@section('content')
<div class="breadcrumb">
    <h1>Nội dung email</h1>
</div>
<div class="clear" style="height: 10px;"></div>
<?php  if ($saved) {?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>Lưu dữ liệu thành công!</strong> Dữ liệu đã được lưu vào cơ sở dữ liệu.
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<?php  } ?>
<div class="clear" style="height: 10px;"></div>
<form method="post" action="" enctype="multipart/form-data">
{{ csrf_field() }}
	<div class="save-group-buttons">
		<button name="submit" class="btn btn-sm btn-success"><i class="material-icons">save</i> Lưu</button>
		<a class="btn btn-sm btn-info" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i></a>
	</div>
    <div class="row">
        <div class="col-lg-12">            
            <div class="form-group ">
                <label class="control-label" for="focusedInput">Email được gửi khi</label> 
                <input type="text" name="send_when" id="send_when" class="form-control" value="<?=$item->send_when?>" placeholder="Thời điểm email được gửi đi" required/>
				<small class="form-text text-muted">Email sẽ được gửi đi khi có khách liên hệ trực tuyến hay qua website hoặc online</small>
            </div>
            <div class="form-group ">
                <label class="control-label" for="focusedInput">Các giá trị cần có trong nội dung</label> 
                <input type="text" name="need_value" id="need_value" class="form-control" value="<?=$item->need_value?>" placeholder="Các giá trị cần có trong nội dung" required/>
				<small class="form-text text-muted">Các giá trị cần có trong nội dung.Ví dụ:Tên,số điện thoại,địa chỉ...</small>
            </div>
            <div class="form-group ">
                <label class="control-label" for="focusedInput">Tiêu đề</label> 
                <input type="text" name="name" id="name" class="form-control" value="<?=$item->name?>" placeholder="Tiêu đề" required/>
				<small class="form-text text-muted">Tiêu đề của email gửi đi</small>
            </div>          
        </div>
    </div>

    <div class="row">
		<div class="col-md-12">
			<legend>Chi tiết</legend>
			<div class="form-group">
				<textarea name="detail" class="form-control use-ck-editor-advance" rows="15" id="textArea"><?=$item->detail?></textarea>
			</div>
		</div>
	</div>
</form>
<script src="/admins/ckeditor/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		CKEDITOR.replace( 'textArea' );
		$('#menu-setting-emailcontent').parent('li').addClass('active');		
	});
</script>

@endsection