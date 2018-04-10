@extends('admin.layout.main')
@section('title', 'Articles')
@section('content')
<div class="containter-fluid">
    <div class="row">
        <div class="col-5">
            <h1> Tin bài </h1>
        </div>
        <div class="col-6 text-right">
            <div class="form-row">
                <div class="col-11">
                    <div class="input-group">
                        <input type="text" id="keyword" class="form-control search-input" placeholder="Tìm kiếm..." aria-label="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-sm p-2" type="button" data-toggle="collapse" href="#advancesearch" aria-expanded="false" aria-controls="advancesearch">
                                <i class="material-icons" data-toggle="tooltip" title="Tìm kiếm nâng cao">expand_more</i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="col-1">
                <button type="submit" class="btn btn-sm btn-info align-left" id="search-button"><i class="material-icons">search</i></button>
                </div>
            </div>
        </div>
        <div class="col-1 text-right">
            <a class="btn btn-sm btn-success" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i> </a>
        </div>
    </div>
    <div class="row collapse multi-collapse" id="advancesearch">
        <div class="col-12">
            <div class="form-row">
                <div class="form-group col">
                    <label for="inputCity">Mục</label>
                    <select id="cat" name="f_cat" class="form-control search-change">
                        <?=$list_cat?>
                    </select>
                </div>
                <div class="form-group col">
                    <label for="user">Người tạo</label>
                    <select id="user" name="f_lastchange" class="form-control search-change">
						<option value="0" hidden> </option>
                        @isset($list_mod)
						@foreach($list_mod as $key=>$value)
						<option value="<?=$value->id?>" <?=isset($filter['lastchange'])&&($filter['lastchange']==$value->id)?'selected':''?> ><?=$value->name?></option>
						@endforeach
						@endif
                    </select>
                </div>
                <div class="form-group col">
                    <label for="inputZip">Từ ngày</label>
                    <input type="text" class="form-control datepicker search-change" name="f_fromdate" id="from_date" value="<?=isset($filter['fromdate'])?$filter['fromdate']:'';?>">
                </div>
                <div class="form-group col">
                    <label for="inputZip">Đến ngày</label>
                    <input type="text" class="form-control datepicker search-change" name="f_todate" id="to_date" value="<?=isset($filter['todate'])?$filter['todate']:'';?>">
                </div>
            </div>
        </div>      
    </div>
    <div class="row mt-2 mb-2">
        <div class="col-md-6 text-left">
            <a class="btn btn-sm btn-info" href="/admin/article/detail" data-toggle="tooltip" title="Thêm bài viết mới"><i class="material-icons">note_add</i></a>
                <a id="btn-del-all" href="#" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Xóa toàn bộ mục đã chọn" href="#">
                    <i class="material-icons">delete_forever</i>
                </a>
        </div>
        <div class="col-md-6 text-right">
            
        </div>
    </div>
    <div class="table-responsive" id="cat_table">
		{{ csrf_field() }}
		@include('admin/article/list')
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#menu-list-article').parent('li').addClass('active');
        $('.datepicker').datepicker({
			showButtonPanel: true,
			dateFormat: 'yy-mm-dd'
		});
        $('#keyword').keyup(function(){
            delay(function(){
                run_search();
            }, 500 );
        });
        $('.search-change').change(function(){
            run_search();
        });
        $('#search-button').click(function(){
            run_search();
        });
        init_row_action();
    });
	function init_row_action() {
        $("[data-toggle=tooltip]").tooltip();
        $('.pagination li').addClass('page-item');
        $('.pagination li a').addClass('page-link');
        $('.pagination li span').addClass('page-link');
        $('.pagination li a').click(function(e){
            e.preventDefault();
            run_search($(this).attr('href').split('page=')[1]);
        });

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
                var delete_id = $(this).attr('delete-id');
                $('#cat_table').html(showloading());
				$.ajax({
					url: '/admin/article/delete/' + delete_id,
					async: true,
					method: 'GET',
					success: function(){
						window.location.href="/admin/article";
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
					token = $('#delform input[name="_token"').val();
					$.ajax({
						url: '/admin/article/delete/' + delstr,
						async: false,
						method: "POST",
						data: {_token:token},
						success: function(data) {
							if (data != 0) {
								alert(data);
							}
						}
					});
					run_search();
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
		$( ".sort" ).sortable({
			handle: ".connect",
			placeholder: "ui-state-highlight",
	      	update: function(event, ui) {
                sort = $(this).sortable('toArray');
                $.post('/admin/article/sort', {sort: sort, _token : $('input[name=_token]').val()});
            }
	    });
		$('.move-top-button').click(function(e){
			e.preventDefault();
            $("[data-toggle=tooltip]").tooltip('hide');
            var article_id = $(this).attr('article-id');
            var cat_id = $('#cat').val();
            if(!cat_id) cat_id = 0;
            $('#cat_table').html(showloading());
            $.ajax({
                url: '/admin/article/movetop/' + article_id + '/' + cat_id,
                async: true,
                success: function(data) {
                    if (data != 0) {
                        alert(data);
                        return;
                    } else {
                        run_search();
                    }
                }
            });
        });
        $('button[cms-change-field="changfield"]').click(function(){
			var obj = $(this);
			var currentvalue = $(this).attr('currentvalue');
			var id = $(this).attr('item-id');
			var field = $(this).attr('field');
			$.ajax({
				  url: '/admin/article/changefield?id=' + id + '&p=' + currentvalue + '&field=' + field,
				  success: function(data) {
				  	if (currentvalue==0) { 
				  		pic = 'check';
				  		currentvalue = 1;
				  		tooltip = 'Click để tắt';
				  		cl = 'btn-success';
				  	} else { 
				  		pic = 'close';
				  		currentvalue = 0;
				  		tooltip = 'Click để bật';
				  		cl = '';
				  	}
				  	obj.attr('currentvalue', currentvalue);
				  	obj.attr('class', 'btn btn-sm p-1 ' + cl + '');
					obj.html('<i class="material-icons">' + pic + '</i>');
				  	obj.attr('data-original-title', tooltip);
				  }
				});
		});
    }
    function run_search(page){
        $("[data-toggle=tooltip]").tooltip('hide');
        $('#cat_table').html(showloading());
        var keyword = $('#keyword').val();
        var cat = $('#cat').val();
        var user = $('#user').val();
        var fromDate = $('#from_date').val();
        var toDate = $('#to_date').val();
        $.ajax({
            url: '/admin/article?f_name=' + keyword + '&f_cat=' + cat + '&f_lastchange=' + user + '&f_fromdate=' + fromDate + '&f_todate=' + toDate + '&page=' + page,
            type: 'GET',
            success: function(data) {
                $('#cat_table').html(data);
                init_row_action();
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