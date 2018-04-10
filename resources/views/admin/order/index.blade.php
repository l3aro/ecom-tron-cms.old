@extends('admin.layout.main')
@section('title', 'Orders')
@section('content')
<h1>Quản lý đơn hàng</h1>
<div class="clear" style="height: 20px;"></div>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-6">
			<div class="btn-group">
				<a id="btn-del-all"  href="/admin/order" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Xóa toàn bộ mục đã chọn" onclick="return confirm('Bạn thật sự muốn xóa mục này?')"  href="#">
					<i class="material-icons">delete_forever</i>
				</a>
			</div>
		</div>
	</div>
</div>
<div class="clear" style="height: 20px;"></div>
		<table class="table-sm  table-hover table-bordered mb-2 " id="table_content" cellspacing="1" cellpadding="1" width="100%">
			<thead>
				<tr>
					<th class=" align-middle"  style="text-align: center;width:50px;" ><a id="btn-ck-all" href="#" class="btn btn-default btn-sm" data-toggle="tooltip" title="Chọn / bỏ chọn toàn bộ">
						<i class="material-icons">check_box_outline_blank</i></a>
					</th>
					<th class=" align-middle">ID</th>
					<th class=" align-middle">Tên khách hàng</th>
					<th class=" align-middle">Tổng đơn hàng</th>
					<th class=" align-middle">Thời gian đặt hàng</th>
					<th class="text-center align-middle" style="width: 120px;">Thao tác</th>
				</tr>
			</thead>
			<tbody id="sorttable">
			@foreach ($order as $od )
				<tr id="item_<?=$od->id?>">
					<td class="text-center">
						<input type="checkbox" name="checkdel[<?=$od->id?>]" class="checkdel" del-id="<?=$od->id?>">
					</td>
					<td><?=$od->id?></td>
					<td class="align-middle"><a colorboxwidth="600" colorboxheight=600 class="opencolorbox" href="/admin/order/item?id=<?=$od->id?>"><?=$od->name?></a></td>
					<td><?=$od->total?></td>
					<td><?=$od->sent_date?></td>
					<td style="text-align: center;">
						<div class="btn-group">
							<a class="btn  btn-success btn-sm p-1" href="/admin/order/printfile?id=<?=$od->id?>" data-toggle="tooltip" title="In"><i class="material-icons">print</i></a>
							<a class="btn  btn-info btn-sm p-1" href="/admin/order/item?id=<?=$od->id?>" data-toggle="tooltip" title="Sửa"><i class="material-icons">border_color</i></a>						
							<form  action="/admin/order/delete_cat/<?=$od->id?>" method="post" >
								{{ csrf_field() }}
								<button class="btn btn-sm p-1 btn-danger" onclick="return confirm(`Bạn có chắc chắn muốn xóa?`)"
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

<link type="text/css" rel="stylesheet" media="screen" href="/admins/css/jquery-ui.min.css">
<link type="text/css" rel="stylesheet" media="screen" href="/admins/css/jquery-ui.structure.min.css">
<link type="text/css" rel="stylesheet" media="screen" href="/admins/css/jquery-ui.theme.min.css">
<script src="/admins/js/jquery-ui.min.js"></script>
<script>
	$(document).ready(function(){
		$("[data-toggle=tooltip]").tooltip();
		$('#menu-list-order').parent('li').addClass('active');
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
							url: '/admin/order/delete/' + $(this).attr('del-id'),
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
		$( "#sorttable" ).sortable({
	      update: function(event, ui) {
	        sort = $(this).sortable('toArray');
	        $.post('/admin/order/sorttable', {sort: sort});
	      }

	    });

		
	});

</script>

@endsection