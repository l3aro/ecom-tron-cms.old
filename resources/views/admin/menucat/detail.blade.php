@extends('admin.layout.main')
@section('title', 'Menu Category')
@section('content')
<div class="breadcrumb">
    <h1>Thông tin danh mục menu</h1>
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
                <label class="control-label" for="focusedInput">Tên danh mục menu</label> 
                <input type="text" name="name" id="name" class="form-control" value="<?=$item->name?>" placeholder="Tên nội dung" required/>
				<small class="form-text text-muted">Đặt tên cho danh mục menu</small>
            </div>            
        </div>
    </div>
</form>
<script>
	$(document).ready(function(){
		$('#menu-menu-cat-detail').parent('li').addClass('active');		
	});
</script>
@endsection