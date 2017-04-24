
        <div class="content-container">
        </div>


    </div>
</div>

<script type="text/javascript" src="/assets/js/sliding.js"></script>

<link rel="stylesheet"  type="text/css" href="/assets/css/style.css">
<script type="text/javascript" src="/assets/js/smart_login.js"></script>
<script type="text/javascript" src="/assets/js/smart_register.js"></script>
<script type="text/javascript" src="/assets/js/rewrite_submit.js"></script>

<div class="cd-user-modal">  
    <div class="cd-user-modal-container"> 
        <ul class="cd-switcher"> 
            <li><a>登录</a></li> 
            <li><a>注册</a></li> 
        </ul> 
        <div id="cd-login">  
            <form class="cd-form" action="/user/login" method="POST"> 
                <p class="fieldset">
                    <input  name="username" class="full-width has-padding has-border" id="login-username" type="text" placeholder="输入用户名">
                </p>
                <p class="fieldset">
                    <input name="password" class="full-width has-padding has-border" id="login-password" type="password"  placeholder="输入密码">
                </p>
                <p  style="width: 50%;float:left;">
                    <input name=captcha class="full-width has-padding has-border" id="login-captcha" type="text" placeholder="请输入验证码">
                </p>
                <p class="captcha" onclick="javascript:get_captcha()">
                </p><br>
                <p class="fieldset">
                    <input class="full-width2" id="login-input-button" type="submit" value="登 录">
                </p>
            </form> 
        </div> 
 
        <div id="cd-register">  
            <form class="cd-form" action="/user/register" method="POST"> 
                <p class="fieldset">
                    <input name="username" class="full-width has-padding has-border" id="register-username" type="text" placeholder="输入用户名">
                </p>
                <p class="fieldset">
                    <input name="password" class="full-width has-padding has-border" id="register-password" type="password"  placeholder="输入密码">
                </p>
                <p class="fieldset">
                    <input name="email" class="full-width has-padding has-border" id="register-email" type="email" placeholder="请输入邮箱">
                </p>
                <p class="fieldset">
                    <input name="college" class="full-width has-padding has-border" id="register-college" type="text" placeholder="请输入学校名称">
                </p>
                <p  style="width: 50%;float:left;">
                    <input name="captcha" class="full-width has-padding has-border" id="register-captcha" type="text" placeholder="请输入验证码">
                </p>
                <p class="captcha" onclick="javascript:get_captcha()">
                </p><br>
                <p class="fieldset">
                    <input class="full-width2" id="register-input-button"  type="submit" value="注册新用户">
                </p>
            </form> 
        </div>         
    </div> 
</div>  

<script type="text/javascript" src="/assets/js/show_alert_dialog.js"></script>



