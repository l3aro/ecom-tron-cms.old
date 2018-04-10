@extends('admin.layout.main')
@section('title', 'Video')
@section('content')
<div class="row">
	<div class="col-md-6">
		<h1>Thông tin video</h1>
	</div>
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
<?php  if ($slug_exists) {?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
	<strong>Đã xảy ra lỗi!</strong> URL tối ưu trùng với bài viết khác.
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<?php  } ?>
<div class="clear" style="height: 10px;"></div>
<form id="frm-video-action" method="post" action="/admin/video/detail?id=<?=$category->id?>" enctype="multipart/form-data">
{{ csrf_field() }}
	<div class="save-group-buttons">
		<button name="submit" class="btn btn-sm btn-success"><i class="material-icons">save</i> Lưu</button>
		<a class="btn btn-sm btn-info" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i></a>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<legend>Thông tin cơ bản</legend>
			<div class="form-group">
				<label class="control-label" for="disabledInput">ID</label> <input
					class="form-control" name="id" type="text"
					value="<?=$category->id?>"
					readonly="readonly">
				<small class="form-text text-muted">ID là mã của mục, đây là một thuộc tính duy nhất</small> 
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Tên video</label>
				<input class="form-control" name="name" type="text" required
					value="<?=$category->name?>"
					placeholder="Tên video">
				<small class="form-text text-muted">Tên của video chứa dữ liệu</small>
			</div>
			
			<div class="form-group">
				<label class="control-label" for="focusedInput">Url video</label>
				<input class="form-control" name="url" type="text"
					value="<?=$category->url?>"
					placeholder="Url video">
				<small class="form-text text-muted">Dán đoạn link url đã copy từ youtube vào.</small>
			</div>
			
			<div class="form-group">
				<label class="control-label" for="focusedInput">Link xem thử video đã tạo</label>
				<a href="<?=isset($category)?$category->url:''?>" target="_blank"><?=isset($category)?$category->url:''?></a>
			</div>
			
			<div class="form-group">
				<label class="control-label">Nằm trong mục</label> 
				<select class="form-control" name="cat">
					<option value="0"></option>
					@if(isset($videocat) && count($videocat))
					@foreach ($videocat as $key=>$videocat)
						<option value="<?=$videocat->id?>" <?php echo ($videocat->id == $category->cat)?'selected':'' ?> ><?=$videocat->name?></option>
					@endforeach
					@endif				
				</select>
				<small class="form-text text-muted">Đặt mục cha cho mục dữ liệu này, mục cha ở đây nghĩa là các mục video lớn đã được tạo trước đó.</small>
			</div>
			<div class="form-group">
				<label class="control-label">Trạng thái </label>
				<a class="collapsed" href="#helpmenu" data-toggle="collapse" data-target="#helpmenu">
					<i class="material-icons">help_outline</i>
				</a>	
				<div class="form-group">
					<div class="row">
						<div class="col-md-3"
							<label class="control-label">Hiển thị</label>
							<input type="checkbox" class="checkbox-toggle" name="public" id="public" {{ isset($category)&&$category->public==1?'checked':'' }}/><label class="label-checkbox" for="public">Hiển thị</label>
						</div>
						<div class="col-md-3"
							<label class="control-label">Nổi bật</label>
							<input type="checkbox" class="checkbox-toggle" name="highlight" id="highlight" {{ isset($category)&&$category->highlight==1?'checked':'' }}/><label class="label-checkbox" for="highlight">Nổi bật</label>
						</div>
						<div class="col-md-3"
							<label class="control-label">Mới</label>
							<input type="checkbox" class="checkbox-toggle" name="new" id="new" {{ isset($category)&&$category->new==1?'checked':'' }}/><label class="label-checkbox" for="new">Mới</label>
						</div>
					</div>
				</div>
				<div class="collapse" id="helpmenu" aria-expanded="false">
					<small class="form-text text-muted">Khi tính năng "Hiển thị" được bật, video này sẽ được hiển thị trên giao diện trang web.</small>
					<small class="form-text text-muted">Khi tính năng "Nổi bật" được bật, video này sẽ được hiển thị trên trang chủ hoặc các điểm chỉ định trên giao diện.</small>
					<small class="form-text text-muted">Khi tính năng "Mới" được bật, video này sẽ được hiển thị trên trang chủ hoặc các điểm chỉ định trên giao diện.</small>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<legend>Tối ưu hóa SEO</legend>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Tiêu đề Browser (title)</label>
				<input class="form-control" name="page_title" type="text"
					value="<?php echo isset($category)?$category->page_title:''?>"
					placeholder="Tiêu đề Browser (title)">
				<small class="form-text text-muted">Tiêu đề của trang chủ có tác dụng tốt nhất cho SEO. Thiết lập tiêu để chuẩn SEO sẽ giúp tối ưu hóa tốt hơn.</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Tối ưu hóa URL</label>
				<input class="form-control" name="slug" type="text" value="{{ isset($category)?$category->slug:'' }}" placeholder="Tối ưu URL" pattern="[a-z0-9/-]{5,}">
				<small class="form-text text-muted">Tối ưu đường dẫn URL để tốt nhất cho SEO. Ví dụ: "ten-video" hệ thống tự sinh ra là: http://tenmien.com/ten-video</small>
			</div>			
			<div class="form-group">
				<label class="control-label" for="focusedInput">Thẻ Meta Description</label>
				<input class="form-control" name="meta_des" type="text"
					value="<?php echo isset($category)?$category->meta_des:''?>"
					placeholder="Thẻ Meta Description">
				<small class="form-text text-muted">Thẻ meta description của trang cung cấp cho Google và các công cụ tìm kiếm bản tóm tắt nội dung của trang đó. Trong khi tiêu đề trang có thể là vài từ hoặc cụm từ, thẻ mô tả của trang phải có một hoặc hai câu hoặc một đoạn ngắn. Thẻ meta description là một yếu tố SEO Onpage khá cơ bản cần được tối ưu cẩn thận</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Thẻ Meta keywords</label>
				<input class="form-control" name="meta_keyword" type="text"
					value="<?php echo isset($category)?$category->meta_keyword:''?>"
					placeholder="Thẻ Meta keywords">
				<small class="form-text text-muted">Meta Keywords (Thẻ khai báo từ khóa trong SEO) Trong quá trình biên tập nội dung, Meta Keywords là một thẻ được dùng để khai báo các từ khóa dùng cho bộ máy tìm kiếm. Với thuộc tính này, các bộ máy tìm kiếm (Search Engine) sẽ dễ dàng hiểu nội dung của bạn đang muốn nói đến những vấn đề gì!</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Thẻ Meta Page Topic</label>
				<input class="form-control" name="meta_page_topic" type="text"
					value="<?php echo isset($category)?$category->meta_page_topic:''?>"
					placeholder="Thẻ Meta Page Topic">
				<small class="form-text text-muted">Theo chuẩn SEO, thẻ meta page topic sẽ là tiêu điểm của trang web đang có nội dung nói về chủ đề nào</small>
			</div>
			
			<legend>Ảnh đại diện</legend>
		    <div class="form-group">
				<input class="form-control" name="image" type="file"
					value="" placeholder="Ảnh đại diện">
		    </div>
			<br>
			<?php if(isset($category) && $category->image != ''){?>
			<div class="clear10"></div>
			<br>
		    <img src="/media/video/tb/<?=$category->image ?>" style="max-width: 100%; max-height: 220px" />
		    <div class="clear10"></div>
			<br>
			<button class="btn btn-danger deleteimg" imgdetailid="<?=$category->id ?>" name="deleteimagedetail" value="<?php echo $category->id ?>" type="submit">
				<span class="glyphicon glyphicon-trash"></span> Xóa ảnh đại diện
			</button>
			<?php } ?>
			<input type="hidden" name="oldimage" value="<?php if(isset($category) && $category->image != '') echo $category->image ?>">
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<legend>Nội dung tóm tắt</legend>
		    <div class="form-group">
		        <textarea class="form-control" rows="5" id="textArea1" name="des"><?php echo isset($category)?$category->des:''?></textarea>
		    </div>

			<legend>Mô tả video</legend>
		    <div class="form-group">
		        <textarea class="form-control" rows="5" id="textArea" name="detail"><?php echo isset($category)?$category->detail:''?></textarea>
		    </div>
		</div>
	</div>
	
</form>
<script src="/admins/ckeditor/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		CKEDITOR.replace( 'textArea' );
		CKEDITOR.replace( 'textArea1' );
		$('#menu-add-new-video').parent('li').addClass('active');
		 	$('.deleteimg').click(function(){
				if (confirm('Bạn muốn xóa ảnh này?')){
				var id = $(this).attr('imgdetailid');
				$.ajax({
					url: '/admin/video/deleteimgpro?id=' + id,
					async: false,
					method: 'GET',
					success: function(){
						window.location.href="/admin/video/detail?id=@yeild(id)&lang=@yeild(lang)";
					}
				});
					return false;
				} else {
					return false;
				}
			});
		$("[data-toggle=tooltip]").tooltip();
	});
</script>
@endsection