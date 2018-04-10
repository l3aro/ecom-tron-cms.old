@extends('admin.layout.main') @section('title', 'Dashboard') @section('content')
<h1>Upload nhiều ảnh nhiều ảnh cho thư viện media</h1>
<?php if($gallery->id){?>
<div class="row">
	<div class="col-lg-12">
		<!-- The file upload form used as target for the file upload widget -->
		<form id="fileupload" method="POST" enctype="multipart/form-data">
			{{ csrf_field() }}
			<input type="hidden" value="<?=$gallery->id?>" name="gid">
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
		<?php if( isset($galleryImages) && count($galleryImages) > 0 ) {?>
		<div class="row">
				<?php
			foreach ( $galleryImages as $row ) {?>
				<div class="col-lg-3 col-md-4 col-xs-6 p-3 border list-image">
					<a class="d-block mh-100 mw-100" style="height: 250px; overflow: hidden" href="/media/gallery/<?=$gallery->id?>/<?php echo $row->image;?>" target="_blank">
						<img src="/media/gallery_image/<?=$gallery->id?>/tb/<?php echo $row->image;?>" style="max-height: 100%">
					</a><br/>
					<a class="btn btn-danger btn-sm delete-gallery-image" href="javascript:void(0)" imgdetailid="<?=$row->id?>"
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
			url: '/admin/gallery/detailuploadImage'
			, limitMultiFileUploads: 10
		});
	});
	$(document).ready(function () {
		$('#menu-add-new-gallery').parent('li').addClass('active');

		$('#btn-delete-image').click(function(e){
			e.preventDefault();
			if (confirm('Bạn muốn xóa ảnh này?')){
				var id = $(this).attr('imgdetailid');
				$.ajax({
					url: '/admin/gallery/deleteimage?id=' + id,
					async: false,
					method: 'GET',
					success: function(){
						window.location.href="/admin/gallery/detailupload?id=<?=$gallery->id ?>";
					}
					});
			} else {
				return false;
			}
		});
		$('.delete-gallery-image').click(function(e){
			e.preventDefault();
			if (confirm('Bạn muốn xóa ảnh này?')){
				var id = $(this).attr('imgdetailid');
				var button = $(this);
				$.ajax({
					url: '/admin/gallery/deletegalleryimage?id=' + id,
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