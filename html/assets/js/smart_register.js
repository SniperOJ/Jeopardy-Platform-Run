function log(word) {
    console.log(word)
}

function clear_attr(elem){
    $(elem).removeAttr("data-toggle").removeAttr("title").removeAttr("data-original-title").removeClass("tooltip-show");
}

function show_error(elem, message) {
    clear_attr(elem)
    $(elem).addClass("tooltip-show").attr("data-toggle","tooltip").attr("data-original-title", message)
    $(function () { $(elem).tooltip('show');});
}

function hide_tooltip(elem) {
    $(function () { $(elem).tooltip('hide');});
}

function disable_button_register() {
    $("#register-input-button").css("background-color","grey").attr("disabled", "disabled");
}

function release_button_register() {
    $("#register-input-button").css("background-color","green").removeAttr("disabled");
}

function trun_green(elem){
    $(elem).css("border-color", "#00FF00")
}

function trun_red(elem){
    $(elem).css("border-color","#FF0000");
}

$(document).ready(function() {
    $("#register-username").keyup(function(){
        var button = $("#register-input-button");
        var username = this.value;
        if(check_username_length(username) == false){
            show_error(this, "用户名长度必须大于等于4小于等于16!");
            trun_red(this)
            disable_button_register();
            return;
        }
        if(check_username_bad_chars(username) == false){
            show_error(this, "用户名只能由数字和字母组成!");
            trun_red(this)
            disable_button_register();
            return;
        }
        trun_green(this)
        hide_tooltip(this)
    });

    $("#register-password").keyup(function(){
        var button = $("#register-input-button");
        var password = this.value;
        if(check_password_length(password) == false){
            show_error(this, "密码长度必须大于等于6小于等于16!");
            trun_red(this)
            disable_button_register();
            return;
        }
        if(check_password_bad_chars(password) == false){
            show_error(this, "密码中存在非法字符!");
            trun_red(this)
            disable_button_register();
            return;
        }
        trun_green(this)
        hide_tooltip(this)
    });


    $("#register-email").keyup(function(){
        var button = $("#register-input-button");
        var email = this.value;
        if(check_email(email) == false){
            show_error(this, "请检查您的邮箱格式!");
            trun_red(this)
            disable_button_register();
            return;
        }
        trun_green(this)
        hide_tooltip(this)
    });

    $("#register-college").keyup(function(){
        var button = $("#register-input-button");
        var college = this.value;
        if(check_collenge_length(college) == false){
            show_error(this, "学校名称长度必须大于等于3小于等于64!");
            trun_red(this)
            disable_button_register();
            return;
        }
        trun_green(this)
        hide_tooltip(this)
    });

    $("#register-captcha").keyup(function(){
        var button = $("#register-input-button");
        var captcha = this.value;
        if(check_captcha_length(captcha) == false){
            show_error(this, "验证码为4位纯数字!");
            trun_red(this)
            disable_button_register();
            return;
        }
        if(check_captcha_bad_chars(captcha) == false){
            show_error(this, "验证码为4位纯数字!");
            trun_red(this)
            disable_button_register();
            return;   
        }
        trun_green(this)
        hide_tooltip(this)
        check_captcha_register(captcha)
    });


    $("#register-username").blur(function(){
        if(this.value.length == 0){
            show_error(this, "请输入用户名!");
            trun_red(this)
            disable_button_register();
            return;
        }
        var username = this.value;
        check_username_existed_register(username)
    });

    $("#register-password").blur(function(){
        if(this.value.length == 0){
            show_error(this, "请输入密码!");
            trun_red(this)
            disable_button_register();
            return;
        }
    });

    $("#register-email").blur(function(){
        if(this.value.length == 0){
            show_error(this, "请输入邮箱!");
            trun_red(this)
            disable_button_register();
            return;
        }
        var email = this.value;
        check_email_existed(email)
    });

    $("#register-college").blur(function(){
        if(this.value.length == 0){
            show_error(this, "请输入学校名称!");
            trun_red(this)
            disable_button_register();
            return;
        }
    });

    $("#register-captcha").blur(function(){
        if(this.value.length == 0){
            show_error(this, "请输入验证码!");
            trun_red(this)
            disable_button_register();
            return;
        }
    });

});


function check_length(word, min, max) {
    var length = word.length;
    return (length <= max && length >= min);
}

function check_username_length(username) {
    return check_length(username, 4, 16);
}

function check_password_length(password) {
    return check_length(password, 6, 16);
}

function check_collenge_length(college){
    return check_length(college, 3, 16);
}

function check_captcha_length(captcha) {
    return check_length(captcha, 4, 4);
}

function check_bad_chars(word, bad_chars) {
    var default_bad_chars = ""
    default_bad_chars += bad_chars
    for (var i = default_bad_chars.length - 1; i >= 0; i--) {
        for (var j = word.length - 1; j >= 0; j--) {
            if (default_bad_chars[i] == word[j]){
                return false;
            }
        }
    }
    return true;
}

function check_username_bad_chars(username) {
    return check_bad_chars(username, "~!@#$%^&*()_+`-={}|[]\\:\";',./<>?")
}

function check_password_bad_chars(password) {
    return check_bad_chars(password,"")
}

function check_captcha_bad_chars(captcha) {
    for (var i = captcha.length - 1; i >= 0; i--) {
        var ascii = captcha.charCodeAt(i);
        if (ascii > "9".charCodeAt(0) || ascii < "0".charCodeAt(0)){
            return false;
        }
    }
    return true;
}

function check_email(email){
    var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
    if (!reg.test(email)) {
        return false;
    }
    return true;
}

function check_captcha_register(captcha) {
    $.ajax({
        type: "POST",
        url: "/user/check_captcha_current",
        dataType: "json",
        data: {
            "captcha":captcha
        },
        success: function(msg) {
            if (msg.status == 1){
                trun_green($("#register-captcha"))
                release_button_register()
            }else{
                show_error($("#register-captcha"), "验证码错误!");
                trun_red($("#register-captcha"))
                disable_button_register();
            }
        }
    });
}

function check_username_existed_register(username) {
    $.ajax({
        type: "POST",
        url: "/user/check_username_existed",
        dataType: "json",
        data: {
            "username":username
        },
        success: function(msg) {
            if (msg.status == 1){
                trun_green($("#register-username"))
                release_button_register()
            }else{
                show_error($("#register-username"), msg.message);
                trun_red($("#register-username"))
                disable_button_register();
            }
        }
    });
}

function check_email_existed(email) {
    $.ajax({
        type: "POST",
        url: "/user/check_email_existed",
        dataType: "json",
        data: {
            "email":email
        },
        success: function(msg) {
            if (msg.status == 1){
                trun_green($("#register-email"))
                release_button_register()
            }else{
                show_error($("#register-email"), msg.message);
                trun_red($("#register-email"))
                disable_button_register();
            }
        }
    });
}