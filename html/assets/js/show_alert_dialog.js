function get_captcha() {
    $.ajax({
        type: "GET",
        url: "/user/get_captcha",
        dataType: "json",
        success: function(msg) {
            $(".captcha").html(msg.message)
        }
    });
}

$(document).ready(function($){
    var  $form_modal = $('.cd-user-modal'), 
    $form_login = $form_modal.find('#cd-login'), 
    $form_register = $form_modal.find('#cd-register'), 
    $form_modal_tab = $('.cd-switcher'),
    $tab_login = $form_modal_tab.children('li').eq(0).children('a'),
    $tab_register = $form_modal_tab.children('li').eq(1).children('a'),
    $main_nav = $('.main_nav');
    //弹出窗口
    $main_nav.on('click', function(event){

        if( $(event.target).is($main_nav) ) {
            // on mobile open the submenu
            $(this).children('ul').toggleClass('is-visible');
        } else {
            // on mobile close submenu
            $main_nav.children('ul').removeClass('is-visible');
            //show modal layer
            $form_modal.addClass('is-visible');
            //show the selected form
            ( $(event.target).is('.cd-register') ) ? register_selected() : login_selected();
        }
    });

    //关闭弹出窗口
    $('.cd-user-modal').on('click', function(event){
        if( $(event.target).is($form_modal) || $(event.target).is('.cd-close-form') ) {
            $form_modal.removeClass('is-visible');
        }
    });
    //使用Esc键关闭弹出窗口
    $(document).keyup(function(event){
        if(event.which=='27'){
            $form_modal.removeClass('is-visible');
        }
    });

    //切换表单
    $form_modal_tab.on('click', function(event) {
        event.preventDefault();
        ( $(event.target).is( $tab_login ) ) ? login_selected() : register_selected();
    });

    function login_selected(){
        // get captcha
        get_captcha()
        $form_login.addClass('is-selected');
        $form_register.removeClass('is-selected');
        // $form_forgot_password.removeClass('is-selected');
        $tab_login.addClass('selected');
        $tab_register.removeClass('selected');
    }

    function register_selected(){
        get_captcha()
        $form_login.removeClass('is-selected');
        $form_register.addClass('is-selected');
        // $form_forgot_password.removeClass('is-selected');
        $tab_login.removeClass('selected');
        $tab_register.addClass('selected');
    }

});