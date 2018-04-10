@extends('admin.layout.main') 
@section('title', 'Article') 
@section('content')
<div class="breadcrumb">
	<h1>Thông tin bài viết</h1>
</div>

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
	<strong>Đã xảy ra lỗi!</strong> URL tối ưu trùng với bài viết khác.
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<?php  } ?>

<form method="post" action="/admin/article/detail/{{ isset($article)?$article->id:'' }}" enctype="multipart/form-data">
{{ csrf_field() }}
	<div class="save-group-buttons">
		<button name="submit" class="btn btn-sm btn-success"><i class="material-icons">save</i> Lưu</button>
		<a class="btn btn-sm btn-info" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i></a>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<legend>Thông tin cơ bản</legend>
			<div class="form-group">
				<label class="control-label" for="disabledInput">ID</label>
				<input class="form-control" name="id" type="text" value="{{ isset($article)?$article->id:'' }}" readonly="readonly">
				<input type="hidden" name="lang" value="vi" />
				<small class="form-text text-muted">ID là mã của tin bài, đây là một thuộc tính duy nhất</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Tiêu đề bài viết</label>
				<input class="form-control" name="name" type="text" required value="{{ isset($article)?$article->name:'' }}" placeholder="Tiêu đề bài viết">
				<small class="form-text text-muted">Tên của tin bài</small>
			</div>
			<div class="form-group">
				<label class="control-label">Nằm trong mục</label>
				<select class="form-control" name="cat">
					<?=$list_cat?>
				</select>
				<small class="form-text text-muted">Chọn mục cho dữ liệu này, bạn không nên để trống</small>
			</div>
			<div class="form-group">
				<label class="control-label">Hiển thị</label>
				<input type="checkbox" class="checkbox-toggle" name="public" id="public" {{ isset($article)&&$article->public==1?'checked':'' }}/><label class="label-checkbox" for="public">Hiển thị</label>
				<small class="form-text text-muted">Khi tính năng "Hiển thị" được bật, bài viết này sẽ được hiển thị trên giao diện trang web.</small>
			</div>
			<div class="form-group">
				<label class="control-label">Nổi bật</label>
				<input type="checkbox" class="checkbox-toggle" name="highlight" id="highlight" {{ isset($article)&&$article->highlight==1?'checked':'' }}/><label class="label-checkbox" for="highlight">Nổi bật</label>
				<small class="form-text text-muted">Khi tính năng "Nổi bật" được bật, bài viết này sẽ được hiển thị trên trang chủ hoặc các điểm chỉ định trên giao diện.</small>
			</div>
			<div class="form-group">
				<label class="control-label">Mới</label>
				<input type="checkbox" class="checkbox-toggle" name="new" id="new" {{ isset($article)&&$article->new==1?'checked':'' }}/><label class="label-checkbox" for="new">Mới</label>
				<small class="form-text text-muted">Khi tính năng "Mới" được bật, bài viết này sẽ được hiển thị trên trang chủ hoặc các điểm chỉ định trên giao diện.</small>
			</div>
		</div>
		<div class="col-lg-6">
			<legend>Tối ưu hóa SEO</legend>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Tiêu đề Browser (title)</label>
				<input class="form-control" name="page_title" type="text" value="{{ isset($article)?$article->page_title:'' }}" placeholder="Tiêu đề Browser (title)">
				<small class="form-text text-muted">Tiêu đề của trang có tác dụng tốt nhất cho SEO. Thiết lập tiêu để chuẩn SEO sẽ giúp tối ưu hóa tốt hơ</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Tối ưu hóa URL</label>
				<input class="form-control" name="slug" type="text" value="{{ isset($article)?$article->slug:'' }}" placeholder="Tối ưu URL" pattern="[a-z0-9/-]{5,}">
				<small class="form-text text-muted">Tối ưu đường dẫn URL để tốt nhất cho SEO. Ví dụ: "ten-bai-viet" hệ thống tự sinh ra là: http://tenmien.com/ten-bai-viet</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Thẻ Meta Description</label>
				<input class="form-control" name="meta_des" type="text" value="{{ isset($article)?$article->meta_des:'' }}" placeholder="Thẻ Meta Description">
				<small class="form-text text-muted">Thẻ meta description của trang cung cấp cho Google và các công cụ tìm kiếm bản tóm tắt nội dung của trang đó. Trong khi tiêu đề trang có thể là vài từ hoặc cụm từ, thẻ mô tả của trang phải có một hoặc hai câu hoặc một đoạn ngắn. Thẻ meta description là một yếu tố SEO Onpage khá cơ bản cần được tối ưu cẩn thận</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Thẻ Meta keywords</label>
				<input class="form-control" name="meta_keyword" type="text" value="{{ isset($article)?$article->meta_keyword:'' }}" placeholder="Thẻ Meta keywords">
				<small class="form-text text-muted">Meta Keywords (Thẻ khai báo từ khóa trong SEO) Trong quá trình biên tập nội dung, Meta Keywords là một thẻ được dùng để khai báo các từ khóa dùng cho bộ máy tìm kiếm. Với thuộc tính này, các bộ máy tìm kiếm (Search Engine) sẽ dễ dàng hiểu nội dung của bạn đang muốn nói đến những vấn đề gì!</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Thẻ Meta Page Topic</label>
				<input class="form-control" name="meta_page_topic" type="text" value="{{ isset($article)?$article->meta_page_topic:'' }}" placeholder="Thẻ Meta Page Topic">
				<small class="form-text text-muted">Theo chuẩn SEO, thẻ meta page topic sẽ là tiêu điểm của trang web đang có nội dung nói về chủ đề nào</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Ảnh đại diện bài viết</label>
				<input class="form-control" name="image" type="file" value="" placeholder="Ảnh đại diện">
				<small class="form-text text-muted">Ảnh sẽ hiển thị trên các trang danh sách. Yêu cầu về ảnh: nhỏ vừa đủ để sử dụng, đúng kích thước tiêu chuẩn.</small>
			</div>
			@if(!empty($article->image))
			<div class="form-group text-center">
				<input type="hidden" name="current_image" value="<?=$article->image?>">
				<img src="{{ isset($article->image)?URL::asset('media/article/'.$article->image):'' }}" width="auto" height="300"/>
				<button id="btn-delete-image" class="btn btn-danger" imgdetailid="<?=$article->id?>" name="deleteimagedetail" value="<?=$article->id?>" type="submit">
					<span class="glyphicon glyphicon-trash"></span> Xóa ảnh hiện tại
				</button>
			</div>
			@endif
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<legend>Nội dung mô tả</legend>
			<div class="form-group">
				<textarea name="des" class="form-control use-ck-editor-advance" rows="15" id="textAreaDes">{{ isset($article)?$article->des:'' }}</textarea>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-md-12">
			<legend>Nội dung chi tiết</legend>
			<div class="form-group">
				<textarea name="detail" class="form-control use-ck-editor-advance" rows="15" id="textAreaDetail">{{ isset($article)?$article->detail:'' }}</textarea>
			</div>
		</div>
	</div>
</form>
<script src="/admins/ckeditor/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		
		$('#menu-add-new-article').parent('li').addClass('active');
		CKEDITOR.replace( 'textAreaDes' );
		$('#btn-delete-image').click(function(e){
			e.preventDefault();
			if (confirm('Bạn muốn xóa ảnh này?')){
			var id = $(this).attr('imgdetailid');
			$.ajax({
				url: '/admin/article/delete_image?id=' + id,
				async: false,
				method: 'GET',
				success: function(){
					window.location.reload();
				}
				});
			} else {
				return false;
			}
		});
		CKEDITOR.replace( 'textAreaDetail' );
		$('#btn-delete-image').click(function(e){
			e.preventDefault();
			if (confirm('Bạn muốn xóa ảnh này?')){
			var id = $(this).attr('imgdetailid');
			$.ajax({
				url: '/admin/article/delete_image/' + id,
				async: false,
				method: 'GET',
				success: function(){
					window.location.href="/admin/article/detail/<?=$article->id?>";
				}
				});
			} else {
				return false;
			}
		});
	});
</script>
@endsection