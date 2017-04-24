$(document).ready(function(){
  $("form").submit(function(e){
    e.preventDefault();
    var length = e.target.children.length
    var type = e.target.children[length - 1].children[0].id
    if (startswith(type, "login")){
		var username = e.target.children[0].children[0].value
		var password = e.target.children[1].children[0].value
		var captcha = e.target.children[2].children[0].value
		login(username, password, captcha)
		return;
    }

    if (startswith(type, "register")){
		var username = e.target.children[0].children[0].value
		var password = e.target.children[1].children[0].value
		var email = e.target.children[2].children[0].value
		var college = e.target.children[3].children[0].value
		var captcha = e.target.children[4].children[0].value
		register(username, password, email, college, captcha)
		return;
    }
  });
});


function startswith(father, son){
	return (father.indexOf(son) == 0)
}


function login(username, password, captcha){
	$.ajax({
	    type: "POST",
	    url: "/user/login",
	    dataType: "json",
	    data: {
	        "username":username,
	        "password":password,
	        "captcha":captcha,
	    },
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
	    	if (msg.status == 1){
	    		location.reload()
	    		// show_pnotify("Success!", msg.message, "info")
	    	}else{
	    		show_pnotify("Failed!", msg.message, "error")
	    		// play the sound
	    		$("#error_sound")[0].play()
	    	}
	    }
	});
}

function register(username, password, email, college, captcha){
	$.ajax({
	    type: "POST",
	    url: "/user/register",
	    dataType: "json",
	    data: {
	        "username":username,
	        "password":password,
	        "email":email,
	        "college":college,
	        "captcha":captcha,
	    },
	    beforeSend:function(){
	    	// disable button
	    	disable_button_register()
	    	// display = none
	    	$('.cd-user-modal').removeClass('is-visible');
	    	NProgress.start();
	    },
	    complete:function(){
	    	NProgress.done();
	    },
	    success: function(msg) {
	        if (msg.status == 1){
	        	show_pnotify("Success!", msg.message, "info")
	        }else{
	        	show_pnotify("Failed!", msg.message, "error")
	        	// play the sound
	        	$("#error_sound").play()
	        }
	    }
	});
}

function show_pnotify(title, text, type) {
    new PNotify({
        title: title,
        text: text,
        type: type,
        delay: 1000,
        addclass: "stack-topleft",
    });
}
