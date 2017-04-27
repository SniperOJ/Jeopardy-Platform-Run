var form_modal = $('.cd-user-modal');
var form_login = $('#cd-login');
var form_register = $('#cd-register');
var form_forget = $('#cd-forget');
var form_reset = $('#cd-reset');
var form_modal_tab = $('.cd-switcher')

var tab_login = form_modal_tab.children('li').eq(0).children('a');
var tab_register = form_modal_tab.children('li').eq(1).children('a');
var tab_forget = form_modal_tab.children('li').eq(2).children('a');
var tab_reset = form_modal_tab.children('li').eq(3).children('a');

$('.cd-login').on('click', function() {
    form_modal.addClass('is-visible');
    login_selected();
});

$('.cd-register').on('click', function() {
    form_modal.addClass('is-visible');
    register_selected();
});

//关闭弹出窗口
$('.cd-user-modal').on('click', function(event){
    if( $(event.target).is(form_modal) || $(event.target).is('.cd-close-form') ) {
        form_modal.removeClass('is-visible');
    }
});
//使用Esc键关闭弹出窗口
$(document).keyup(function(event){
    if(event.which=='27'){
        form_modal.removeClass('is-visible');
    }
});

//切换表单
form_modal_tab.on('click', function(event) {
    event.preventDefault();
    if ($(event.target).is(tab_login)){
        login_selected();
        return;
    }

    if ($(event.target).is(tab_register)){
        register_selected();
        return;
    }

    if ($(event.target).is(tab_forget)){
        forget_selected();
        return;
    }

    if ($(event.target).is(tab_reset)){
        reset_selected();
        return;
    }
});

function login_selected(){
    get_captcha()

    form_login.addClass('is-selected');
    form_register.removeClass('is-selected');
    form_forget.removeClass('is-selected')
    form_reset.removeClass('is-selected');

    tab_login.addClass('selected');
    tab_register.removeClass('selected');
    tab_forget.removeClass('selected');
    tab_reset.removeClass('selected');
}

function register_selected(){
    get_captcha()

    form_register.addClass('is-selected');
    form_login.removeClass('is-selected');
    form_forget.removeClass('is-selected')
    form_reset.removeClass('is-selected');
    
    tab_register.addClass('selected');
    tab_login.removeClass('selected');
    tab_forget.removeClass('selected');
    tab_reset.removeClass('selected');
}

function forget_selected(){
    get_captcha()

    form_forget.addClass('is-selected')
    form_login.removeClass('is-selected');
    form_register.removeClass('is-selected');
    form_reset.removeClass('is-selected');

    tab_forget.addClass('selected');
    tab_login.removeClass('selected');
    tab_register.removeClass('selected');
    tab_reset.removeClass('selected');
}

function reset_selected(){
    form_reset.addClass('is-selected');
    form_forget.removeClass('is-selected')
    form_login.removeClass('is-selected');
    form_register.removeClass('is-selected');

    tab_reset.addClass('selected');
    tab_forget.removeClass('selected');
    tab_login.removeClass('selected');
    tab_register.removeClass('selected');
}


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