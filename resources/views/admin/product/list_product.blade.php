<table class="table-sm table-hover table-bordered mb-2" id="table_content" width="100%">
	<thead class="thead-light">
		<tr>
			<th class="align-middle" style="width: 35px"></th>
			<th class="align-middle text-center" style="width: 35px">
				<a id="btn-ck-all" href="#" data-toggle="tooltip" title="Chọn / bỏ chọn toàn bộ">
					<i class="material-icons">check_box_outline_blank</i>
				</a>
			</th>
			<th class="align-middle" style="width: 50px;">ID</th>
			<th class="align-middle">Tên sản phẩm</th>
			<th class="align-middle">Mục</th>
			<th class="align-middle text-center" style="width: 40px;">Hiển thị</th>
			<th class="align-middle text-center" style="width: 40px;">Nổi bật</th>
			<th class="align-middle text-center" style="width: 40px;">Mới</th>
			<th class="align-middle" style="width: 120px;">Ngày tạo</th>
			<th class="align-middle" style="width: 120px;">Người đăng</th>
			<th class="align-middle text-center" style="width: 160px;">Thao tác</th>
		</tr>
	</thead>
	<tbody class="sort">
	@if(isset($product) && count($product))
	@foreach ($product as $key=>$r)
		<tr id="item_<?=$r->id?>">
			<td class="align-middle connect" data-toggle="tooltip" title="Giữ icon này kéo thả để sắp xếp">
				<i class="material-icons">format_line_spacing</i>
			</td>
			<td class="text-center">
				<input type="checkbox" name="checkdel[<?=$r->id?>]" class="checkdel" del-id="<?=$r->id?>">
			</td>
			<td><?=$r->id?></td>
			<td class="edit-name">
				<a href="/admin/product/detail?id=<?=$r->id?>"><?=$r->name?></a>
			</td>
			<td>
				<a href="/admin/productcat/detail?id=<?=$r->cat?>"><?=$r->cat==0?'':$r->product_cat->name?></a>
			</td>
			<td>
				<button type="button" class="btn btn-sm p-1 <?=$r->public==1?'btn-success':''?> editmenu" data-toggle="tooltip" title="<?=$r->public==1?'Click để tắt':'Click để bật'?>"
					field="public" item-id="<?=$r->id?>" currentvalue="<?=$r->public?>" cms-change-field="changfield"><i class="material-icons"><?=$r->public==1?'check':'close'?></i>
				</button>
			</td>
			<td>
				<button type="button" class="btn btn-sm p-1 <?=$r->highlight==1?'btn-success':''?> editmenu" data-toggle="tooltip" title="<?=$r->highlight==1?'Click để tắt':'Click để bật'?>"
					field="highlight" item-id="<?=$r->id?>" currentvalue="<?=$r->highlight?>" cms-change-field="changfield"><i class="material-icons"><?=$r->highlight==1?'check':'close'?></i>
				</button>
			</td>
			<td>
				<button type="button" class="btn btn-sm p-1 <?=$r->new==1?'btn-success':''?> editmenu" data-toggle="tooltip" title="<?=$r->new==1?'Click để tắt':'Click để bật'?>"
					field="new" item-id="<?=$r->id?>" currentvalue="<?=$r->new?>" cms-change-field="changfield"><i class="material-icons"><?=$r->new==1?'check':'close'?></i>
				</button>
			</td>
			<td><?=$r->updated_at?></td>
			<td><?=isset($r->productUpdateBy)?$r->productUpdateBy->name:''?></td>
			<td style="text-align: center;">
				<div class="btn-group">
					<a class="btn btn-sm p-1 btn-info" href="/admin/product/detail?id=<?=$r->id?>" data-toggle="tooltip" title="Sửa">
						<i class="material-icons">border_color</i>
					</a>
					<a class="btn btn-sm p-1 btn-success editmenu" href="/admin/product/detail?id=<?=$r->id?>&act=copy" data-toggle="tooltip" title="Copy dữ liệu">
						<i class="material-icons">content_copy</i>
					</a>
					<a class="btn btn-sm p-1 btn-warning move-top-button" product-id="<?=$r->id?>" data-toggle="tooltip" title="Đưa lên đầu tiên">
						<i class="material-icons">call_made</i>
					</a>
					<button class="btn btn-sm p-1 btn-danger delete-button"
						data-toggle="tooltip" data-placement="top" title="Xóa" delete-id="<?=$r->id?>">
						<i class="material-icons">delete</i>
					</button>
				</div>
			</td>
		</tr>
	@endforeach
	@else
	Không có dữ liệu được tìm thấy
	@endif
	</tbody>
</table>
{{ $product->links() }}