@extends('admin.layout.main')
@section('title', 'Contacts')
@section('content')
<div class="row">
	<div class="col-md-9">
		<h1>Quản lý nội dung liên hệ từ khách hàng</h1>
	</div>
	<div class="col-md-3 text-right">
		<a class="btn btn-sm btn-info" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i> </a>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="btn-group">
			<a id="btn-del-all" href="/admin/contact" class="btn btn-danger btn-sm sortcat" data-toggle="tooltip" title="Xóa toàn bộ mục đã chọn" href="#" onclick="return confirm('Bạn thật sự muốn xóa mục này?')">
				<i class="material-icons">delete_forever</i>
			</a>
		</div>
	</div>
	<div class="col-md-6 text-right">
	</div>
</div>
<div class="clear" style="height: 10px;"></div>
<table class="table-sm table-hover table-bordered mb-2" id="table_content" cellspacing="1" cellpadding="1" width="100%">
	<thead>
		<tr>
			<th class=" align-middle" style="text-align: center;width: 35px;"><a id="btn-ck-all" href="#" class="btn btn-default btn-sm" data-toggle="tooltip" title="Chọn / bỏ chọn toàn bộ">
				<i class="material-icons">check_box_outline_blank</i></a>
			</th>
			<th class=" align-middle">ID</th>
			<th class=" align-middle" style="width: 280px;">Họ tên</th>
			<th class=" align-middle">Số điện thoại</th>
			<th class=" align-middle">email</th>
			<th class=" align-middle">Thời gian gửi liên hệ</th>
			<th class=" align-middle" class="text-center" style="width: 50px;">Thao tác</th>
		</tr>
	</thead>
	<tbody id="sorttable">
	@foreach ($user as $u)
		<tr id="item_<?=$u->id?>">
			<td class="text-center">
				<input type="checkbox" name="checkdel[<?=$u->id?>]" class="checkdel" del-id="<?=$u->id?>">
			</td>
			<td><?=$u->id?></td>
			<td><a colorboxwidth="600" colorboxheight=600 class="opencolorbox" href="/admin/contact/detail?id=<?=$u->id?>"><?=$u->name?></a></td>
			<td><a colorboxwidth="600" colorboxheight=600 class="opencolorbox"><?=$u->phone?></a></td>
			<td><?=$u->email?></td>
			<td><?=$u->sent_date?></td>
			<td style="text-align: center;">
			<div class="btn-group">						
				<form action="/admin/contact/delete_cat/<?=$u->id?>" method="post">
					{{ csrf_field() }}
					
					<button class="btn btn-danger btn-sm p-1" onclick="return confirm(`Bạn có chắc chắn muốn xóa?`)"
						data-toggle="tooltip" title="Xóa" data-placement="top">
						<i class="material-icons">delete</i>
					</button>
				</form>
			</div>
			</td>					
		</tr>
	@endforeach
	</tbody>
</table>
<script>
	$(document).ready(function(){
		$("[data-toggle=tooltip]").tooltip();
		$('#menu-contact').parent('li').addClass('active');
		$('#btn-ck-all').click(function(){
			var checkBoxes = $(".checkdel");
	        checkBoxes.prop("checked", !checkBoxes.prop("checked"));
	        if ($('input.checkdel:checkbox:checked').length == $('input.checkdel:checkbox').length){
		        $('#btn-ck-all i').text('check_box')
	        } else if ($('input.checkdel:checkbox:checked').length > 0) {
		        $('#btn-ck-all i').text('indeterminate_check_box')
	        } else {
		        $('#btn-ck-all i').text('check_box_outline_blank');
	        }
		});
		$("#btn-del-all").click(function(){
			var countchecked = $('input.checkdel:checkbox:checked').length;
			if (countchecked > 0){
				if (confirm('Bạn có chắc chắn muốn xóa?')){
					var delstr = '';					
					$('input.checkdel:checkbox:checked').each(function(index){
						$.ajax({
							url: '/admin/contact/delete/' + $(this).attr('del-id'),
							async: false,
							success: function(data) {
								if (data != 0) {
									alert(data);
								}
							}
						});
					});
					run_search();
				}
			} else {
				return false;
			}
		});
		$(".checkdel").change(function(){
	        if ($('input.checkdel:checkbox:checked').length == $('input.checkdel:checkbox').length){
		        $('#btn-ck-all i').text('check_box')
	        } else if ($('input.checkdel:checkbox:checked').length > 0) {
		        $('#btn-ck-all i').text('indeterminate_check_box')
	        } else {
		        $('#btn-ck-all i').text('check_box_outline_blank');
	        }
		});
		$("#btn-del-all").click(function(){
			var countchecked = $('input.checkdel:checkbox:checked').length;
			if (countchecked > 0){
				if (confirm('Bạn có chắc chắn muốn xóa?')){
					var delstr = '';					
					$('input.checkdel:checkbox:checked').each(function(index){
						if (index < countchecked - 1)
							delstr += $(this).attr('del-id') + ',';
						else
							delstr += $(this).attr('del-id');
						});
					window.location = '/admin/contact/deletecat?id=' + delstr;
				}
			} else {
				return false;
			}
			});
		
		
	});
</script>
@endsection