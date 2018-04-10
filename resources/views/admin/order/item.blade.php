@extends('admin.layout.main')
@section('title', 'Order')
@section('content')

<h1> Thông tin đơn hàng </h1>
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
        <div class="col-lg-6">
            <legend>Thông tin khách hàng</legend>
            <div class="form-group">
                <label class="control-label" for="focusedInput">Tên khách hàng</label> 
                <input type="text" name="name" id="name" class="form-control" value="<?=$item->name?>" placeholder="Họ và tên" required/>
                <small class="form-text text-muted">Họ và tên của khách hàng đặt hàng</small>
            </div>
            <div class="form-group">
                <label class="control-label" for="focusedInput">Email</label> 
                <input type="email" name="email" id="email" class="form-control" value="<?=$item->email?>" placeholder="leotive@gmail.com" required/>
                <small class="form-text text-muted">Địa chỉ email của khách hàng</small>
            </div>
            <div class="form-group">
                <label class="control-label" for="focusedInput">Địa chỉ</label> 
                <input type="text" name="address" id="address" class="form-control" value="<?=$item->address?>" placeholder="Địa chỉ" required/>
                <small class="form-text text-muted">Địa chỉ của khách hàng</small>
            </div>
            <div class="form-group">
                <label class="control-label" for="focusedInput">Điện thoại</label> 
                <input type="tel" name="phone" id="phone" class="form-control" value="<?=$item->phone?>" placeholder="Số điện thoại" required/>
                <small class="form-text text-muted">Số điện thoại liên lạc của khách hàng</small>
            </div>
        </div>
        <div class="col-lg-6">
            <legend>Thông tin đơn hàng</legend>
            <div class="form-group">
                <label class="control-label" for="focusedInput">Tổng đơn hàng</label> 
                <input type="text" name="total" id="total" class="form-control" value="<?=$item->total?>" readonly="readonly" />
                <small class="form-text text-muted">Tổng số đơn hàng mà khách hàng đã đặt</small>
            </div>
            <div class="form-group">
					<label class="control-label" for="focusedInput">Nội dung</label> 
					<textarea rows="5" name="content" class="form-control"></textarea>
                    <small class="form-text text-muted">Nội dung của đơn hàng</small>
			</div>
            <div class="form-group">
					<label class="control-label" for="focusedInput">Tình trạng</label> 
					<input type="checkbox" class="checkbox-toggle" name="highlight" id="switch" /><label class="label-checkbox" for="switch">Đã xử lý</label>
                    <small class="form-text text-muted">Tình trạng đơn hàng đã xử lý chưa</small>
			</div>
        </div>
    </div>
</form>
<div class="clear" style="height: 10px;"></div>
<form id="delform" action="" method="post" >
{{ csrf_field() }}
		<table class="table table-striped table-hover" id="table_content" cellspacing="1" cellpadding="1" width="100%">
			<thead>
				<tr>
					<th>Mã SP</th>
					<th>Ảnh SP</th>
					<th>Tên sản phẩm</th>
					<th>Đơn vị</th>
                    <th>Số lượng</th>
                    <th>Đơn giá</th>
                    <th>Thành tiền</th>
				</tr>
			</thead>
           
        </table>
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