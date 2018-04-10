@extends('admin.layout.main')
@section('title', 'Dashboard')
@section('content')
<?php  if ($saved) {?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>Lưu dữ liệu thành công!</strong> Dữ liệu đã được lưu vào cơ sở dữ liệu.
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<?php  } ?>
<h1>Thông tin ngôn ngữ</h1>

<form id="formvalidate" name="form_system" action="/admin/language/language?id={{ $lang_key->id }}"  method="post" enctype="multipart/form-data" >
{{ csrf_field() }}

<input type="hidden" name="id" value="{{ $lang_key->id }}">

<input type="hidden" name="language" value="{{ $lang_key->name }}">

<div class="save-group-buttons">
		<A class="btn btn-info btn-sm" href="/admin/language/language"><i class="material-icons">note_add</i>Tạo mới</A>
        <button class="btn btn-sm" onclick="window.location = '/admin/language'; return false;">
            <i class="material-icons">reply</i>Quay lại
        </button>
		<button name="submit" class="btn btn-sm btn-success"><i class="material-icons">save</i> Lưu</button>
		<a class="btn btn-sm btn-info" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i></a>
	</div>
<div class="clear10"></div>
<div class="row">
	<div class="col-lg-6">
		<div class="form-group">
			<label class="control-label" for="focusedInput">Nhận biết</label> 
			<input type="text" name="name" id="name" class="form-control" value="{{ $lang_key->name }}" placeholder="Nhận biết" required/>
		</div>
		<div class="form-group">
			<label class="control-label" for="focusedInput">Code</label> 
			<input type="text" name="code" id="code" class="form-control" value="{{ $lang_key->code }}" placeholder="Code" required/>
		</div>
		@foreach($lang as $key=>$value)
		<div class="form-group">
			<label class="control-label" for="focusedInput">{{ $value->name }}</label> 
			<input type="text" name="lang_{{ $value->short_name }}" id=" {{ $value->short_name }}" class="form-control" value="{{ isset($lang_value[$value->short_name])?$lang_value[$value->short_name]['value']:'' }}" required/>
		</div>
		@endforeach
	</div>
</div>
</form>
<script type="text/javascript">

$(document).ready(function() {
	$('#menu-language').parent('li').addClass('active');
});
</script>

@endsection