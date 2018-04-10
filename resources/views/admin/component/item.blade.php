@extends('admin.layout.main')
@section('title', 'Contact')
@section('content')
<div class="breadcrumb">
    <h1>Thông tin nội dung phụ</h1>
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
                <label class="control-label" for="focusedInput">Tên nội dung</label> 
                <input type="text" name="name" id="name" class="form-control" value="<?=$item->name?>" placeholder="Tên nội dung" required/>
				<small class="form-text text-muted">Đặt tên cho nội dung</small>
            </div>
            <div class="form-group">
                <label class="control-label" for="focusedInput">Ngôn ngữ</label>
                <input type="text" name="language" id="language" class="form-control" value="<?=$item->language?>" readonly="readonly" />
				<small class="form-text text-muted">Ngôn ngữ của trang(Ví dụ:Tiếng Việt,Tiếng Anh)</small>
            </div>            
        </div>
    </div>
    <div class="form-group">
		<label class="control-label">Trạng thái hiển thị</label>
		<input type="checkbox" class="checkbox-toggle"  name="public" id="switch" <?php if($item->public == 1) echo 'checked="checked"'?> /><label class="label-checkbox" for="switch">Nổi bật</label>
		<small class="form-text text-muted">Khi tính năng được bật, danh mục này sẽ được hiển thị trên trang chủ hoặc các điểm chỉ định trên giao diện.</small>
	</div>
    <div class="row">
		<div class="col-md-12">
			<legend>Nội dung</legend>
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
		$('#menu-common-page').parent('li').addClass('active');
		
		$(".checkdel").change(function(){
	        if ($('input.checkdel:checkbox:checked').length == $('input.checkdel:checkbox').length){
		        $('#btn-ck-all i').text('check_box')
	        } else if ($('input.checkdel:checkbox:checked').length > 0) {
		        $('#btn-ck-all i').text('indeterminate_check_box')
	        } else {
		        $('#btn-ck-all i').text('check_box_outline_blank')
	        }
		});

		$('button[cms-change-field="changfield"]').click(function(){
			var obj = $(this);
			var currentvalue = $(this).attr('currentvalue');
			var id = $(this).attr('item-id');
			var field = $(this).attr('field');
			$.ajax({
				  url: '',
				  success: function(data) {
				  	if (currentvalue==0) { 
				  		pic = 'check';
				  		currentvalue = 1;
				  		tooltip = 'Click để tắt';
				  		cl = 'btn-success';
				  	} else { 
				  		pic = 'close';
				  		currentvalue = 0;
				  		tooltip = 'Click để bật';
				  		cl = '';
				  	}
				  	obj.attr('currentvalue', currentvalue);
				  	obj.attr('class', 'btn-sm btn ' + cl + ' editmenu');
					obj.html('<i class="material-icons">' + pic + '</i>');
				  	obj.attr('data-original-title', tooltip);
				  }
				});
		});
		
	});
</script>
@endsection