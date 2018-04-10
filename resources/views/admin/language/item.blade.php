@extends('admin.layout.main')
@section('title', 'Language')
@section('content')
<?php  if ($saved) {?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>Lưu dữ liệu thành công!</strong> Dữ liệu đã được lưu vào cơ sở dữ liệu.
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<?php  } ?>
<h1>Quản lý ngôn ngữ</h1>
<FORM id="formvalidate" name="form_system" action="/admin/language/item?id=<?=$itemlang->id?>" method="post" enctype="multipart/form-data" >
{{ csrf_field() }}
	<INPUT type="hidden" name="id" value="<?=$itemlang->id?>">
	<INPUT type="hidden" name="language" value="<?=$itemlang->name?>">
    
    <div class="save-group-buttons">
        <button class="btn btn-sm" onclick="window.location = '/admin/language'; return false;">
            <i class="material-icons">reply</i>Quay lại
        </button>
		<button name="submit" class="btn btn-sm btn-success"><i class="material-icons">save</i> Lưu</button>
		<a class="btn btn-sm btn-info" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i></a>
	</div>

	<DIV class="clear10" style="height: 10px;"></DIV>
	<div class="row">
		<div class="col-lg-6">
			<div class="form-group">
				<label class="control-label" for="focusedInput">Tên ngôn ngữ</label> 
				<INPUT type="text" name="name" id="name" class="form-control"  value="<?=$itemlang->name?>"  placeholder="Tên ngôn ngữ" required />
                <small class="form-text text-muted">Tên của loại ngôn ngữ(ví dụ: Tiếng Việt, Tiếng Anh,..)</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Viết tắt (2 kí tự, VD: vi)</label> 
				<INPUT type="text" name="short_name" id="shortname" maxlength="2" class="form-control" value="<?=$itemlang->short_name?>" placeholder="Viết tắt" required/>
                <small class="form-text text-muted">Tên viết tắt của loại ngôn ngữ(ví dụ: vi, en,..)</small>
			</div>
		</div>
		<div class="col-lg-6">
			<h3 style="margin-bottom:0;">Biểu tượng</h3>
			<div class="form-group">
				<INPUT class="form-control" type="file" name="image">
                <?php if($itemlang->image){?>
                <img src="/media/lang/<?=$itemlang->image?>" style="max-width: 100%" />
                <br>
				<button id="btn-delete-image" class="btn btn-danger" imgdetailid="<?=$itemlang->id?>" name="deleteimagedetail" value="<?=$itemlang->id?>" type="submit">
					<span class="glyphicon glyphicon-trash"></span> Xóa ảnh hiện tại
				</button>
				<?php } ?>
				<small class="form-text text-muted">Ảnh sẽ hiển thị trên các trang web. Yêu cầu về ảnh: nhỏ vừa đủ để sử dụng, đúng kích thước tiêu chuẩn.</small>
			</div>
		</div>
	</div>
</FORM>
<script>
	$(document).ready(function(){
		$('#menu-language').parent('li').addClass('active');
		$('#btn-delete-image').click(function(e){
			e.preventDefault();
			if (confirm('Bạn muốn xóa ảnh này?')){
			var id = $(this).attr('imgdetailid');
			$.ajax({
				url: '/admin/language/item/deletelangimage?id=' + id,
				async: false,
				method: 'GET',
				success: function(){
					window.location.href="/admin/language/item?id=<?=$itemlang->id ?>";
				}
				});
			} else {
				return false;
			}
		});
	});
</script>

@endsection