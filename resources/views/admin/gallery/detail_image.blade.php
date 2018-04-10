@extends('admin.layout.main')
@section('title', 'Dashboard')
@section('content')
<div class="row">
	<div class="col-md-6">
		<h1>Upload ảnh</h1>
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
<div class="clear" style="height: 10px;"></div>
<form id="frm-gallery-action" method="post" action="/admin/gallery/detail_image?catid=<?=$category->id ?>&id=<?=$galleryimage->id?>" enctype="multipart/form-data">
{{ csrf_field() }}
<INPUT type="hidden" name="gallery_id" value="<?=$galleryimage->id?>">
	<div class="save-group-buttons">
		<a class="btn btn-sm btn-primary" href="/admin/gallery/detail?id=<?=$category->id ?>"><i class="material-icons">backspace</i> Quay lại</a>
		<button name="submit" class="btn btn-sm btn-success"><i class="material-icons">save</i> Lưu</button>
		<a class="btn btn-sm btn-info" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i></a>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<label class="control-label" for="focusedInput">Upload ảnh</label>
		    <div class="form-group">
				<input class="form-control" name="image" type="file"
					value="" placeholder="Ảnh đại diện">
		    </div>
			<br>
			<?php if(isset($galleryimage) && $galleryimage->image != ''){?>
			<div class="clear10"></div>
			<br>
		    <img src="/media/gallery_image/<?=$galleryimage->gallery_id ?>/tb/<?=$galleryimage->image ?>" style="max-width: 100%; max-height: 220px" />
		    <div class="clear10"></div>
			<br>
			<button class="btn btn-danger deleteimg" imgdetailid="<?=$galleryimage->id ?>" name="deleteimagedetail" value="<?php echo $galleryimage->id ?>" type="submit">
				<span class="glyphicon glyphicon-trash"></span> Xóa ảnh đại diện
			</button>
			<?php } ?>
			<input type="hidden" name="oldimage" value="<?php if(isset($galleryimage) && $galleryimage->image != '') echo $galleryimage->image ?>">

			<div class="form-group">
				<label class="control-label">Trạng thái </label>
				<a class="collapsed" href="#helpmenu" data-toggle="collapse" data-target="#helpmenu">
					<i class="material-icons">help_outline</i>
				</a>	
				<div class="form-group">
					<div class="row">
						<div class="col-md-3"
							<label class="control-label">Hiển thị</label>
							<input type="checkbox" class="checkbox-toggle" name="public" id="public" {{ isset($galleryimage)&&$galleryimage->public==1?'checked':'' }}/><label class="label-checkbox" for="public">Hiển thị</label>
						</div>
					</div>
				</div>
				<div class="collapse" id="helpmenu" aria-expanded="false">
					<small class="form-text text-muted">Khi tính năng "Hiển thị" được bật, gallery này sẽ được hiển thị trên giao diện trang web.</small>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="form-group">
				<label class="control-label" for="focusedInput">Url image</label>
				<input class="form-control" name="link_img" type="text"
					value="<?=$galleryimage->link_img?>"
					placeholder="Url image">
				<small class="form-text text-muted">Gián đoạn link url vào, khi click vào ảnh này thì sẽ trỏ đến link đã gián.</small>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<h3>Tiêu đề nội dung ảnh</h3>
		    <div class="form-group">
		        <textarea class="form-control" rows="5" id="textArea" name="caption"><?php echo isset($galleryimage)?$galleryimage->caption:''?></textarea>
		    </div>
		</div>
	</div>
	
</form>
<script src="/admins/ckeditor/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		CKEDITOR.replace( 'textArea' );
		$('#menu-add-new-gallery').parent('li').addClass('active');
		 	
	});
</script>
@endsection