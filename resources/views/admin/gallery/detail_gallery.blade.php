@extends('admin.layout.main')
@section('title', 'Gallery')
@section('content')
<div class="row">
	<div class="col-md-6">
		<h1>Thông tin album ảnh</h1>
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
<form id="frm-gallery-action" method="post" action="/admin/gallery/detail?id=<?=$category->id?>" enctype="multipart/form-data">
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
				<label class="control-label" for="focusedInput">Tên gallery</label>
				<input class="form-control" name="name" type="text" required
					value="<?=$category->name?>"
					placeholder="Tên gallery">
				<small class="form-text text-muted">Tên của gallery chứa dữ liệu</small>
			</div>
			
			<div class="form-group">
				<label class="control-label" for="focusedInput">Url gallery</label>
				<input class="form-control" name="link_to" type="text"
					value="<?=$category->link_to?>"
					placeholder="Url gallery">
				<small class="form-text text-muted">Dán đoạn link url đã copy từ youtube vào.</small>
			</div>
			
			<div class="form-group">
				<label class="control-label">Nằm trong mục</label> 
				<select class="form-control" name="cat">
					<option value="0"></option>
					@if(isset($gallerycat) && count($gallerycat))
					@foreach ($gallerycat as $key=>$gallerycat)
						<option value="<?=$gallerycat->id?>" <?php echo ($gallerycat->id == $category->cat)?'selected':'' ?> ><?=$gallerycat->name?></option>
					@endforeach
					@endif					
				</select>
				<small class="form-text text-muted">Đặt mục cha cho mục dữ liệu này, mục cha ở đây nghĩa là các mục gallery lớn đã được tạo trước đó.</small>
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
					<small class="form-text text-muted">Khi tính năng "Hiển thị" được bật, gallery này sẽ được hiển thị trên giao diện trang web.</small>
					<small class="form-text text-muted">Khi tính năng "Nổi bật" được bật, gallery này sẽ được hiển thị trên trang chủ hoặc các điểm chỉ định trên giao diện.</small>
					<small class="form-text text-muted">Khi tính năng "Mới" được bật, gallery này sẽ được hiển thị trên trang chủ hoặc các điểm chỉ định trên giao diện.</small>
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
				<small class="form-text text-muted">Tối ưu đường dẫn URL để tốt nhất cho SEO. Ví dụ: "ten-gallery" hệ thống tự sinh ra là: http://tenmien.com/ten-gallery</small>
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
		    <img src="/media/gallery/tb/<?=$category->image ?>" style="max-width: 100%; max-height: 220px" />
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
		        <textarea class="form-control" rows="5" id="textArea" name="caption"><?php echo isset($category)?$category->caption:''?></textarea>
		    </div>
		</div>
	</div>
	
	<div class="container-fluid">
		<div class="row">
			<legend>Ảnh trong album</legend>
			<div class="col-md-8 float-left">
				<a id="btn-del-all" href="#" class="btn btn-sm btn-danger my-2" data-toggle="tooltip" title="Xóa toàn bộ mục đã chọn" href="#">
					<i class="material-icons">delete_forever</i>
				</a>
			</div>
			<div class="col-md-4" style="float:right;">
					<a href="/admin/gallery/detail_image?catid=<?=$category->id?>" class="btn btn-sm btn-info">
						<i class="material-icons">file_upload</i>Upload ảnh
					</a>
					<a href="/admin/gallery/detailupload?id=<?=$category->id?>" class="btn btn-sm btn-info">
						<i class="material-icons">perm_media</i> Upload nhiều ảnh
					</a>
			</div>
			<div class="col-md-12">
				<table class="table-sm table-hover table-bordered mb-2" id="table_content" width="100%">
					<thead class="thead-light">
						<tr>
							<th class="align-middle" style="width: 35px"></th>
							<th class="align-middle text-center" style="width: 35px">
								<a id="btn-ck-all" href="#" data-toggle="tooltip" title="Chọn / bỏ chọn toàn bộ">
									<i class="material-icons">check_box_outline_blank</i>
								</a>
							</th>
							<th class="align-middle" style="width: 50px;">ID</th>
							<th class="align-middle">Ảnh</th>
							<th class="align-middle">Link</th>
							<th class="align-middle">Caption</th>
							<th class="align-middle text-center" style="width: 40px;">Hiển thị</th>
							<th class="align-middle text-center" style="width: 160px;">Thao tác</th>
						</tr>
					</thead>
					<tbody class="sort" id="cat_table">
					@if(isset($image_gallery) && count($image_gallery))
					@foreach ($image_gallery as $key=>$r)
						<tr id="item_<?=$r->id?>">
							<td class="align-middle connect" data-toggle="tooltip" title="Giữ icon này kéo thả để sắp xếp">
								<i class="material-icons">menu</i>
							</td>
							<td class="text-center">
								<input type="checkbox" name="checkdel[<?=$r->id?>]" class="checkdel" del-id="<?=$r->id?>">
							</td>
							<td><?=$r->id?></td>
							<td class="edit-name">
								<img src="/media/gallery_image/<?=$r->gallery_id?>/tb/<?=$r->image?>">
							</td>
							<td class="edit-name">
								<a href=""><?=$r->link_img?></a>
							</td>
							<td class="edit-name">
								<a href=""><?=$r->caption?></a>
							</td>
							<td>
								<button type="button" class="btn btn-sm p-1 <?=$r->public==1?'btn-success':''?> editmenu" data-toggle="tooltip" title="<?=$r->public==1?'Click để tắt':'Click để bật'?>"
									field="public" item-id="<?=$r->id?>" currentvalue="<?=$r->public?>" cms-change-field="changefielditem"><i class="material-icons"><?=$r->public==1?'check':'close'?></i>
								</button>
							</td>
							<td style="text-align: center;">
								<div class="btn-group">
									<a class="btn btn-sm p-1 btn-info" href="/admin/gallery/detail_image?catid=<?=$r->gallery_id?>&id=<?=$r->id?>" data-toggle="tooltip" title="Sửa">
										<i class="material-icons">border_color</i>
									</a>
									<button class="btn btn-sm p-1 btn-danger delete-button"
										data-toggle="tooltip" data-placement="top" title="Xóa" delete-id="<?=$r->id?>">
										<i class="material-icons">delete</i>
									</button>
								</div>
							</td>
						</tr>
						@endforeach
						@else
							Không có dữ liệu được tìm thấy
						@endif
					</tbody>
				</table>
			</div>
		</div>	
	</div>

</form>
<script src="/admins/ckeditor/ckeditor.js"></script>
<script>
	$(document).ready(function(){
		CKEDITOR.replace( 'textArea' );
		$('#menu-add-new-gallery').parent('li').addClass('active');
		 	$('.deleteimg').click(function(){
				if (confirm('Bạn muốn xóa ảnh này?')){
				var id = $(this).attr('imgdetailid');
				$.ajax({
					url: '/admin/gallery/deleteimgpro?id=' + id,
					async: false,
					method: 'GET',
					success: function(){
						window.location.href="/admin/gallery/detail?id=@yeild(id)&lang=@yeild(lang)";
					}
				});
					return false;
				} else {
					return false;
				}
			});
		$("[data-toggle=tooltip]").tooltip();
		$('.delete-button').click(function(e){
			e.preventDefault();
			if (confirm('Bạn có chắc chắn muốn xóa?')){
                var delete_id = $(this).attr('delete-id');
                $('#cat_table').html(showloading());
				$.ajax({
					url: '/admin/gallery/detail/delete/' + delete_id,
					async: false,
					method: 'GET',
					success: function(){
						window.location.href="/admin/gallery/detail?id=<?=$category->id ?>";
					}
				});
			}else {
				return false;
			}
		});
		
		$( ".sort" ).sortable({
			handle: ".connect",
			placeholder: "ui-state-highlight",
	      	update: function(event, ui) {
                sort = $(this).sortable('toArray');
                $.post('/admin/gallery/detail/sort', {sort: sort, _token : $('input[name=_token]').val()});
            }
	    });
        $('button[cms-change-field="changefielditem"]').click(function(){
			var obj = $(this);
			var currentvalue = $(this).attr('currentvalue');
			var id = $(this).attr('item-id');
			var field = $(this).attr('field');
			$.ajax({
				  url: '/admin/gallery/detail/changefield?id=' + id + '&p=' + currentvalue + '&field=' + field,
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
				  	obj.attr('class', 'btn btn-sm p-1 ' + cl + '');
					obj.html('<i class="material-icons">' + pic + '</i>');
				  	obj.attr('data-original-title', tooltip);
				  }
				});
		});
	});
</script>
@endsection