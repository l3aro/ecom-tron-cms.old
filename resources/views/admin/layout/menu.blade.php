<div class="top-bar">
    <div class="logo-top-bar float-left">
      <a href="/admin"><img src="/admins/images/logongangadmin.png"/></a>
    </div>
    <div class="float-right right-top-bar">
      <div class="float-right">
          <div class="btn-group dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?php echo Auth::user()->name;?>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="/admin/user/profile?id=<?php echo Auth::user()->id;?>">Thay đổi thông tin cá nhân</a>
              <a class="dropdown-item" href="/admin/user/changepass">Đổi mật khẩu</a>
              <a class="dropdown-item" href="/admin/logout">Thoát</a>
            </div>
          </div>
          <a href="/admin/logout" class="btn btn-sm btn-outline-secondary"><i class="material-icons">power_settings_new</i></a>
      </div>
    </div>
</div>

<script>
  $(document).ready(function(){
    $('#lang-selector .dropdown-item').click(function(e) {
      e.preventDefault();
      var obj = $(this);
      var current_lang = $(this).attr('lang-id');
      console.log(current_lang);
      $.ajax({
        url: '/admin/changelang/' + current_lang,
        type: "GET",
        success: function(data){
          location.reload();
        }
      })
    })
  })

</script>