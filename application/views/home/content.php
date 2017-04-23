<script src="//cdn.bootcss.com/minigrid/1.6.5/minigrid.min.js"></script>
<script src="//cdn.bootcss.com/dynamics.js/1.1.5/dynamics.min.js"></script>
<script type="text/javascript" src="/assets/js/sliding.js"></script>
<link href="//cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link href="//cdn.bootcss.com/minireset.css/0.0.2/minireset.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/assets/css/sliding.css">
<link rel="stylesheet" type="text/css" href="/assets/css/muti_blocks.css">

<div id="container">
    <div id="canvas">
        <div id="nav">
            <h2 id="title"><i class="fa fa-sitemap"></i>SniperOJ</h2>
            <ul id="toggle">
                <li>
                    <div class="active border">
                        <span class="menu-icons fa fa-home"></span>   <a href="#">我的主页</a>
                    </div>
                </li>
                <li>
                    <div>
                        <span class="menu-icons  fa fa-user"></span>   <a href="#">题目</a>
                        <span class="the-btn fa fa-plus"></span>
                    </div>
                    <ul>
                        <li>
                            <a href="#">所有</a>
                        </li>
                        <li>
                            <a href="#">Web</a>
                        </li>
                        <li>
                            <a href="#">Web</a>
                        </li>
                        <li>
                            <a href="#">Web</a>
                        </li>
                        <li>
                            <a href="#">Web</a>
                        </li>
                        <li>
                            <a href="#">Web</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <div>
                        <span class="menu-icons  fa fa-briefcase"></span>
                        <a href="#">WriteUp</a><span class="the-btn fa fa-plus"></span>
                    </div>
                    <ul>
                        <li>
                            <a href="#">2017-HIT-CTF</a>
                        </li>
                        <li>
                            <a href="#">2017-BCTF</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <div>
                        <span class="menu-icons  fa fa-briefcase"></span>
                        <a href="#">Wiki</a><span class="the-btn fa fa-plus"></span>
                    </div>
                    <ul>
                        <li>
                            <a href="#">Web</a>
                        </li>
                        <li>
                            <a href="#">Misc</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <div class="active border">
                        <span class="menu-icons fa fa-home"></span>   <a href="#">退出登录</a>
                    </div>
                </li>
                <li>
                    <div>
                        <span class="menu-icons  fa fa-envelope"></span>
                        <a href="#">关于我们</a>
                    </div>
                </li>
                <li class="cd-login">
                    <div>
                        <span class="menu-icons  fa fa-envelope"></span>
                        <a>登录</a>
                    </div>
                </li>
                <li class="cd-register">
                    <div>
                        <span class="menu-icons  fa fa-envelope"></span>
                        <a>注册</a>
                    </div>
                </li>
            </ul>
        </div>
        <a href="#" class="toggle-nav" id="bars"><i class="fa fa-bars"></i></a>






        <div class="challenges-container">
            <h1>All challenges</h1>
            <div class="grid">
                <div class="grid-item">
                    Black1
                </div>
                <div class="grid-item">
                    Black1
                    
                </div>
                <div class="grid-item">
                    Black1
                    
                </div>
            </div>
        </div>


    </div>
</div>


<script type="text/javascript" src="/assets/js/blocks.js"></script>


<script type="text/javascript">
    /* 动态加载所有题目 */
</script>

<script type="text/javascript">
    /* 动态加载个人信息 */
</script>

<script type="text/javascript">
    /* 动态加载排行榜 */
</script>

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
