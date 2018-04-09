<div id="sidebar">
    <ul class="nav flex-column flex-nowrap left-menu">
        <li class="nav-item"><a class="nav-link" id="menu-dashboard" href="/admin"><i class="material-icons">dashboard</i> Tổng quan hệ thống</a></li>
        <?php if (env('MODULE_PRODUCT')) {?>
        <li class="nav-item has-child">
            <a class="nav-link collapsed" href="#submenu1" data-toggle="collapse" data-target="#submenu1"><i class="material-icons">group_work</i> Sản phẩm</a>
            <div class="collapse" id="submenu1" aria-expanded="false">
                <ul class="flex-column nav">
                    <li class="nav-item"><a class="nav-link" id="menu-add-new-product" href="/admin/product/detail">Tạo mới sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-list-product" href="/admin/product">Quản lý sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-add-cat-product" href="/admin/productcat/detail">Thêm mới danh mục sản phẩm</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-list-cat-product" href="/admin/productcat">Quản lý danh mục sản phẩm</a></li>
                </ul>
            </div>
        </li>
        <?php } ?>
        <li class="nav-item has-child">
            <a class="nav-link collapsed" href="#submenu2" data-toggle="collapse" data-target="#submenu2"><i class="material-icons">description</i> Tin bài</a>
            <div class="collapse" id="submenu2" aria-expanded="false">
                <ul class="flex-column nav">
                    <li class="nav-item"><a class="nav-link" id="menu-add-new-article" href="/admin/article/detail">Tạo bài mới</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-list-article" href="/admin/article">Quản lý tin bài</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-add-cat-article" href="/admin/articlecat/detail">Thêm mới danh mục tin bài</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-list-cat-article" href="/admin/articlecat">Quản lý danh mục tin bài</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item has-child">
            <a class="nav-link collapsed" href="#gallerysubmenu" data-toggle="collapse" data-target="#gallerysubmenu"><i class="material-icons">collections</i> Slide & Album ảnh</a>
            <div class="collapse" id="gallerysubmenu" aria-expanded="false">
                <ul class="flex-column nav">
                    <li class="nav-item"><a class="nav-link" id="menu-add-new-gallery" href="/admin/gallery/detail">Tạo album ảnh mới</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-list-gallery" href="/admin/gallery">Quản lý album ảnh</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-add-cat-gallery" href="/admin/gallerycat/detail">Thêm mới danh mục album ảnh</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-list-cat-gallery" href="/admin/gallerycat">Quản lý danh mục album ảnh</a></li>
                </ul>
            </div>
        </li>
        <?php if (env('MODULE_VIDEO')) {?>
        <li class="nav-item has-child">
            <a class="nav-link collapsed" href="#videosubmenu" data-toggle="collapse" data-target="#videosubmenu"><i class="material-icons">video_library</i> Video</a>
            <div class="collapse" id="videosubmenu" aria-expanded="false">
                <ul class="flex-column nav">
                    <li class="nav-item"><a class="nav-link" id="menu-add-new-video" href="/admin/video/detail">Tạo video mới</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-list-video" href="/admin/video">Quản lý video</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-add-cat-video" href="/admin/videocat/detail">Thêm mới danh mục video</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-list-cat-video" href="/admin/videocat">Quản lý danh mục video</a></li>
                </ul>
            </div>
        </li>
        <?php } ?>
        <?php if (env('MODULE_ORDER')) {?>
        <li class="nav-item"><a class="nav-link" id="menu-order" href="/admin/order"><i class="material-icons">shopping_cart</i> Đặt hàng</a></li>
        <?php } ?>
        <li class="nav-item"><a class="nav-link" id="menu-contact" href="/admin/contact"><i class="material-icons">contact_mail</i> Liên hệ</a></li>
        <li class="nav-item"><a class="nav-link" id="menu-common-page" href="/admin/component"><i class="material-icons">extension</i> Thành phần tĩnh</a></li>
        
        <li class="nav-item has-child">
            <a class="nav-link collapsed" href="#menusubmenu" data-toggle="collapse" data-target="#menusubmenu"><i class="material-icons">menu</i> Menu</a>
            <div class="collapse" id="menusubmenu" aria-expanded="false">
                <ul class="flex-column nav">
                    <li class="nav-item"><a class="nav-link" id="menu-menu-detail" href="/admin/menucat/detail">Tạo menu mới</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-menu" href="/admin/menucat">Quản lý menu</a></li>
                </ul>
            </div>
        </li>
        <?php if (env('MODULE_LANGUAGE')) {?>
        <li class="nav-item"><a class="nav-link" id="menu-language" href="/admin/language"><i class="material-icons">language</i> Ngôn ngữ</a></li>
        <?php } ?>
        <li class="nav-item has-child">
            <a class="nav-link collapsed" href="#menu-admin-user" data-toggle="collapse" data-target="#menu-admin-user"  style="padding-right:0px;"><i class="material-icons">face</i> Quản trị viên & Người dùng</a>
            <div class="collapse" id="menu-admin-user" aria-expanded="false">
                <ul class="flex-column nav">
                    <li class="nav-item"><a class="nav-link" id="menu-add-admin-user" href="/admin/user/info"> Thêm mới quản trị viên & người dùng</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-admin" href="/admin/user"> Danh sách quản trị viên</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-user" href="/admin/user"> Danh sách người dùng</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item"><a class="nav-link" id="menu-file" href="/admin/setting/file"><i class="material-icons">sd_storage</i> Quản lý file</a></li>
        <li class="nav-item has-child">
            <a class="nav-link collapsed" href="#setting-sub-menu" data-toggle="collapse" data-target="#setting-sub-menu"><i class="material-icons">settings</i> Thiết lập hệ thống</a>
            <div class="collapse" id="setting-sub-menu" aria-expanded="false">
                <ul class="flex-column nav">
                    <li class="nav-item"><a class="nav-link" id="menu-setting-index" href="/admin/setting/info"> Thông tin</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-setting-seo" href="/admin/setting/seo">Tối ưu SEO trang chủ</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-setting-email" href="/admin/setting/sendmail">Tài khoản gửi email</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-backup" href="/admin/backup">Sao lưu & Phục hồi dữ liệu</a></li>
                    <li class="nav-item"><a class="nav-link" id="menu-setting-emailcontent" href="/admin/setting/emailcontent">Nội dung email gửi đi</a></li>
                </ul>
            </div>
        </li>
    </ul>
</div>