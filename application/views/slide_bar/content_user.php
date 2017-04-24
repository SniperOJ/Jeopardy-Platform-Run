
<style type=text/css>
.challenge-item{
  margin:10px;
  padding: 5px;
  background-color: #00006600;
  position: relative;
  width: 256px;
  height: 140px;
  font-size: 24px;
  color: #000;
  text-align: center;
  box-shadow: 0px 0px 2px rgba(0,0,0,0.5),0px -5px 20px rgba(0,0,0,0.1) inset;
}
.challenge-item-web{
  padding: 10px;
  border-radius: 20px;
  font-size: 20px;
  background-color: #0080FF;
  opacity:0.65;
} 
.challenge-item-pwn{
  padding: 10px;
  border-radius: 20px;
  font-size: 20px;
  background-color: #FF2D2D;
  opacity:0.65;
}
.challenge-item-misc{
  padding: 10px;
  border-radius: 20px;
  font-size: 20px;
  background-color: #FFD306;
  opacity:0.65;
}
.challenge-item-crypto{
  padding: 10px;
  border-radius: 20px;
  font-size: 20px;
  background-color: #C07AB8;
  opacity:0.65;
}
.challenge-item-stego{
  padding: 10px;
  border-radius: 20px;
  font-size: 20px;
  background-color: #79FF79;
  opacity:0.65;
}
.challenge-item-forensics{
  padding: 10px;
  border-radius: 20px;
  font-size: 20px;
  background-color: #B15BFF;
  opacity:0.65;
}
.challenge-item-other{
  padding: 10px;
  border-radius: 20px;
  font-size: 20px;
  background-color: #F75000;
  opacity:0.65;
}
.challenge-item-solved{
  padding: 10px;
  border-radius: 20px;
  font-size: 20px;
  background-color: #EEEEEE;
  opacity:0.1;
  color: grey;
}
.challenge:hover{
  transition: all 0.5s ease;
  opacity:1;
}
</style>  


<script type="text/javascript" src="/assets/js/polling.js"></script>

<script type="text/javascript">
  show_process();
</script>

<h2 id="title"><i class="fa fa-sitemap"></i>SniperOJ</h2>
<ul id="toggle" class="slide-bar-left">

    <li class="cd-mine">
        <div class="active border">
            <span class="menu-icons fa fa-home"></span>   <a href="#">我的主页</a>
        </div>
    </li>

    <li class="cd-challenges">
        <div>
            <span class="menu-icons  fa fa-user"></span>   <a href="#">题目</a>
            <span class="the-btn fa fa-plus"></span>
        </div>
        <ul>
            <li>
                <a href="javascript:get_all_challenges();">all</a>
            </li>
            <li>
                <a href="javascript:get_challenges_simple('web');">web</a>
            </li>
            <li>
                <a href="javascript:get_challenges_simple('misc');">misc</a>
            </li>
            <li>
                <a href="javascript:get_challenges_simple('pwn');">pwn</a>
            </li>
            <li>
                <a href="javascript:get_challenges_simple('stego');">stego</a>
            </li>
            <li>
                <a href="javascript:get_challenges_simple('crypto');">crypto</a>
            </li>
            <li>
                <a href="javascript:get_challenges_simple('forensics');">forensics</a>
            </li>
            <li>
                <a href="javascript:get_challenges_simple('other');">other</a>
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



<script type="text/javascript">

// open challenges default
 $(document).ready(function(){
  $(".cd-challenges").children()[0].click();
  var a = $(".cd-challenges").children()[1];
  $($(a).find('li')[0]).children()[0].click()
 });


    function get_challenges_simple(type) {
        //clear data
        var chellenge_container = $(".content-container");
        chellenge_container.html('');

        var url = "challenge/get_type_challenges/" + type;
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            beforeSend:function(){
                // disable button
                disable_button_login()
                // display = none , alert dialog
                $('.cd-user-modal').removeClass('is-visible');
                NProgress.start();
            },
            complete:function(){
                NProgress.done();
            },
            success: function(msg) {
                if(msg.status == 1){
                  console.log(msg);

                    // load to view
                    var html = '';
                    html += '<h1>'+type+'</h1>';
                    html += '<div class="grid">';
                    var challenges = msg.message;
                    for (var i = challenges.length - 1; i >= 0; i--) {
                      var color_class = get_challenge_item_class(challenges[i].type);
                      if(challenges[i].is_solved == false){

                        html += '<div class="challenge-item grid-item '+color_class+'" onclick="javascript:show_challenge('+challenges[i].challenge_id+')">';
                      }else{
                        html += '<div class="challenge-item grid-item challenge-item-solved '+color_class+'" onclick="javascript:show_challenge('+challenges[i].challenge_id+')">';
                        
                      }
                      html += '<p style="text-align:center;">'
                      html += challenges[i].name + '<br>';
                      html += '分数 : ' + challenges[i].score + '<br>';
                      html += '点击量 : ' + challenges[i].visit_times + '<br>';
                      html += '战况 : ' + challenges[i].solved_times + '/' + challenges[i].submit_times;
                      html += '</p>'
                      html += '</div>';
                    }
                    html += '</div>';
                    chellenge_container.html(html);
                    flush_data()
                }
            }
        });
    }

    function get_all_challenges() {
        var chellenge_container = $(".content-container");
        // clear data
        chellenge_container.html('');

        var url = "challenge/get_all_challenges";
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            beforeSend:function(){
                // disable button
                disable_button_login()
                // display = none , alert dialog
                $('.cd-user-modal').removeClass('is-visible');
                NProgress.start();
            },
            complete:function(){
                NProgress.done();
            },
            success: function(msg) {
                if(msg.status == 1){
                    var html = '';
                    html += '<h1>All</h1>';
                    html += '<div class="grid">';
                    var challenges = msg.message;
                    for (var i = challenges.length - 1; i >= 0; i--) {
                        var color_class = get_challenge_item_class(challenges[i].type);
                        if(challenges[i].is_solved == false){

                          html += '<div class="challenge-item grid-item '+color_class+'" onclick="javascript:show_challenge('+challenges[i].challenge_id+')">';
                        }else{
                          html += '<div class="challenge-item grid-item challenge-item-solved '+color_class+'" onclick="javascript:show_challenge('+challenges[i].challenge_id+')">';
                          
                        }
                        html += '<p style="text-align:center;">'
                        html += challenges[i].name + '<br>';
                        html += '分数 : ' + challenges[i].score + '<br>';
                        html += '点击量 : ' + challenges[i].visit_times + '<br>';
                        html += '战况 : ' + challenges[i].solved_times + '/' + challenges[i].submit_times;
                        html += '</p>'
                        html += '</div>';
                    }
                    html += '</div>';
                    chellenge_container.html(html);
                    flush_data()
                }
            }
        });
    }

    function get_challenge_item_class(type) {
      return 'challenge-item-' + type;
    }

    function flush_data() {
            function animate(item, x, y, index) {
            dynamics.animate(item, {
            translateX: x,
            translateY: y,
            opacity: 1
            }, {
            type: dynamics.spring,
            duration: 800,
            frequency: 120,
            delay: 100 + index * 30
            });
            }
            minigrid('.grid', '.grid-item', 6, animate);
            window.addEventListener('resize', function(){
            minigrid('.grid', '.grid-item', 6, animate);
            });
    }




</script>


<style type="text/css">
    .cd-submit-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(52, 54, 66, 0.9);
    z-index: 3;
    overflow-y: auto;
    cursor: pointer;
    visibility: hidden;
    opacity: 0;
    -webkit-transition: opacity 0.3s 0, visibility 0 0.3s;
    -moz-transition: opacity 0.3s 0, visibility 0 0.3s;
    transition: opacity 0.3s 0, visibility 0 0.3s;
    }
    .cd-submit-modal.is-visible {
    visibility: visible;
    opacity: 1;
    -webkit-transition: opacity 0.3s 0, visibility 0 0;
    -moz-transition: opacity 0.3s 0, visibility 0 0;
    transition: opacity 0.3s 0, visibility 0 0;
    }
    .cd-submit-modal.is-visible .cd-submit-modal-container {
    -webkit-transform: translateY(0);
    -moz-transform: translateY(0);
    -ms-transform: translateY(0);
    -o-transform: translateY(0);
    transform: translateY(0);
    }

    .cd-submit-modal-container {
    position: relative;
    width: 90%;
    max-width: 600px;
    background: #FFF;
    margin: 3em auto 4em;
    cursor: auto;
    border-radius: 0.25em;
    -webkit-transform: translateY(-30px);
    -moz-transform: translateY(-30px);
    -ms-transform: translateY(-30px);
    -o-transform: translateY(-30px);
    transform: translateY(-30px);
    -webkit-transition-property: -webkit-transform;
    -moz-transition-property: -moz-transform;
    transition-property: transform;
    -webkit-transition-duration: 0.3s;
    -moz-transition-duration: 0.3s;
    transition-duration: 0.3s;
    }
    .cd-submit-modal-container .cd-switcher{
    list-style-type: none;
    }
    .cd-submit-modal-container .cd-switcher:after {
    content: "";
    display: table;
    clear: both;
    }
    .cd-submit-modal-container .cd-switcher li {
    width: 50%;
    float: left;
    text-align: center;
    }
    .cd-submit-modal-container .cd-switcher li:first-child a {
    border-radius: .25em 0 0 0;
    }
    .cd-submit-modal-container .cd-switcher li:last-child a {
    border-radius: 0 .25em 0 0;
    }
    .cd-submit-modal-container .cd-switcher a {
    display: block;
    width: 100%;
    height: 50px;
    line-height: 50px;
    background: #d2d8d8;
    color: #809191;
    }
    .cd-submit-modal-container .cd-switcher a.selected {
    background: #FFF;
    color: #505260;
    }

    #cd-submit,  {
    display: none;
    }

    #cd-submit.is-selected, .is-selected{
    display: block;
    }

    .cd-submit-modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(52, 54, 66, 0.9);
      z-index: 3;
      overflow-y: auto;
      cursor: pointer;
      visibility: hidden;
      opacity: 0; 
      -webkit-transition: opacity 0.3s 0, visibility 0 0.3s;
      -moz-transition: opacity 0.3s 0, visibility 0 0.3s;
      transition: opacity 0.3s 0, visibility 0 0.3s;
    }
    .cd-submit-modal.is-visible {
      visibility: visible;
      opacity: 1;
      -webkit-transition: opacity 0.3s 0, visibility 0 0;
      -moz-transition: opacity 0.3s 0, visibility 0 0;
      transition: opacity 0.3s 0, visibility 0 0;
    }
    .cd-submit-modal.is-visible .cd-submit-modal-container {
      -webkit-transform: translateY(0);
      -moz-transform: translateY(0);
      -ms-transform: translateY(0);
      -o-transform: translateY(0);
      transform: translateY(0);
    }

    .cd-submit-modal-container {
      position: relative;
      width: 90%;
      max-width: 600px;
      background: #FFF;
      margin: 3em auto 4em;
      cursor: auto;
      border-radius: 0.25em;
      -webkit-transform: translateY(-30px);
      -moz-transform: translateY(-30px);
      -ms-transform: translateY(-30px);
      -o-transform: translateY(-30px);
      transform: translateY(-30px);
      -webkit-transition-property: -webkit-transform;
      -moz-transition-property: -moz-transform;
      transition-property: transform;
      -webkit-transition-duration: 0.3s;
      -moz-transition-duration: 0.3s;
      transition-duration: 0.3s;
    }

    .cd-form {
      padding: 1.4em;
    }
    .cd-form .fieldset {
      position: relative;
      margin: 1.4em 0;
    }
    .cd-form .fieldset:first-child {
      margin-top: 0;
    }
    .cd-form .fieldset:last-child {
      margin-bottom: 0;
    }
    .cd-form label {
      font-size: 16px;
      font-size: 0.875rem;
    }
    .cd-form label.image-replace {
      /* replace text with an icon */
      display: inline-block;
      position: absolute;
      left: 15px;
      top: 50%;
      bottom: auto;
      -webkit-transform: translateY(-50%);
      -moz-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
      -o-transform: translateY(-50%);
      transform: translateY(-50%);
      height: 20px;
      width: 20px;
      overflow: hidden;
      text-indent: 100%;
      white-space: nowrap;
      color: transparent;
      text-shadow: none;
      background-repeat: no-repeat;
      background-position: 50% 0;
    }
    .cd-form label.cd-username {
      background-image: url("../img/cd-icon-username.svg");
    }
    .cd-form label.cd-email {
      background-image: url("../img/cd-icon-email.svg");
    }
    .cd-form label.cd-password {
      background-image: url("../img/cd-icon-password.svg");
    }
    .cd-form input {
      margin: 0;
      padding: 0;
      border-radius: 0.25em;
    }
    .cd-form input.full-width {
      width: 85%;
    }
    .cd-form input.full-width2 {
      width: 94%;
    }
    .cd-form input.has-padding {
      padding: 12px 20px 12px 50px;
    }
    .cd-form input.has-border {
      border: 1px solid #d2d8d8;
      -webkit-appearance: none;
      -moz-appearance: none;
      -ms-appearance: none;
      -o-appearance: none;
      appearance: none;
    }
    .cd-form input.has-border:focus {
      border-color: #343642;
      box-shadow: 0 0 5px rgba(52, 54, 66, 0.1);
      outline: none;
    }
    .cd-form input.has-error {
      border: 1px solid #d76666;
    }
    .cd-form input[type=password] {
      /* space left for the HIDE button */
      padding-right: 65px;
    }
    .cd-form input[type=submit] {
      padding: 16px 0;
      cursor: pointer;
      background: #2f889a;
      color: #FFF;
      font-weight: bold;
      border: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      -ms-appearance: none;
      -o-appearance: none;
      appearance: none;
    }
    .no-touch .cd-form input[type=submit]:hover, .no-touch .cd-form input[type=submit]:focus {
      background: #3599ae;
      outline: none;
    }


    @media only screen and (min-width: 600px) {
      .cd-form {
        padding: 2em;
      }
      .cd-form .fieldset {
        margin: 2em 0;
      }
      .cd-form .fieldset:first-child {
        margin-top: 0;
      }
      .cd-form .fieldset:last-child {
        margin-bottom: 0;
      }
      .cd-form input.has-padding {
        padding: 16px 20px 16px 50px;
      }
      .cd-form input[type=submit] {
        padding: 16px 0;
      }
    }

    .cd-close-form {
      /* form X button on top right */
      display: block;
      position: absolute;
      width: 40px;
      height: 40px;
      right: 0;
      top: -40px;
      background: url("../img/cd-icon-close.svg") no-repeat center center;
      text-indent: 100%;
      white-space: nowrap;
      overflow: hidden;
    }
    @media only screen and (min-width: 1170px) {
      .cd-close-form {
        display: none;
      }
    }

    #cd-submit{
      display: none;
    }

    #cd-submit.is-selected{
      display: block;
    }
</style>


<script type="text/javascript">
    $(".challenge-item").on('click', function() {
        console.log("正在绑定...")
        // 获取该题目的数据
        var challenge_id = $(this).id;
        console.log(challenge_id);
        
    });


    function show_challenge(challenge_id) {
        var url = "challenge/get_challenge_info/" + challenge_id;
        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            beforeSend:function(){
                disable_button_login()
                $('.cd-user-modal').removeClass('is-visible');
                NProgress.start();
            },
            complete:function(){
                NProgress.done();
            },
            success: function(msg) {
                // 删除之前的模态框
                $('.cd-submit-modal').remove();
                if(msg.status == 1){
                    var html = create_submit_form(
                        msg.message.challenge_id,
                        msg.message.name,
                        msg.message.description,
                        msg.message.score,
                        msg.message.online_time,
                        msg.message.visit_times,
                        msg.message.resource,
                        msg.message.challenge_document,
                        msg.message.author_name
                    );
                    console.log(html);
                    $('#container').append(html);
                    var form_modal = $('.cd-submit-modal');
                    form_modal.addClass('is-visible');
                    $(".cd-form").addClass('is-selected');

                    //关闭弹出窗口
                    $('.cd-submit-modal').on('click', function(event){
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

                    $(document).ready(function(){
                      $(".submit-form").submit(function(e){
                        e.preventDefault();
                        var length = e.target.children.length
                        var type = e.target.children[length - 1].children[0].id
                        if (startswith(type, "submit")){
                            var challenge_id = e.target.children[0].children[0].value
                            var flag = e.target.children[1].children[0].value
                            if(flag.length > 0){
                              submit_flag(challenge_id, flag)
                            }else{
                              show_pnotify("Failed!", '请输入flag!', "error")
                            }
                        }
                      });
                    });
                }
            }
        });
    }


    function submit_flag(challenge_id, flag) {
        var url = '/challenge/submit';
        $.ajax({
            type: "POST",
            url: url,
            data: {
                'flag':flag,
                'challenge_id':challenge_id,
            },
            dataType: "json",
            beforeSend:function(){
                NProgress.start();
            },
            complete:function(){
                NProgress.done();
            },
            success: function(msg) {
                if(msg.status == 1){
                    show_pnotify("Success!", msg.message, "success")
                    // hide modal
                    $('.cd-submit-modal').removeClass('is-visible');
                    // add submit time
                    // add solved time
                }else{
                    show_pnotify("Failed!", msg.message, "error")

                    // add submit time
                }
            }
        });
    }

    function create_submit_form(challenge_id, name, description, score, online_time, visit_times, resource, challenge_document, author_name) {
        var html = '';
        html += '<div class="cd-submit-modal">';
        html += '<div class="cd-submit-modal-container">';
        html += '<div class="cd-submit">';
        html += '<h3>' + '名称 : ' + name + '</h3>';
        html += '<h3>' + '描述 : ' + description + '</h3>';
        html += '<h3>' + '分数 : ' + score + '</h3>';
        html += '<h3>' + '上线时间 : ' + online_time + '</h3>';
        html += '<h3>' + '点击量 : ' + visit_times + '</h3>';
        html += '<h3>' + '资源 : ' + resource + '</h3>';
        html += '<h3>' + '参考资料 : ' + challenge_document + '</h3>';
        html += '<h3>' + '作者 : ' + author_name + '</h3>';
        html += '<form class="cd-form submit-form" action="/challenge/submit" method="POST">';
        html += '<p class="fieldset">';
        html += '<input  name="challenge_id" value="'+challenge_id+'" type="hidden">';
        html += '</p>';
        html += '<p class="fieldset">';
        html += '<input  name="flag" class="full-width has-padding has-border" id="submit-flag" type="text" placeholder="请输入 flag">';
        html += '</p>';
        html += '<p class="fieldset">';
        html += '<input class="full-width2" id="submit-input-button" type="submit">';
        html += '</p>';
        html += '</form>';
        html += '</div>';
        html += '</div>';
        html += '</div>';
        return html;
    }
</script>

</div>
<a href="#" class="toggle-nav" id="bars"><i class="fa fa-bars"></i></a>



<div class="content-container">
</div>


<link href="//cdn.bootcss.com/hint.css/2.5.0/hint.min.css" rel="stylesheet">
<style type="text/css">
  .rank-container{
    background-color: #FEDCBA;
    bottom: 0px;
    right: 0px;             /*举例右边3像素*/
    position:absolute;
    padding-bottom: 3px;
    width: 360px;
    padding-left: 16px;
    height: 100%;
  }

  .rank-container:hover{
  width: 360px;
  }
</style>

<div class="rank-container">
<h1>排行榜</h1>
<table class="table table-hover">
  <thead>
    <tr>
      <th>排名</th>
      <th>用户名</th>
      <th>分数</th>
    </tr>
  </thead>
  <tbody class="rank-tbody">

  </tbody>
</table>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    load_score();
  });
  function load_score() {
    var rank_tbody = $(".rank-tbody");
    // clear
    rank_tbody.html('')
    var url = "/user/score"
    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",
        success: function(msg) {
            if(msg.status == 1){
              var rank_data = msg.message;
              for (var i = 0; i < rank_data.length - 1; i++) {
                var user_data = rank_data[i]
                var html = ''
                html +=  '<tr>';
                html += '<td>' + (i + 1) + '</td>';
                html += '<td>'
                html += '<div class="hint--bottom" aria-label="' + '学校 : ' + user_data.college + '">' + user_data.username + '</div>';
                html += '</td>'
                html += '<td>'
                html += '<div class="hint--bottom" aria-label="' + '提交数量 : ' + ' (' + user_data.accept_times + ' / ' + user_data.submit_times + ')' + '">' + user_data.score + '  ' + '(' + user_data.pass_rate + '%)' + '</div>';
                html += '</td>'
                html += '</tr>' 
                console.lo
                rank_tbody.append(html);
              }
            }
        }
    });
  }
</script>