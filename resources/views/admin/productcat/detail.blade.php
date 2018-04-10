@extends('admin.layout.main')
@section('title', 'Product Category')
@section('content')
<h1> Thông tin danh mục sản phẩm </h1>
<?php  if ($saved) {?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>Lưu dữ liệu thành công!</strong> Dữ liệu đã được lưu vào cơ sở dữ liệu.
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<?php  } ?>
<?php  if ($slug_exists) {?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	<strong>Đã xảy ra lỗi!</strong> URL tối ưu trùng với mục khác.
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<?php  } ?>
<form method="post" action="/admin/productcat/detail?id=<?=$category->id?>" enctype="multipart/form-data">
{{ csrf_field() }}
	<div class="save-group-buttons">
		<button name="submit" class="btn btn-sm btn-success"><i class="material-icons">save</i> Lưu</button>
		<a class="btn btn-sm btn-info" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i> </a>
	</div>
	<div class="row">
		<div class="col-md-6">
			<legend>Thông tin cơ bản</legend>
			<div class="form-group">
				<label class="control-label" for="disabledInput">ID</label> 
				<input class="form-control" name="id" type="text" value="<?=$category->id?>" readonly="readonly">
				<small class="form-text text-muted">ID là mã của mục, đây là một thuộc tính duy nhất</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Tên mục</label>
				<input class="form-control" name="name" type="text" required value="<?=$category->name?>" placeholder="Tên mục">
				<small class="form-text text-muted">Tên của thư mục chứa dữ liệu</small>
			</div>
			<div class="form-group">
				<label class="control-label">Mục này nằm trong mục</label>
				<select class="form-control" name="parent">
					<?=$category_options?>
				</select>
				<small class="form-text text-muted">Đặt mục cha cho mục dữ liệu này, bạn có thể để trống để hiểu rằng đây là mục lớn nhất</small>
			</div>
			<div class="form-group">
				<label class="control-label">Hiển thị nổi bật</label>
				<input type="checkbox" class="checkbox-toggle" name="highlight" id="switch" <?php if($category->highlight == 1) echo 'checked="checked"'?>/><label class="label-checkbox" for="switch">Nổi bật</label>
				<small class="form-text text-muted">Khi tính năng được bật, danh mục này sẽ được hiển thị trên trang chủ hoặc các điểm chỉ định trên giao diện.</small>
			</div>
		    <div class="form-group">
				<label class="control-label">Ảnh đại diện</label>
				<input class="form-control" name="image" type="file" value="" placeholder="Ảnh đại diện">
				<?php if($category->image){?>
			    <img src="/media/product_cat/<?=$category->image?>" style="max-width: 100%" />
				<button id="btn-delete-image" class="btn btn-danger" imgdetailid="<?=$category->id?>" name="deleteimagedetail" value="<?=$category->id?>" type="submit">
					<span class="glyphicon glyphicon-trash"></span> Xóa ảnh hiện tại
				</button>
				<?php } ?>
				<small class="form-text text-muted">Ảnh sẽ hiển thị trên các trang danh sách. Yêu cầu về ảnh: nhỏ vừa đủ để sử dụng, đúng kích thước tiêu chuẩn.</small>
		    </div>
		</div>
		
		<div class="col-md-6">
			<legend>Tối ưu hóa SEO</legend>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Tiêu đề Browser (title)</label>
				<input class="form-control" name="page_title" type="text" value="<?=$category->page_title?>" placeholder="Tiêu đề Browser (title)">
				<small class="form-text text-muted">Tiêu đề của trang chủ có tác dụng tốt nhất cho SEO. Thiết lập tiêu để chuẩn SEO sẽ giúp tối ưu hóa tốt hơn.</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Tối ưu hóa URL</label>
				<input class="form-control" name="slug" type="text" value="{{ isset($category)?$category->slug:'' }}" placeholder="Tối ưu URL" pattern="[a-z0-9/-]{5,}">
				<small class="form-text text-muted">Tối ưu đường dẫn URL để tốt nhất cho SEO. Ví dụ: "ten-muc" hệ thống tự sinh ra là: http://tenmien.com/ten-muc</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Thẻ Meta Description</label>
				<input class="form-control" name="meta_des" type="text"	value="<?=$category->meta_des?>" placeholder="Thẻ Meta Description">
				<small class="form-text text-muted">Thẻ meta description của trang cung cấp cho Google và các công cụ tìm kiếm bản tóm tắt nội dung của trang đó. Trong khi tiêu đề trang có thể là vài từ hoặc cụm từ, thẻ mô tả của trang phải có một hoặc hai câu hoặc một đoạn ngắn. Thẻ meta description là một yếu tố SEO Onpage khá cơ bản cần được tối ưu cẩn thận</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Thẻ Meta keywords</label>
				<input class="form-control" name="meta_keyword" type="text" value="<?=$category->meta_keyword?>" placeholder="Thẻ Meta keywords">
				<small class="form-text text-muted">Meta Keywords (Thẻ khai báo từ khóa trong SEO) Trong quá trình biên tập nội dung, Meta Keywords là một thẻ được dùng để khai báo các từ khóa dùng cho bộ máy tìm kiếm. Với thuộc tính này, các bộ máy tìm kiếm (Search Engine) sẽ dễ dàng hiểu nội dung của bạn đang muốn nói đến những vấn đề gì!</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Thẻ Meta Page Topic</label>
				<input class="form-control" name="meta_page_topic" type="text" value="<?=$category->meta_page_topic?>" placeholder="Thẻ Meta Page Topic">
				<small class="form-text text-muted">Theo chuẩn SEO, thẻ meta page topic sẽ là tiêu điểm của trang web đang có nội dung nói về chủ đề nào</small>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<legend>Nội dung mô tả</legend>
			<div class="form-group">
				<textarea name="des" class="form-control use-ck-editor-advance" rows="15" id="textArea"><?=$category->des?></textarea>
			</div>
		</div>
	</div>
		
</form>
<script src="/admins/ckeditor/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		CKEDITOR.replace( 'textArea' );
		$('#menu-add-cat-product').parent('li').addClass('active');
		$('#btn-delete-image').click(function(e){
			e.preventDefault();
			if (confirm('Bạn muốn xóa ảnh này?')){
			var id = $(this).attr('imgdetailid');
			$.ajax({
				url: '/admin/productcat/deleteimage?id=' + id,
				async: false,
				method: 'GET',
				success: function(){
					window.location.href="/admin/productcat/detail?id=<?=$category->id ?>";
				}
				});
			} else {
				return false;
			}
		});
	});
</script>


@endsection