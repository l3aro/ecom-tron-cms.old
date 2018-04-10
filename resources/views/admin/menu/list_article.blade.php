<div class="row">
	<div class="col-md-12">
<hr/>
</div>
</div>
<div class="row">
	<div class="col-md-3">
		<input type="text" id="keyword" class="form-control search-input" placeholder="Tìm kiếm..." aria-label="Search for..." value="<?=$keyword?>">
	</div>
	<div class="col-md-3">
		<select id="cat" name="cat" class="form-control search-change">
			<?=$list_cat?>
		</select>
	</div>
</div>
<div class="row">
	<div class="col-md-12 mt-3">
<table class="table-sm table-hover table-bordered mb-2" id="table_content" width="100%">
	<thead class="thead-light">
		<tr>
			<th class="align-middle" style="width: 50px;">ID</th>
			<th class="align-middle">Tên bài viết</th>
			<th class="align-middle">Mục</th>
			<th class="align-middle text-center" style="width: 160px;">Thao tác</th>
		</tr>
	</thead>
	<tbody class="sort">
	@if(isset($article) && count($article))
	@foreach ($article as $key=>$r)
		<tr id="item_<?=$r->id?>">
			<td><?=$r->id?></td>
			<td class="edit-name">
				<a class="choose-record" href="javascript:void(0)" record-id="<?=$r->id?>" record-name="<?=$r->name?>"><?=$r->name?></a>
			</td>
			<td>
				<?=$r->cat==0?'':$r->article_cat->name?>
			</td>
			<td style="text-align: center;">
				<div class="btn-group">
					<a class="btn btn-sm p-1 btn-info choose-record" href="javascript:void(0)" record-id="<?=$r->id?>" record-name="<?=$r->name?>">
						<i class="material-icons">check_circle</i> Chọn
					</a>
				</div>
			</td>
		</tr>
	@endforeach
	@else
	Không có dữ liệu được tìm thấy
	@endif
	</tbody>
</table>
</div>
</div>
{{ $article->links() }}