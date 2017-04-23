$(document).ready(function(){
  $("form").submit(function(e){
    e.preventDefault();
    var length = e.target.children.length
    var type = e.target.children[length - 1].children[0].id
    console.log("type : "+type)
    if (startswith(type, "login")){
		var username = e.target.children[0].children[0].value
		var password = e.target.children[1].children[0].value
		var captcha = e.target.children[2].children[0].value
		console.log("username : "+username)
		console.log("password : "+password)
		console.log("captcha : "+captcha)
		return;
    }

    if (startswith(type, "register")){

		var username = e.target.children[0].children[0].value
		var password = e.target.children[1].children[0].value
		var email = e.target.children[2].children[0].value
		var college = e.target.children[3].children[0].value
		var captcha = e.target.children[4].children[0].value
		console.log("username : "+username)
		console.log("password : "+password)
		console.log("email : "+email)
		console.log("college : "+college)
		console.log("captcha : "+captcha)
		return;
    }
  });
});


function startswith(father, son){
	return (father.indexOf(son) == 0)
}


// function login(username, password, captcha){
// 	$.ajax({
// 	    type: "POST",
// 	    url: "/user/login",
// 	    dataType: "json",
// 	    data: {
// 	        "username":username,
// 	        "password":password,
// 	        "captcha":captcha,
// 	    },
// 	    success: function(msg) {
// 	        console.log(msg)
// 	    }
// 	});
// }