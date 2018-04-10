	<table class="table-sm table-striped table-hover table-bordered m-0 p-0" id="table_content" cellspacing="1" cellpadding="1" width="100%">
		<thead>
			<tr>
				<th class="align-middle" style="width: 35px;">
				</th>
				<th class="align-middle" style="width: 35px;">
					<a id="btn-ck-all" href="#" data-toggle="tooltip" title="Chọn / bỏ chọn toàn bộ">
						<i class="material-icons">check_box_outline_blank</i>
					</a>
				</th>
				<th class="align-middle" style="width: 50px;">ID</th>
				<th class="align-middle">Tên mục</th>
				<th class="align-middle" style="width: 120px;">Ngày tạo</th>
				<th class="align-middle" style="width: 120px;">Người đăng</th>
				<th class="align-middle text-center" style="width: 115px;">Thao tác</th>
			</tr>
		</thead>
	</table>
	<ul class="nav-cat sortcat ui-sortable">
		@if (isset($categories))
		<?=$categories?>
		@endif
	</ul>