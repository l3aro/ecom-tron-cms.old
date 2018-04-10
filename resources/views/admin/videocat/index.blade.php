@extends('admin.layout.main') 
@section('title', 'Video Categories') 
@section('content')
{{ csrf_field() }}
<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <h1>Quản lý danh mục video</h1>
        </div>
        <div class="col-md-3 text-right">
            <a class="btn btn-sm btn-success" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i> </a>
        </div>
    </div>
	<div class="row">
		<div class="col">
				<a href="/admin/videocat/detail" class="btn btn-sm btn-info pull-right my-2">
					<i class="material-icons">create_new_folder</i>
				</a>
				<a id="btn-del-all" href="#" class="btn btn-sm btn-danger my-2" data-toggle="tooltip" title="Xóa toàn bộ mục đã chọn" href="#">
					<i class="material-icons">delete_forever</i>
				</a>
		</div>
	</div>
	<div class="table-responsive" id="cat_table">
		@include('admin/videocat/list_categories')
	</div>
</div>
<script>
    $(window).on('hashchange', function() {
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            } else {
                get_list_categories(page);
            }
        }
    });

	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
		$('#menu-list-cat-video').parent('li').addClass('active');
		init_row_action();
	});
	
	{{--  Get list categories each time user change page  --}}
	function get_list_categories(page) {
        $.ajax({
            url : '?page=' + page,
            dataType: 'json',
        }).done(function (data) {
            $('#cat_table').html(data);
           	location.hash = page;
			init_row_action();
        }).fail(function () {
            alert('Posts could not be loaded.');
        });
    }

	{{--  Initialize row action  --}}
	function init_row_action() {
		$('#btn-ck-all').click(function(){
			var checkBoxes = $(".checkdel");
	        checkBoxes.prop("checked", !checkBoxes.prop("checked"));
	        if ($('input.checkdel:checkbox:checked').length == $('input.checkdel:checkbox').length){
		        $('#btn-ck-all i').text('check_box')
	        } else if ($('input.checkdel:checkbox:checked').length > 0) {
		        $('#btn-ck-all i').text('indeterminate_check_box')
	        } else {
		        $('#btn-ck-all i').text('check_box_outline_blank');
	        }
		});
		$('.delete-button').click(function(e){
			e.preventDefault();
			if (confirm('Bạn có chắc chắn muốn xóa?')){
				$.ajax({
					url: $(this).attr('href'),
					async: false,
					success: function(data) {
						if (data != 0) {
							alert(data);
							return;
						} else {
							location.reload();
						}
					}
				});
			}
		});
		$("#btn-del-all").click(function(){
			var countchecked = $('input.checkdel:checkbox:checked').length;
			if (countchecked > 0){
				if (confirm('Bạn có chắc chắn muốn xóa?')){
					var delstr = '';					
					$('input.checkdel:checkbox:checked').each(function(index){
						$.ajax({
							url: '/admin/videocat/delete/' + $(this).attr('del-id'),
							async: false,
							success: function(data) {
								if (data != 0) {
									alert(data);
								}
							}
						});
					});
					location.reload();
				}
			} else {
				return false;
			}
			});
		$(".checkdel").change(function(){
	        if ($('input.checkdel:checkbox:checked').length == $('input.checkdel:checkbox').length){
		        $('#btn-ck-all i').text('check_box')
	        } else if ($('input.checkdel:checkbox:checked').length > 0) {
		        $('#btn-ck-all i').text('indeterminate_check_box')
	        } else {
		        $('#btn-ck-all i').text('check_box_outline_blank');
	        }
		});
		$( ".sortcat" ).sortable({
			handle: ".connect",
			placeholder: "ui-state-highlight",
	      	update: function(event, ui) {
	        sort = $(this).sortable('toArray');
	        $.post('/admin/videocat/sortcat', {sort: sort, _token : $('input[name=_token]').val()});
	      }
	    });
	}
</script>
@endsection