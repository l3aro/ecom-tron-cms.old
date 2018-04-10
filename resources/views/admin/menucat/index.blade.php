@extends('admin.layout.main')
@section('title', 'Menu Categories')
@section('content')
<div class="row">
	<div class="col-md-6">
		<h1>Quản lý danh mục menu</h1>
	</div>
	<div class="col-md-6 text-right">
		<a class="btn btn-sm btn-success" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i></a>
	</div>
</div>
<div class="row mt-2 mb-2">
	<div class="col-md-6">
		<a href="/admin/menucat/detail" class="btn btn-info pull-right btn-sm">
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
			<th class=" align-middle">Tên danh mục menu</th>
			<th class=" align-middle" style="width: 200px;">Người đăng</th>		
			<th class=" align-middle" style="width: 200px;">Ngày tạo</th>						
			<th class="text-center align-middle" style="width: 80px;">Thao tác</th>
		</tr>
	</thead>
	<tbody id="sorttable">
	@if(isset($menucat) && count($menucat))
	@foreach ($menucat as $co)
		<tr id="item_11">
			<td class="align-middle"><?=$co->id?></td>
			<td class="align-middle"><a colorboxwidth="600" colorboxheight=600 class="opencolorbox" href="/admin/menu?cat=<?=$co->id?>"><?=$co->name?></a></td>
			<td class="align-middle"><?=isset($co->menuUpdateBy)?$co->menuUpdateBy->name:''?></td>
			<td class="align-middle"><?=$co->created_at?></td>
			<td style="text-align: center;">
			<div class="btn-group align-middle">
				<a class="btn btn-info p-1 btn-sm" href="/admin/menucat/detail?id=<?=$co->id?>" data-toggle="tooltip" title="Sửa"><i class="material-icons">border_color</i></a>
				
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
		$('#menu-menu').parent('li').addClass('active');
	});
</script>
@endsection