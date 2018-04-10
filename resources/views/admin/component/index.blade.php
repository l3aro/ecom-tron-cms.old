@extends('admin.layout.main')
@section('title', 'Components')
@section('content')
<div class="row">
	<div class="col-md-6">
		<h1>Quản lý nội dung phụ</h1>
	</div>
	<div class="col-md-6 text-right">
		<a class="btn btn-sm btn-success" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i></a>
	</div>
</div>
<div class="row mt-2 mb-2">
	<div class="col-md-6">
		<a href="/admin/component/item" class="btn btn-info pull-right btn-sm">
			<i class="material-icons">note_add</i>Thêm mới
		</a>
	</div>
	<div class="col-md-6 text-right">
		
	</div>
</div>
<table class="table-sm table-hover table-bordered mb-2" id="table_content" cellspacing="1" cellpadding="1" width="100%">
	<thead>
		<tr>
			<th class=" align-middle" style="width: 40px;">ID</th>
			<th class=" align-middle">Tên</th>
			<th class=" align-middle" style="width: 43px;">Hiển thị</th>
			<th class=" align-middle" style="width: 200px;">Người đăng</th>		
			<th class=" align-middle" style="width: 200px;">Ngày tạo</th>						
			<th class="text-center align-middle" style="width: 80px;">Thao tác</th>
		</tr>
	</thead>
	<tbody id="sorttable">
	@if(isset($component) && count($component))
	@foreach ($component as $co)
		<tr id="item_11">
			<td class="align-middle"><?=$co->id?></td>
			<td class="align-middle"><a colorboxwidth="600" colorboxheight=600 class="opencolorbox" href="/admin/component/item?id=<?=$co->id?>"><?=$co->name?></a></td>
			<td class="align-middle">
				<button type="button" class="btn btn-sm <?=$co->public==1?'btn-success':''?> editmenu p-1" data-toggle="tooltip" title="<?=$co->public==1?'Click để tắt':'Click để bật'?>"
					field="public" item-id="<?=$co->id?>" currentvalue="<?=$co->public?>" cms-change-field="changfield"><i class="material-icons"><?=$co->public==1?'check':'close'?></i>
				</button>
			</td>
			<td class="align-middle"><?=isset($co->comUpdateBy)?$co->comUpdateBy->name:''?></td>
			<td class="align-middle"><?=$co->created_at?></td>
			<td style="text-align: center;">
			<div class="btn-group align-middle">
				<a class="btn btn-info p-1 btn-sm" href="/admin/component/item?id=<?=$co->id?>" data-toggle="tooltip" title="Sửa"><i class="material-icons">border_color</i></a>
				
			</div>
			</td>					
		</tr>
	@endforeach
	@else
	Không có dữ liệu được tìm thấy
	@endif
	</tbody>
</table>
<script>
	$(document).ready(function(){
		$("[data-toggle=tooltip]").tooltip();
		$('#menu-common-page').parent('li').addClass('active');
	});
</script>
@endsection