    
        <link rel="stylesheet"  type="text/css" href="/assets/css/style.css">
        <script type="text/javascript" src="/assets/js/smart_login.js"></script>
        <script type="text/javascript" src="/assets/js/smart_register.js"></script>
        <script type="text/javascript" src="/assets/js/show_alert_dialog.js"></script>
        <script type="text/javascript" src="/assets/js/rewrite_submit.js"></script>
        <nav class="navbar navbar-default  navbar-fixed-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="">SniperOJ</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <nav class="main_nav"> 
                        <ul  class="nav navbar-nav navbar-right "> 
                            <li><a class="cd-login" href="javascript: void(0)">登录</a></li> 
                            <li><a class="cd-register" href="javascript: void(0)">注册</a></li> 
                        </ul> 
                    </nav> 
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

        <div class="cd-user-modal">  
            <div class="cd-user-modal-container"> 
                <ul class="cd-switcher"> 
                    <li><a href="javascript: void(0)">用户登录</a></li> 
                    <li><a href="javascript: void(0)">注册新用户</a></li> 
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
