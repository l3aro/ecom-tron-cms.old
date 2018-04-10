@extends('admin.layout.main')
@section('title', 'Setting')
@section('content')
<h1> Quản lý file trên hệ thống</h1><br>
<iframe style="width: 100%; height: 100%; position: relative; border: 0;" src="/admins/ckfinder/ckfinder.html?Type=Files&langCode=vi"></iframe>
<script type="text/javascript">
$(document).ready(function() {
$('#menu-file').parent('li').addClass('active');
});
</script>
@endsection