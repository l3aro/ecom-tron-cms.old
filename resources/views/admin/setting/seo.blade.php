@extends('admin.layout.main')
@section('title', 'Setting')
@section('content')
<h1> Tối ưu hóa SEO cho trang chủ của hệ thống</h1><br>
<?php if ($saved) {?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
<strong>Lưu dữ liệu thành công!</strong> Dữ liệu đã được lưu vào cơ sở dữ liệu.
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<?php } ?>
<form id="formvalidate" name="form_system" action="" method="post" enctype="multipart/form-data" >
{{ csrf_field() }}
<div class="save-group-buttons">
<button name="submit" class="btn btn-sm btn-success"><i class="material-icons">save</i> Lưu</button>
<a class="btn btn-sm btn-info" href="https://drive.google.com/drive/folders/1HCQDgAW3zdZhjq9-Jgfwlep9kZjEkbnc?usp=sharing" target="_blank"><i class="material-icons">help_outline</i> </a>
</div>
<div class="row">
<div class="col-sm-12">
    <div class="form-group">
        <label class="control-label" for="focusedInput">Tiêu đề trên thanh công cụ Browser:</label> 
        <input type="text" name="seo_page_title" id="title" class="form-control" value="<?=$setting->seo_page_title?>" placeholder="Browser title" required/>
        <small class="form-text text-muted">Tiêu đề của trang chủ có tác dụng tốt nhất cho SEO. Thiết lập tiêu để chuẩn SEO sẽ giúp tối ưu hóa tốt hơn.</small>
    </div>
    <div class="form-group">
        <label class="control-label" for="focusedInput">Thẻ meta page-topic</label> 
        <input type="text" name="seo_meta_page_topic" id="metapagetopic" class="form-control" value="<?=$setting->seo_meta_page_topic?>" placeholder="Meta-page-toptic" required/>
        <small class="form-text text-muted">Theo chuẩn SEO, thẻ meta page topic sẽ là tiêu điểm của trang web đang có nội dung nói về chủ đề nào</small>
    </div>
    <div class="form-group">
        <label class="control-label" for="focusedInput">Thẻ meta copyright</label> 
        <input type="text" name="seo_meta_copyright" id="copyright" class="form-control" value="<?=$setting->seo_meta_copyright?>" placeholder="Copyright" required/>
        <small class="form-text text-muted">Copyright là thông tin về bản quyền về mặt nội dung trên trang web đang hiển thị</small>
    </div>
    <div class="form-group">
        <label class="control-label" for="focusedInput">Thẻ meta author</label> 
        <input type="text" name="seo_meta_author" id="metaauthor" class="form-control" value="<?=$setting->seo_meta_author?>" placeholder="Author" required/>
        <small class="form-text text-muted">Author là tác giả của nội dung viết trên trang web</small>
    </div>
    <div class="form-group">
        <label class="control-label" for="focusedInput">Thẻ meta keywords</label> 
        <input type="text" name="seo_meta_keywords" id="metakeywords" class="form-control" value="<?=$setting->seo_meta_keywords?>" placeholder="Lập từ khóa tìm kiếm cho trang chủ" required/>
        <small class="form-text text-muted">Meta Keywords (Thẻ khai báo từ khóa trong SEO) Trong quá trình biên tập nội dung, Meta Keywords là một thẻ được dùng để khai báo các từ khóa dùng cho bộ máy tìm kiếm. Với thuộc tính này, các bộ máy tìm kiếm (Search Engine) sẽ dễ dàng hiểu nội dung của bạn đang muốn nói đến những vấn đề gì!</small>
    </div>
    <div class="form-group">
        <label class="control-label" for="focusedInput">Thẻ meta description</label> 
        <input type="text" name="seo_meta_des" id="metades" class="form-control" value="<?=$setting->seo_meta_des?>" placeholder="Meta-page-toptic" required/>
        <small class="form-text text-muted">Thẻ meta description của trang cung cấp cho Google và các công cụ tìm kiếm bản tóm tắt nội dung của trang đó. Trong khi tiêu đề trang có thể là vài từ hoặc cụm từ, thẻ mô tả của trang phải có một hoặc hai câu hoặc một đoạn ngắn. Thẻ meta description là một yếu tố SEO Onpage khá cơ bản cần được tối ưu cẩn thận</small>
    </div>
</div>
</div>
</form>
<script type="text/javascript">
$(document).ready(function() {
$('#menu-setting-seo').parent('li').addClass('active');
});
</script>

@endsection