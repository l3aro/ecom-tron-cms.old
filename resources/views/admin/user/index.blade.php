@extends('admin.layout.main')
@section('title', 'Users')
@section('content')
<div class="row mt-2 mb-2">
	<div class="col-md-9 text-left">
		<h1>Quản lý thành viên</h1>
	</div>
	<div class="col-md-3 text-right">
		<a class="btn btn-sm btn-info" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i> </a>
	</div>
</div>

<div class="row mt-2 mb-2">
	<div class="col-md-6 text-left">
		<a class="btn btn-sm btn-info" href="/admin/user/info" data-toggle="tooltip" title="Thêm thành viên mới"><i class="material-icons">note_add</i></a>
		<a id="btn-del-all" href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Xóa toàn bộ mục đã chọn"><i class="material-icons">delete_forever</i></span></a>
	</div>
</div>
<table class="table-sm table-hover table-bordered mb-2" id="table_content" cellspacing="1" cellpadding="1" width="100%">
	<thead class="thead-light">
		<tr>
			<th class="align-middle" style="width: 5%;">
			<a id="btn-ck-all" href="#" class="btn btn-default btn-sm" data-toggle="tooltip" title="Chọn / bỏ chọn toàn bộ">
				<i class="material-icons">check_box_outline_blank</i></a>
			</th>
			<th class=" align-middle" style="text-align:center;width: 5%;">ID</th>
			<th class=" align-middle" style="width: 25%;">Username</th>
			<th class=" align-middle" style="width: 20%;">Email</th>
			<th class=" align-middle" style="width: 20%;">Vai trò quản trị</th>
			<th class="text-center align-middle" style="width: 10%;">Thao tác</th>
		</tr>
	</thead>
@if(isset($mode))
@foreach($mode as $key=>$mod)
	<body>
		<tr>
			<td align="center" style="width: 5%;"><input type="checkbox" class="checkdel" name="checkdel[11]"> </td>
			<td align="center" style="width: 5%;"><?=$mod->id?></td>
			<td style="width: 25%;"><a colorboxwidth="600" colorboxheight=600 class="opencolorbox" href="/admin/user/info?id=<?=$mod->id?>"><?=$mod->name?></a></td>
			<td style="width: 20%;"><a colorboxwidth="600" colorboxheight=600 class="opencolorbox" href=""><?=$mod->email?></a></td>
			<td style="width: 20%;"><?=$mod->user_role?></td>
			<td style="text-align: center;width: 10%;">
			<div class="btn-group">
				<a class="btn p-1 btn-info btn-sm" href="/admin/user/info?id=<?=$mod->id?>" data-toggle="tooltip" title="Sửa"><i class="material-icons">border_color</i></a>
				
				<form action="/admin/user/delete_user/<?=$mod->id?>" method="post">
					{{ csrf_field() }}
					
					<button class="btn p-1 btn-sm btn-danger btn-sm" onclick="return confirm(`Bạn có chắc chắn muốn xóa?`)"
						data-toggle="tooltip" title="Xóa" data-placement="top">
						<i class="material-icons">delete</i>
					</button>
				</form>
			</div>
			</td>					
		</tr>
	
	</body>
@endforeach
@endif

</table>
<style>
	.dataTables_wrapper {
		position: relative;
	}
	.dataTables_filter {
		position: absolute;
		top: -90px;
	}
</style>
<script type="text/javascript">
$(document).ready(function() {
	$('#menu-admin').parent('li').addClass('active');
});
</script>
<script>
	$(document).ready(function(){
		$("[data-toggle=tooltip]").tooltip();
		$('#menu-list-contact').parent('li').addClass('active');
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
						if (index < countchecked - 1)
							delstr += $(this).attr('del-id') + ',';
						else
							delstr += $(this).attr('del-id');
						});
					window.location = '/admin/compenent/deletecat?id=' + delstr;
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
		$( ".sortcat" ).sortable({
			handle: ".connect",
			placeholder: "ui-state-highlight",
	      	update: function(event, ui) {
	        sort = $(this).sortable('toArray');
	        $.post('/admin/user/sortcat', {sort: sort, _token : $('input[name=_token]').val()});
	      }
	    });
	});
</script>
@endsection

