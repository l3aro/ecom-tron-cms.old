@extends('admin.layout.main')
@section('title', 'Setting')
@section('content')

<div class="row">
	<div class="col-md-6">
		<h1>Quản lý nội dung email gửi từ hệ thống</h1>
	</div>
	<div class="col-md-6 text-right">
		<a class="btn btn-sm btn-success" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i></a>
	</div>
</div>
<div class="row mt-2 mb-2">
	<div class="col-md-6">
		<a href="/admin/setting/itememailcontent" class="btn btn-info pull-right btn-sm">
			<i class="material-icons">note_add</i>Tạo nội dung email mới
		</a>
	</div>
	<div class="col-md-6 text-right">
		
	</div>
</div>
<table class="table-sm table-hover table-bordered mb-2" id="table_content" cellspacing="1" cellpadding="1" width="100%">
	<thead>
		<tr id="item_10">
			<th class=" align-middle" style="width: 40px;">ID</th>
			<th class=" align-middle">Gửi đi khi</th>
            <th class=" align-middle">Tiêu đề</th>
			<th class="text-center align-middle" style="width: 80px;">Thao tác</th>
		</tr>
	</thead>
    <form method="post" action="" enctype="multipart/form-data">
    {{ csrf_field() }}
        <tbody id="sorttable">
        @foreach($emailcontent as $eco)
            <tr>
                <td class="align-middle"><?=$eco->id?></td>
                <td class="align-middle"><a colorboxwidth="600" colorboxheight=600 class="opencolorbox" href="/admin/setting/itememailcontent?id=<?=$eco->id?>"><?=$eco->send_when?></a></td>                
                <td class="align-middle"><?=$eco->name?></td>
                <td style="text-align: center;">
                    <div class="btn-group align-middle">
                        <a class="btn btn-info p-1 btn-sm" href="/admin/setting/itememailcontent?id=<?=$eco->id?>" data-toggle="tooltip" title="Sửa"><i class="material-icons">border_color</i></a>
                        
                    </div>
                </td>					
            </tr>
        @endforeach
  </form>
	</tbody>
</table>

<script type="text/javascript">
$(document).ready(function() {
$('#menu-setting-emailcontent').parent('li').addClass('active');
});
</script>
@endsection