<link rel="stylesheet" type="text/css" href="/assets/css/optiscroll.css">

<h2 id="title"><i class="fa fa-sitemap"></i>Admin</h2>
<ul id="toggle" class="slide-bar-left">
    
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

    <li class="cd-write-up">
        <div>
            <span class="menu-icons  fa fa-briefcase"></span>
            <a href="#">write-up</a><span class="the-btn fa fa-plus"></span>
        </div>
        <ul>
            <li>
                <a href="#">即将上线 , 敬请期待</a>
            </li>
        </ul>
    </li>

    <li class="cd-tutorials">
        <div>
            <span class="menu-icons  fa fa-briefcase"></span>
            <a href="#">tutorials</a><span class="the-btn fa fa-plus"></span>
        </div>
        <ul>
            <li>
                <a href="#">即将上线 , 敬请期待</a>
            </li>
        </ul>
    </li>

    <li class="cd-logout">
        <div>
            <span class="menu-icons  fa fa-envelope"></span>
            <a href="/user/logout">退出</a>
        </div>
    </li>
</ul>

</div>
<a href="#" class="toggle-nav" id="bars"><i class="fa fa-bars"></i></a>
<div class="content-container optiscroll">
</div>


 <script type="text/javascript" src="/assets/js/jquery.optiscroll.min.js"></script>
<script type="text/javascript">
// init  optiscroll
// plain JS version
var element = document.querySelector('#scroll')
var myOptiscrollInstance = new Optiscroll(element);

// jQuery plugin
$('#scroll').optiscroll()
</script>