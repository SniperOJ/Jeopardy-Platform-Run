data_shown = []

function get_index(new_child, father){
    var index = -1;
    for(var child in father){
        index += 1;
        if(child == new_child){
            return index;
        }
    }
    return -1;
}


function show_stack_topleft(type, title, text) {
    var opts = {
        title: "Over Here",
        text: "Check me out. I'm in a different stack.",
        // addclass: "stack-topleft",
        // stack: stack_topleft
    };

    switch (type) {
    case 'error':
        opts.title = title;
        opts.text = text;
        opts.type = "error";
        break;
    case 'info':
        opts.title = title;
        opts.text = text;
        opts.type = "info";
        break;
    case 'success':
        opts.title = title;
        opts.text = text;
        opts.type = "success";
        break;
    }
    new PNotify(opts);
}

function show_process()
{
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "/challenge/progress",
            dataType: "json",
            success: function(msg) {
                var size = msg.length
                var sound_flag = false;
                for(var i in msg){
                    str_data = JSON.stringify(i);
                    var index = get_index(str_data, data_shown);
                    if (index == -1){
                        sound_flag = true;
                        // show
                        var username = msg[i]['username'];
                        var challenge_name = msg[i]['challenge_name'];
                        var submit_time = msg[i]['submit_time'];
                        var content = 'Solved by ' + username + '<br>' + submit_time;
                        // show the alert dialog

                        show_stack_topleft('info', challenge_name, content);

                        // add to shown
                        data_shown += str_data;
                    }
                }
                // play sound only once
                if (sound_flag){
                    // $('#message_sound')[0].play()
                }
            }
        });
    });
}
setInterval('show_process()', 60 * 1000);
show_process()