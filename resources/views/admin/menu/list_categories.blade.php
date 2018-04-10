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
				<th class="align-middle">Tên menu</th>
				<th class="align-middle" style="width: 200px">Loại menu</th>
				<th class="align-middle" style="width: 120px;">Ngày tạo</th>
				<th class="align-middle" style="width: 120px;">Người đăng</th>
				<th class="align-middle text-center" style="width: 115px;">Thao tác</th>
			</tr>
		</thead>
	</table>
		@if (isset($menus))
		<?php
			function printMenus($menus, $icon = '') { ?>
				<ul class="sortcat ui-sortable">
			<?php foreach ($menus as $menu) { ?>
				<li catid="<?=$menu->id?>" id="cat_<?=$menu->id?>" class="cat">
				<table class="table-sm table-hover table-bordered m-0 p-0" id="table_content" width="100%"><tbody>
				<tr>
									<td class="align-middle connect" style="width: 35px;" data-toggle="tooltip" title="Giữ icon này kéo thả để sắp xếp">
										<i class="material-icons">format_line_spacing</i>
									</td>
									<td class="align-middle" style="width: 35px;">
										<input type="checkbox" class="checkdel" del-id="<?=$menu->id?>" id="delId<?=$menu->id?>">
										<label for="delId<?=$menu->id?>"></label>
									</td>
									<td class="align-middle" style="width: 50px;"><?=$menu->id?></td>
									<td class="edit-name">
										<a href="/admin/menu/detail?id=<?=$menu->id?>">
											<?=$icon.$menu->name?>
										</a>
									</td>
									<td style="width: 200px">
										<?php switch ($menu->type) {
											case 1:
												echo '[Bài viết] Link đến một mục bài viết';
												break;
											case 2:
												echo '[Bài viết] Đồng bộ với toàn bộ mục con của một mục';
												break;
											case 3:
												echo '[Bài viết] Đồng bộ mục bài viết';
												break;
											case 4:
												echo '[Bài viết] Link đến bài viết chỉ định';
												break;
											case 5:
												echo '[Sản phẩm] Link đến một mục sản phẩm';
												break;
											case 6:
												echo '[Sản phẩm] Đồng bộ với toàn bộ mục con của một mục';
												break;
											case 7:
												echo '[Sản phẩm] Đồng bộ mục sản phẩm';
												break;
											case 8:
												echo '[Sản phẩm] Link đến sản phẩm chỉ định';
												break;
											default:
												echo 'Link tùy chọn';
												break;
										}
										?>
									</td>
									<td style="width: 120px;"><?=$menu->created_at?></td>
									<td style="width: 120px;"><?=$menu->menuUpdateBy->name?></td>
									<td style="width: 115px;">
										<div class="btn-group">
											<a class="btn btn-success btn-sm p-1" href="/admin/menu/detail?parent=<?=$menu->id?>&cat=<?=$menu->cat?>" data-toggle="tooltip" title="Thêm mục con" data-placement="top">
												<i class="material-icons">playlist_add</i>
											</a>
											<a class="btn btn-info btn-sm p-1" href="/admin/menu/detail?id=<?=$menu->id?>" data-toggle="tooltip" title="Sửa" data-placement="top">
												<i class="material-icons">mode_edit</i>
											</a>
											<a class="btn btn-danger btn-sm p-1 delete-button" href="/admin/menu/delete/<?=$menu->id?>"
												data-toggle="tooltip" title="Xóa" data-placement="top">
												<i class="material-icons">delete</i>
											</a>
										</div>
									</td>
								</tr>
								</tbody></table>
				<?php
				if (isset($menu->subMenus))printMenus($menu->subMenus, $icon.'<i class="material-icons">remove</i>'); ?>
				</li>
			</ul>

		<?php	}
			}
			printMenus($menus); 
		?>
		<?php ?>
		@endif