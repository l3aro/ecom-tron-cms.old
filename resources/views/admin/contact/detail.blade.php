@extends('admin.layout.main')
@section('title', 'Contact')
@section('content')
<div class="row">
    <div class="col-lg-6">
        <h1>Thông tin liên hệ</h1>
    </div>
    <div class="col-lg-6 text-right">
        <button onclick="window.location = '/admin/contact';return false;" class="btn btn-sm">
            <i class="material-icons">reply</i>Quay lại
        </button>
    </div>
</div>  
<form id="frm-product-action" method="post" action="/admin/contact/detail?id=<?=$infouser->id?>" enctype="multipart/form-data">
    <table class="table">
        <tr>
            <td>Họ Tên:</td>
            <td align="left">
                <?php echo $infouser->name;?>												
            </td>
        </tr>
        <tr>
            <td>Điên thoại:</td>
            <td align="left">
                <?php echo $infouser->phone;?>												
            </td>
        </tr>
        <tr>
            <td>Email:</td>
            <td align="left">
                <?php echo $infouser->email;?>												
            </td>
        </tr>
        <tr>
            <td>Địa chỉ:</td>
            <td align="left">
                <?php echo $infouser->address;?>												
            </td>
        </tr>
        <tr>
            <td>Nội dung:</td>
            <td align="left">
                <?php echo $infouser->content;?>												
            </td>
        </tr>				
            
    </table>
<script type="text/javascript">
	$('#menu-contact').parent('li').addClass('active');
</script>
</form>
@endsection