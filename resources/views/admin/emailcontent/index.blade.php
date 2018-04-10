@extends('admin.layout.main')
@section('title', 'Dashboard')
@section('content')
<ul class="breadcrumb">

	<li>
		<a href="/admin/home">Home</a>
	</li>
	<li>
		<span><span>&nbsp;&gt;&nbsp;</span></span>
	</li>
	<li>
		<a>Quản lý nội dung liên hệ từ khách hàng</a>
	</li>
</ul>

<div class="container-fluid">

	<div class="row">

		<div class="col-md-6">

			<div class="btn-group">
				<a id="btn-del-all" href="#" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Xóa toàn bộ mục đã chọn" href="#" onclick="return confirm('Bạn thật sự muốn xóa mục này?')">
					<i class="material-icons">delete_forever</i>
				</a>

			</div>

		</div>

		<div class="col-md-6 text-right">

			<a href="/admin/emailcontent/index" class="btn btn-success pull-right btn-sm">
				<i class="material-icons">add</i> Thêm mới</a>

		</div>

	</div>

</div>
<div class="clear" style="height: 10px;"></div>
<form id="delform" action="" method="post" >
{{ csrf_field() }}
		<table class="table table-striped table-hover" id="table_content" cellspacing="1" cellpadding="1" width="100%">
			<thead>
				<tr>
					<th><a id="btn-ck-all" href="#" class="btn btn-default btn-sm" data-toggle="tooltip" title="Chọn / bỏ chọn toàn bộ">
					    <i class="material-icons">check_box_outline_blank</i></a>
                    </th>
					<th>ID</th>
					<th>Họ tên</th>
					<th>Số điện thoại</th>
					<th>email</th>
                    <th>Nội dung</th>
                    <th>Thời gian gửi liên hệ</th>
					<th class="text-center">Thao tác</th>
				</tr>
			</thead>
        </table>
</form>
@endsection