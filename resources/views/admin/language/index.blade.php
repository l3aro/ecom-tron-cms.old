@extends('admin.layout.main')
@section('title', 'Languages')
@section('content')
<div class="row mt-2 mb-2">
	<div class="col-6 text-left">
		<h1> Thiết lập ngôn ngữ </h1>
	</div>
	<div class="col-md-6 text-right">
		<button name="submit" class="btn btn-success btn-sm" id="btn-save"><i class="material-icons">save</i>Lưu tất cả</button>
		<a class="btn btn-sm btn-info" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i></a>
	</div>
</div>
<div class="row mt-2 mb-2">
	<div class="col-6 text-left">
		<a class="btn btn-info btn-sm" href="/admin/language/item"><i class="material-icons">create_new_folder</i>Tạo ngôn ngữ mới</a>
		<a class="btn btn-info btn-sm" href="/admin/language/language"><i class="material-icons">note_add</i>Tạo mục ngôn ngữ mới</a>
	</div>
	<div class="col-md-6 text-right">
		
	</div>
</div>
<div class="container-fluid">
	<div class="row mt-2 mb-2" id="list-table">
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('#menu-language').parent('li').addClass('active');
	try {
		initEvents();
		loadDataTable(1);
	} catch (e) {
		// TODO: handle eception
		alert('ready function');
	}
});
function initEvents() {
	
}
function loadDataTable(page){
	try {
		$.ajax({
		  url: "/admin/language/listlang?page=" + page,
		}).done(function( data ) {
		   $('#list-table').html(data);
		});
	} catch (e) {
		alert(e);
	}
}
</script>
@endsection
