@extends('admin.layout.main') @section('title', 'Product') @section('content')
<h1>Thông tin sản phẩm</h1>
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
<form id="frm-product-action" method="post" action="/admin/product/detail?id=<?=$product->id?><?=$copy?'&act=copy':''?>" enctype="multipart/form-data">
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
				<input class="form-control" name="id" type="text" value="<?=$product->id?>"
				 readonly="readonly">
				 <small class="form-text text-muted">ID là mã của sản phẩm, đây là một thuộc tính duy nhất</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Tên sản phẩm</label>
				<input class="form-control" name="name" type="text" required value="<?=$product->name?>"
				 placeholder="Tên sản phẩm">
				 <small class="form-text text-muted">Tên của sản phẩm</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Mã sản phẩm</label>
				<input class="form-control" name="product_code" type="text" value="<?=$product->product_code?>"
				 placeholder="Mã sản phẩm">
				 <small class="form-text text-muted">Mã của sản phẩm</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Giá bán lẻ: (đơn vị VNĐ)</label>
				<input class="form-control" name="price" type="number" id="price" title="Nhập số" min="0" value="<?=$product->price?>"
				 placeholder="Giá bán lẻ">
				 <small class="form-text text-muted">Giá bán lẻ được xuất hiện trên website, để 0 sẽ là giá Liên hệ</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Đơn vị trên giá</label>
				<input class="form-control" name="unit" type="text" value="<?=$product->unit?>"
				 placeholder="Đơn vị">
				 <small class="form-text text-muted">VD: 100,000 Đ/ chiếc => nhập "chiếc" HOẶC 200,000 Đ / 10 gói => nhập "10 gói"</small>
			</div>
			<div class="form-group">
				<label class="control-label">Nằm trong mục</label>
				<select class="form-control" name="cat">
					<?=$category_options?>
				</select>
				<small class="form-text text-muted">Chọn mục cho sản phẩm này, bạn không nên để trống</small>
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
							<input type="checkbox" class="checkbox-toggle" name="public" id="public" {{ isset($product)&&$product->public==1?'checked':'' }}/><label class="label-checkbox" for="public">Hiển thị</label>
						</div>
						<div class="col-md-3"
							<label class="control-label">Nổi bật</label>
							<input type="checkbox" class="checkbox-toggle" name="highlight" id="highlight" {{ isset($product)&&$product->highlight==1?'checked':'' }}/><label class="label-checkbox" for="highlight">Nổi bật</label>
						</div>
						<div class="col-md-3"
							<label class="control-label">Mới</label>
							<input type="checkbox" class="checkbox-toggle" name="new" id="new" {{ isset($product)&&$product->new==1?'checked':'' }}/><label class="label-checkbox" for="new">Mới</label>
						</div>
					</div>
				</div>
				<div class="collapse show" id="helpmenu" aria-expanded="false">
					<small class="form-text text-muted">Khi tính năng "Hiển thị" được bật, sản phẩm này sẽ được hiển thị trên giao diện trang web.</small>
					<small class="form-text text-muted">Khi tính năng "Nổi bật" được bật, sản phẩm này sẽ được hiển thị trên trang chủ hoặc các điểm chỉ định trên giao diện.</small>
					<small class="form-text text-muted">Khi tính năng "Mới" được bật, sản phẩm này sẽ được hiển thị trên trang chủ hoặc các điểm chỉ định trên giao diện.</small>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<legend>Tối ưu hóa SEO</legend>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Tiêu đề Browser (title)</label>
				<input class="form-control" name="page_title" type="text" value="<?=$product->page_title?>" placeholder="Tiêu đề Browser (title)">
				<small class="form-text text-muted">Tiêu đề của trang chủ có tác dụng tốt nhất cho SEO. Thiết lập tiêu để chuẩn SEO sẽ giúp tối ưu hóa tốt hơn.</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Tối ưu hóa URL</label>
				<input class="form-control" name="slug" type="text" value="{{ isset($product)?$product->slug:'' }}" placeholder="Tối ưu URL" pattern="[a-z0-9/-]{5,}">
				<small class="form-text text-muted">Tối ưu đường dẫn URL để tốt nhất cho SEO. Ví dụ: "ten-san-pham" hệ thống tự sinh ra là: http://tenmien.com/ten-san-pham</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Thẻ Meta Description</label>
				<input class="form-control" name="meta_des" type="text"	value="<?=$product->meta_des?>" placeholder="Thẻ Meta Description">
				<small class="form-text text-muted">Thẻ meta description của trang cung cấp cho Google và các công cụ tìm kiếm bản tóm tắt nội dung của trang đó. Trong khi tiêu đề trang có thể là vài từ hoặc cụm từ, thẻ mô tả của trang phải có một hoặc hai câu hoặc một đoạn ngắn. Thẻ meta description là một yếu tố SEO Onpage khá cơ bản cần được tối ưu cẩn thận</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Thẻ Meta keywords</label>
				<input class="form-control" name="meta_keyword" type="text" value="<?=$product->meta_keyword?>" placeholder="Thẻ Meta keywords">
				<small class="form-text text-muted">Meta Keywords (Thẻ khai báo từ khóa trong SEO) Trong quá trình biên tập nội dung, Meta Keywords là một thẻ được dùng để khai báo các từ khóa dùng cho bộ máy tìm kiếm. Với thuộc tính này, các bộ máy tìm kiếm (Search Engine) sẽ dễ dàng hiểu nội dung của bạn đang muốn nói đến những vấn đề gì!</small>
			</div>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Thẻ Meta Page Topic</label>
				<input class="form-control" name="meta_page_topic" type="text" value="<?=$product->meta_page_topic?>" placeholder="Thẻ Meta Page Topic">
				<small class="form-text text-muted">Theo chuẩn SEO, thẻ meta page topic sẽ là tiêu điểm của trang web đang có nội dung nói về chủ đề nào</small>
			</div>
		    <div class="form-group">
				<label class="control-label">Ảnh đại diện</label>
				<input class="form-control" name="image" type="file" value="" placeholder="Ảnh đại diện">
				<?php if($product->image){?>
			    <img src="/media/product/<?=$product->image?>" style="max-width: 100%" />
				<button id="btn-delete-image" class="btn btn-danger" imgdetailid="<?=$product->id?>" name="deleteimagedetail" value="<?=$product->id?>" type="submit">
					<span class="glyphicon glyphicon-trash"></span> Xóa ảnh hiện tại
				</button>
				<?php } ?>
				<small class="form-text text-muted">Ảnh sẽ hiển thị trên các trang danh sách. Yêu cầu về ảnh: nhỏ vừa đủ để sử dụng, đúng kích thước tiêu chuẩn.</small>
		    </div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<legend>Nội dung tóm tắt</legend>
			<div class="form-group">
				<textarea class="form-control" rows="5" id="textArea3" name="des"><?=$product->des?></textarea>
			</div>
		</div>
		<div class="col-lg-12">
			<legend>Mô tả sản phẩm</legend>
			<div class="form-group">
				<textarea class="form-control" rows="5" id="textArea2" name="detail"><?=$product->detail?></textarea>
			</div>
		</div>


	</div>
</form>
<?php if($product->id){?>
<div class="row">
	<div class="col-lg-12">
		<legend>Thư viện ảnh liên quan ( Lưu ý : chỉ upload tối đa 10 ảnh )</h3>
		<!-- The file upload form used as target for the file upload widget -->
		<form id="fileupload" method="POST" enctype="multipart/form-data">
			{{ csrf_field() }}
			<input type="hidden" value="<?=$product->id?>" name="pid">
			<!-- Redirect browsers with JavaScript disabled to the origin page -->
			<noscript>
				<input type="hidden" name="redirect" value="/">
			</noscript>
			<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
			<div class="fileupload-buttonbar row" style="margin-bottom: 15px;">
				<div class="col-md-6">
					<div class="fileupload-buttons">
						<!-- The fileinput-button span is used to style the file input field as button -->
						<span class="fileinput-button btn btn-sm btn-info">
							<i class="material-icons">add_a_photo</i>
							<span>Thêm ảnh ...</span>
							<input type="file" name="files[]" multiple>
						</span>
						<button type="submit" class="start btn btn-sm btn-success">
							<i class="material-icons">file_upload</i>
							Upload tất cả
						</button>
						<!-- The global file processing state -->
						<span class="fileupload-process"></span>
					</div>
					<!-- The global progress state -->
					<div class="fileupload-progress fade" style="display:none">
						<!-- The global progress bar -->
						<div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
						<!-- The extended global progress state -->
						<div class="progress-extended">&nbsp;</div>
					</div>
				</div>
				<div class="col-md-6 text-right">
				</div>
			</div>
			<!-- The table listing the files available for upload/download -->
			<div role="presentation">
				<div id="sortable" class="files row"></div>
			</div>
		</form>
		<?php if( isset($productImages) && count($productImages) > 0 ) {?>
		<div class="row">
				<?php
			foreach ( $productImages as $row ) {?>
				<div class="col-lg-3 col-md-4 col-xs-6 p-3 border list-image">
					<a class="d-block mh-100 mw-100" style="height: 250px; overflow: hidden" href="/media/product/<?=$product->id?>/<?php echo $row->image;?>" target="_blank">
						<img src="/media/product/<?=$product->id?>/<?php echo $row->image;?>" style="max-height: 100%">
					</a><br/>
					<a class="btn btn-danger btn-sm delete-product-image" href="javascript:void(0)" imgdetailid="<?=$row->id?>"
							 data-toggle="tooltip" title="Xóa">
								<i class="material-icons">delete</i>
							</a>
				</div>
				<?php }?>
				</div>
		<?php }?>
	</div>
</div>
				<?php } ?>
<!--[if lte IE 8]>
<link rel="stylesheet" href="/admins/css/demo-ie8.css">
<![endif]-->
<!-- blueimp Gallery styles -->
<link rel="stylesheet" href="http://blueimp.github.io/Gallery/css/blueimp-gallery.min.css">
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
<link rel="stylesheet" href="/admins/css/jquery.fileupload.css">
<!-- CSS adjustments for browsers with JavaScript disabled -->
<noscript>
	<link rel="stylesheet" href="/admins/css/jquery.fileupload-noscript.css">
</noscript>
<style type="text/css">
	.fade {
		opacity: 1;
	}

	.template-download img {
		width: 150px;
		height: 100px;
	}
</style>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<div class="template-upload col-lg-3 col-md-4 col-xs-6 p-3 border" id="item_1">
	<span class="preview"></span>
	<p class="name">{%=file.name%}</p>
            <strong class="error"></strong>
	<p class="size">Processing...</p>
            <div class="progress"></div>
	
            {% if (!i && !o.options.autoUpload) { %}
			<button class="start btn btn-success" disabled><i class="material-icons">file_upload</i>Bắt đầu upload</button>
		{% } %}
		{% if (!i) { %}
			<button class="cancel btn btn-danger"><i class="material-icons">cancel</i>Hủy</button>
		{% } %}
</div>
{% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
<div class="col-lg-3 col-md-4 col-xs-6 p-3 border">
                {% if (file.thumbnailUrl) { %}
	<a class="d-block mh-100 mw-100" style="height: 250px; overflow: hidden" href="{%=file.url%}" title="{%=file.name%}" target="_blank">
		<img src="{%=file.thumbnailUrl%}" style="max-height: 100%">
	</a>
	<a class="btn btn-success btn-sm" href="#">
								 	<i class="material-icons">check_circle</i> Upload thành công
								</a>
                {% } %}
            {% if (file.error) { %}
                <div><span class="error">Error</span> {%=file.error%}</div>
            {% } %}
</div>
{% } %}
</script>
<script src="/admins/js/js-upload/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="/admins/js/js-upload/load-image.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="/admins/js/js-upload/canvas-to-blob.min.js"></script>
<!-- blueimp Gallery script -->
<script src="/admins/js/js-upload/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="/admins/js/js-upload/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="/admins/js/js-upload/jquery.fileupload.js"></script>
<!-- The File Upload processing plugin -->
<script src="/admins/js/js-upload/jquery.fileupload-process.js"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="/admins/js/js-upload/jquery.fileupload-image.js"></script>
<!-- The File Upload audio preview plugin -->
<script src="/admins/js/js-upload/jquery.fileupload-audio.js"></script>
<!-- The File Upload video preview plugin -->
<script src="/admins/js/js-upload/jquery.fileupload-video.js"></script>
<!-- The File Upload validation plugin -->
<script src="/admins/js/js-upload/jquery.fileupload-validate.js"></script>
<!-- The File Upload user interface plugin -->
<script src="/admins/js/js-upload/jquery.fileupload-ui.js"></script>
<script src="/admins/ckeditor/ckeditor.js"></script>
<script>
	var CSRF_TOKEN = $('[name="_token"]').val();
	$(function () {
		'use strict';
		$('#fileupload').fileupload({
			// Uncomment the following to send cross-domain cookies:
			//xhrFields: {withCredentials: true},
			url: '/admin/product/uploadImage'
			, limitMultiFileUploads: 10
		});
	});
	$(document).ready(function () {
		$('#menu-add-new-product').parent('li').addClass('active');

		CKEDITOR.replace('textArea2');
		CKEDITOR.replace('textArea3');
		$('#btn-delete-image').click(function(e){
			e.preventDefault();
			if (confirm('Bạn muốn xóa ảnh này?')){
				var id = $(this).attr('imgdetailid');
				$.ajax({
					url: '/admin/product/deleteimage?id=' + id,
					async: false,
					method: 'GET',
					success: function(){
						window.location.href="/admin/product/detail?id=<?=$product->id ?>";
					}
					});
			} else {
				return false;
			}
		});
		$('.delete-product-image').click(function(e){
			e.preventDefault();
			if (confirm('Bạn muốn xóa ảnh này?')){
				var id = $(this).attr('imgdetailid');
				var button = $(this);
				$.ajax({
					url: '/admin/product/deleteproductimage?id=' + id,
					async: false,
					method: 'GET',
					success: function(){
						button.parents('.list-image').remove();
					}
					});
			} else {
				return false;
			}
		});
	});
</script>
@endsection