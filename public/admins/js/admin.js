
$(document).ready(function(){
    $("[data-toggle=tooltip]").tooltip();
    $('#sidebar li.active').parents('div.collapse').collapse('show');
});

function showloading(){
    var htmlshow = '<div class="showbox"><div class="loader"><svg class="circular" viewBox="25 25 50 50"><circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/></svg></div></div>';
    return htmlshow;
}