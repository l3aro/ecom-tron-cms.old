<FORM id="delform" action="" method="post" >
{{ csrf_field() }}
    <table class="table-sm table-hover table-bordered mb-2" id="table_content" cellspacing="1" cellpadding="1" width="100%">
        <THEAD>
            <TR>
                <TH class=" align-middle" style="text-align:center;width:40px;">ID</TH>
                <TH class=" align-middle" style="width:300px;">Nhận biết</TH> 
                <TH class=" align-middle">Code</TH>
                @foreach($lang as $key=>$value)
                    <TH class=" align-middle"><A href="">{{ $value->name }}</A></TH>
                @endforeach
                <TH class="text-center align-middle" style="text-align:center;width:80px;">Thao tác</TH>
            </TR>
        </THEAD>
        <TBODY>
        @foreach($lang_key as $key=>$lang_key)
            <TR id="item_{{ $lang_key->id }}">
                <TD align="center">{{ $lang_key->id }}</TD>
                <TD><a href="/admin/language/language?id={{ $lang_key->id }}">{{ $lang_key->name }}</a></TD>
                <TD>{{ $lang_key->code }}</TD>
                @if (isset($lang_key['value']))
                    @foreach($lang as $key3=>$lang_data)
                <TD>
                    <INPUT type="hidden" class="id" value="{{$lang_key['value'][$key3]['id']}}">
                    <INPUT type="hidden" class="shortname" value="{{$lang_key['value'][$key3]['lang']}}">
                    <INPUT type="text" class="detail form-control input-sm" style="width: 90%" id="detail_{{ $lang_key['value'][$key3]['lang'] }}" name="detail_{{ $lang_key['value'][$key3]['lang'] }}" value="<?php echo $lang_key['value'][$key3]['value'] ?>" />
                </TD>
                    @endforeach
                @endif
                
                <TD style="text-align: center; width: 80px;">
                    <div class="btn-group">
                        <a class="btn p-1 btn-sm btn-success" href="#"data-toggle="tooltip" title="Lưu"><i class="material-icons">save</i></a>
                        <a class="btn p-1 btn-info btn-sm" href="/admin/language/language?id={{ $lang_key->id }}" data-toggle="tooltip" title="Sửa"><i class="material-icons">border_color</i></a>
                        
                    </div>
                </TD>
            </TR>
            @endforeach
        </TBODY>
    </TABLE>
</FORM>
<script>
    $(document).ready(function(){
        $("[data-toggle=tooltip]").tooltip();

		$('#menu-list-contact').parent('li').addClass('active');

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
        $(".checkdel").change(function(){

	        if ($('input.checkdel:checkbox:checked').length == $('input.checkdel:checkbox').length){

		        $('#btn-ck-all i').text('check_box')

	        } else if ($('input.checkdel:checkbox:checked').length > 0) {

		        $('#btn-ck-all i').text('indeterminate_check_box')

	        } else {

		        $('#btn-ck-all i').text('check_box_outline_blank');

	        }

		});
    });
</script>