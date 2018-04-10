@extends('admin.layout.main')
@section('title', 'Menu')
@section('content')
<h1> Thông tin menu </h1>
<?php  if ($saved) {?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>Lưu dữ liệu thành công!</strong> Dữ liệu đã được lưu vào cơ sở dữ liệu.
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<?php  } ?>
<form method="post" action="/admin/menu/detail?id=<?=$menu->id?>&cat=<?=$menucat?>" enctype="multipart/form-data">
{{ csrf_field() }}
	<div class="save-group-buttons">
		<a class="btn btn-sm btn-primary" href="/admin/menu?cat=<?=$menucat?>"><i class="material-icons">backspace</i> Quay lại</a>
		<button name="submit" class="btn btn-sm btn-success"><i class="material-icons">save</i> Lưu</button>
		<a class="btn btn-sm btn-info" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i> </a>
	</div>
	<div class="row">
		<div class="col-md-6">
			<legend>Thông tin cơ bản</legend>
			<div class="form-group">
				<label class="control-label" for="focusedInput">Tên menu</label>
				<input class="form-control" name="name" type="text" required value="<?=$menu->name?>" placeholder="Tên mục">
				<small class="form-text text-muted">Tên của menu</small>
			</div>
			<div class="form-group">
				<label class="control-label">Menu này nằm trong menu</label>
				<select class="form-control" name="parent">
					<?=$menu_options?>
				</select>
				<small class="form-text text-muted">Đặt mục cha cho menu này, bạn có thể để trống để hiểu rằng đây là menu lớn nhất</small>
			</div>
			<div class="form-group" >
				<label class="control-label">Loại menu</label>
				<select class="form-control" name="type" id="list-option">
					<option value="0" <?php if($menu->type == 0) echo 'selected="selected"'; ?>>Link tùy chọn</option>
					<option value="1" <?php if($menu->type == 1) echo 'selected="selected"'; ?>>[Bài viết] Link đến một mục bài viết</option>
					<option value="2" <?php if($menu->type == 2) echo 'selected="selected"'; ?>>[Bài viết] Đồng bộ với toàn bộ mục con của một mục</option>
					<option value="3" <?php if($menu->type == 3) echo 'selected="selected"'; ?>>[Bài viết] Đồng bộ mục bài viết</option>
					<option value="4" <?php if($menu->type == 4) echo 'selected="selected"'; ?>>[Bài viết] Link đến bài viết chỉ định</option>
					<option value="5" <?php if($menu->type == 5) echo 'selected="selected"'; ?>>[Sản phẩm] Link đến một mục sản phẩm</option>
					<option value="6" <?php if($menu->type == 6) echo 'selected="selected"'; ?>>[Sản phẩm] Đồng bộ với toàn bộ mục con của một mục</option>
					<option value="7" <?php if($menu->type == 7) echo 'selected="selected"'; ?>>[Sản phẩm] Đồng bộ mục sản phẩm</option>
					<option value="8" <?php if($menu->type == 8) echo 'selected="selected"'; ?>>[Sản phẩm] Link đến sản phẩm chỉ định</option>
				</select>
			</div>
			<?php
			if($menu->type == 0) {
				$hide = false;
			} else {
				$hide = true;
			}?>
			<div class="form-group <?php echo $hide ? 'd-none' : 'd-block'; ?>" id="form-link"  >
				<label class="control-label">URL</label>
				<input class="form-control" name="link" type="text"
					value="<?=$menu->link?>"
					placeholder="URL (Link)">
				<small>Khi click vào menu này sẽ chuyển hướng đến URL chỉ định</small>
			</div>

			 <?php
			if($menu->type == 1 || $menu->type == 2) {
				$hide = false;
			} else {
				$hide = true;
			}?>
			<div class="form-group <?php echo $hide ? 'd-none' : 'd-block'; ?>" id="form-article-cat">
				<label class="control-label">Chọn mục</label>
				<select class="form-control" name="article_cat">
					<?=$article_cat_options?>
				</select>
			</div>
			<?php
			if($menu->type == 5 || $menu->type == 6) {
				$hide = false;
			} else {
				$hide = true;
			}?>
			<div class="form-group <?php echo $hide ? 'd-none' : 'd-block'; ?>" id="form-product-cat">
				<label class="control-label">Chọn mục</label>
				<select class="form-control" name="product_cat">
					<?=$product_cat_options?>
				</select>
			</div>

		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-body">
					<legend>Chú thích loại menu</legend>
					<ul>
						<li class="mb-2"><b>Link tùy chọn:</b> Khi click vào menu này sẽ chuyển hướng đến URL chỉ định</li>
						<li class="mb-2"><b>[Bài viết] Link đến một mục bài viết:</b> Người dùng click vào menu này sẽ chuyển hướng trực tiếp đến trang list bài viết theo mục đã chọn</li>
						<li class="mb-2"><b>[Bài viết] Đồng bộ với toàn bộ mục con của một mục:</b> Hệ thống sẽ tự sinh ra các menu con là các mục con của mục đã chọn và mỗi menu con sẽ link đến trang list bài viết theo mục đã chọn</li>
						<li class="mb-2"><b>[Bài viết] Đồng bộ mục bài viết:</b> Hệ thống tự sinh ra toàn bộ mục bài viết có trong cơ sở dữ liệu theo đúng cấu trúc mục cha, con đã định</li>
						<li class="mb-2"><b>[Bài viết] Link đến bài viết chỉ định:</b> Khi click vào menu này sẽ chuyển hướng đến trang chi tiết của bài viết được chọn</li>
						<li class="mb-2"><b>[Sản phẩm] Link đến một mục sản phẩm:</b> Người dùng click vào menu này sẽ chuyển hướng trực tiếp đến trang list sản phẩm theo mục đã chọn</li>
						<li class="mb-2"><b>[Sản phẩm] Đồng bộ với toàn bộ mục con của một mục:</b> Hệ thống sẽ tự sinh ra các menu con là các mục con của mục đã chọn và mỗi menu con sẽ link đến trang list sản phẩm theo mục đã chọn</li>
						<li class="mb-2"><b>[Sản phẩm] Đồng bộ mục sản phẩm:</b> Hệ thống tự sinh ra toàn bộ mục sản phẩm có trong cơ sở dữ liệu theo đúng cấu trúc mục cha, con đã định</li>
						<li class="mb-2"><b>[Sản phẩm] Link đến sản phẩm chỉ định:</b> Khi click vào menu này sẽ chuyển hướng đến trang chi tiết của sản phẩm được chọn</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12" id="list-data-table">
		</div>
	</div>
	<input type="hidden" name="product_id" id="product_id" val="<?=$menu->product_id?>">
	<input type="hidden" name="article_id" id="article_id" val="<?=$menu->article_id?>">
</form>
<script>
	$(document).ready(function(){
		$('#menu-menu').parent('li').addClass('active');
		$('#list-option').change(function () {
			$('#list-data-table').html('');
            var selectedIndex = $("#list-option").find("option:selected").val();
            //Option selected: Link
            if (selectedIndex === "0") {
                $("#form-link").removeClass('d-none').addClass('d-block');
            } else {
                $("#form-link").removeClass('d-block').addClass('d-none');
            }
            //Option selected: Syn with Article Categories
            if (selectedIndex === "1" || selectedIndex === "2") {
                $("#form-article-cat").removeClass('d-none').addClass('d-block');
            } else {
                $("#form-article-cat").removeClass('d-block').addClass('d-none');
            }
            //Option selected: Syn with Product Categories
            if (selectedIndex === "5" || selectedIndex === "6") {
                $("#form-product-cat").removeClass('d-none').addClass('d-block');
            } else {
                $("#form-product-cat").removeClass('d-block').addClass('d-none');
            }
			if (selectedIndex === "4") {
				run_search_article();
			}
			if (selectedIndex === "8") {
				run_search_product();
			}
        });
		var selectedIndex = $("#list-option").find("option:selected").val();
		
		if (selectedIndex === "4") {
			display_article(<?=$menu->article_id?>);
		}
		if (selectedIndex === "8") {
			display_product(<?=$menu->product_id?>);
		}
	});
	function init_list_form_action() {
		$('#keyword').keyup(function(){
            delay(function(){
				var selectedIndex = $("#list-option").find("option:selected").val();
				if (selectedIndex === "4") {
					run_search_article();
				}
				if (selectedIndex === "8") {
					run_search_product();
				}
            }, 500 );
        });
        $('.search-change').change(function(){
			var selectedIndex = $("#list-option").find("option:selected").val();
			if (selectedIndex === "4") {
				run_search_article();
			}
			if (selectedIndex === "8") {
				run_search_product();
			}
        });
        $('.pagination li').addClass('page-item');
        $('.pagination li a').addClass('page-link');
        $('.pagination li span').addClass('page-link');
        $('.pagination li a').click(function(e){
            e.preventDefault();
			var selectedIndex = $("#list-option").find("option:selected").val();
			if (selectedIndex === "4") {
				run_search_article($(this).attr('href').split('page=')[1]);
			}
			if (selectedIndex === "8") {
				run_search_product($(this).attr('href').split('page=')[1]);
			}
        });
	}
	function init_row_action() {
		$('.choose-record').click(function(){
			var recordId = $(this).attr('record-id');
			var selectedIndex = $("#list-option").find("option:selected").val();
			if (selectedIndex === "4") {
				$('#article_id').val(recordId);
				display_article(recordId);
			}
			if (selectedIndex === "8") {
				$('#product_id').val(recordId);
				display_product(recordId);
			}
		});
	}
	function run_search_article(page){
		var keyword = $('#keyword').val();
		var cat = $('#cat').val();
		if(!keyword) keyword = '';
		if(!cat) cat = 0; 
		if(!page) page = 1; 
		$('#list-data-table').html(showloading());
		$.ajax({
			url: '/admin/menu/list_articles?keyword=' + keyword + '&cat=' + cat + '&page=' + page,
			type: 'GET',
			success: function(data) {
				$('#list-data-table').html(data);
				init_list_form_action();
				init_row_action();
			}
		});

	}
	function run_search_product(page){
		var keyword = $('#keyword').val();
		var cat = $('#cat').val();
		if(!keyword) keyword = '';
		if(!cat) cat = 0; 
		if(!page) page = 1; 
		$('#list-data-table').html(showloading());
		$.ajax({
			url: '/admin/menu/list_products?keyword=' + keyword + '&cat=' + cat + '&page=' + page,
			type: 'GET',
			success: function(data) {
				$('#list-data-table').html(data);
				init_list_form_action();
				init_row_action();
			}
		});

	}

	function display_article(id){
		$.ajax({
			url: '/admin/menu/get_article?id=' + id,
			type: 'GET',
			success: function(data) {
				var articleCatName = '';
				if (data.article_cat) articleCatName = data.article_cat.name;
				$('#list-data-table').html('Đang link đến bài viết: ' 
				+ '<table class="table-sm table-hover table-bordered mb-2" id="table_content" width="100%">'
				+ '<thead class="thead-light">'
				+	'<tr>'
					+	'<th class="align-middle" style="width: 50px;">ID</th>'
					+	'<th class="align-middle" style="width: 50px;">Ảnh</th>'
					+	'<th class="align-middle">Tên bài viết</th>'
					+	'<th class="align-middle">Mục</th>'
					+	'<th class="align-middle" style="width: 120px;">Ngày tạo</th>'
				+	'</tr>'
				+ '</thead>'
				+ '<tbody>'
				+ '<tr>'
				+ '<td>' + data.article.id + '</td>'
				+ '<td><img src="/media/article/' + data.article.image + '" height="100"></td>'
				+ '<td class="edit-name">'
				+	'<a href="/admin/article/detail/' + data.article.id + '" target="_blank">' + data.article.name + '</a>'
				+ '</td>'
				+ '<td>'
				+ '<a href="/admin/articlecat/detail/' + data.article.cat + '" target="_blank">' + articleCatName + '</a>'
				+ '</td>'
				+	'<td>' + data.article.updated_at + '</td>'
				+ '</tr>'
				+ '</tbody>'
				+ '</table>'
				+ '<button class="btn btn-sm btn-info button-choose-article">Chọn bài viết khác</button>'
				);
				$('.button-choose-article').click(function(e){
					e.preventDefault();
					run_search_article(0);
				});
			}
		});
	}

	function display_product(id){
		$.ajax({
			url: '/admin/menu/get_product?id=' + id,
			type: 'GET',
			success: function(data) {
				var productCatName = '';
				if (data.product_cat) productCatName = data.product_cat.name;
				$('#list-data-table').html('Đang link đến sản phẩm: ' 
				+ '<table class="table-sm table-hover table-bordered mb-2" id="table_content" width="100%">'
				+ '<thead class="thead-light">'
				+	'<tr>'
					+	'<th class="align-middle" style="width: 50px;">ID</th>'
					+	'<th class="align-middle" style="width: 50px;">Ảnh</th>'
					+	'<th class="align-middle">Tên sản phẩm</th>'
					+	'<th class="align-middle">Mục</th>'
					+	'<th class="align-middle" style="width: 120px;">Ngày tạo</th>'
				+	'</tr>'
				+ '</thead>'
				+ '<tbody>'
				+ '<tr>'
				+ '<td>' + data.product.id + '</td>'
				+ '<td><img src="/media/product/' + data.product.image + '" height="100"></td>'
				+ '<td class="edit-name">'
				+	'<a href="/admin/product/detail?id=' + data.product.id + '" target="_blank">' + data.product.name + '</a>'
				+ '</td>'
				+ '<td>'
				+ '<a href="/admin/productcat/detail?id=' + data.product.cat + '" target="_blank">' + productCatName + '</a>'
				+ '</td>'
				+	'<td>' + data.product.updated_at + '</td>'
				+ '</tr>'
				+ '</tbody>'
				+ '</table>'
				+ '<button class="btn btn-sm btn-info button-choose-product">Chọn sản phẩm khác</button>'
				);
				$('.button-choose-product').click(function(e){
					e.preventDefault();
					run_search_product(0)
				});
			}
		});
	}
    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();
</script>


@endsection