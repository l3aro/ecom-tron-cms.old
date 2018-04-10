@extends('admin.layout.main') 
@section('title', 'Article Categories') 
@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-9">
            <h1>Quản lý danh mục</h1>
        </div>
        <div class="col-md-3 text-right">
            <a class="btn btn-sm btn-success" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i> </a>
        </div>
    </div>
	<div class="row">
		<div class="col">
				<a href="/admin/articlecat/detail" class="btn btn-sm btn-info pull-right my-2">
					<i class="material-icons">create_new_folder</i>
				</a>
				<a id="btn-del-all" href="#" class="btn btn-sm btn-danger my-2" data-toggle="tooltip" title="Xóa toàn bộ mục đã chọn" href="#">
					<i class="material-icons">delete_forever</i>
				</a>
		</div>
	</div>
	<div class="table-responsive" id="cat_table">
		<form role="form" id="delform">
		{{ csrf_field() }}
		@include('admin/articlecat/list')
		</form>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
		$('#menu-list-cat-article').parent('li').addClass('active');
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
			if (confirm('Hành động này sẽ xóa mục và toàn bộ mục con của nó!\nBạn chắc chắn xóa các mục đã chọn ?')){
				token = $('#delform input[name="_token"]').val();
				$.ajax({
					url: $(this).attr('href'),
					async: false,
					data: {_token: token},
					method: "POST",
					success: function(data) {
						if (data == 0) {
							alert('Đã xóa!');
							window.location.href = "/admin/articlecat";
						} else {
							alert('Một số mục chưa thể xóa!')
							window.location.href = "/admin/articlecat";
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
						delstr += $(this).attr('del-id') + ',';
					});
					var token = $('#delform input[name="_token"]').val();
					$.ajax({
						url: '/admin/articlecat/delete/' + delstr,
						async: false,
						type: "POST",
						data: {_token: token},
						success: function(data) {
							if (data != 1) {
								alert(data);
								window.location.href = "/admin/articlecat";
							}
							else {
								alert('Deleted');
								window.location.href = "/admin/articlecat";
							}
						}
					});
					
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
	        $.post('/admin/articlecat/sortcat', {sort: sort, _token : $('input[name=_token]').val()});
	      }
	    });
	}
</script>
@endsection