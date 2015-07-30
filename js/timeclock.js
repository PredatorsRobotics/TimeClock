$("#inputName").blur(function() {
    if ($("#inputName").val() != "") {
        $.post("submit.php",
        {
            "function": "getIsClockedIn",
            "username": $("#inputName").val(),
        },
        function(response){
            
            if (response == "0") {
                var html = '<input type="hidden" name="clock" value="in"><button style="display:none;" id="buttonToFade" class="btn btn-lg btn-primary btn-block" type="submit">Clock In</button>';
            } else if (response == "1") {
                html = '<input type="hidden" name="clock" value="out"><button style="display:none;" id="buttonToFade" class="btn btn-lg btn-primary btn-block" type="submit">Clock Out</button>';
            } else if (response == "-1") {
                var bootlert = '<div class="alert alert-danger" id="buttonToFade" role="alert">Sorry, but it looks like your username is incorrect. Can you try again?</div>';
            } else {
                alert("Backend error. It's not you, it's me. :'(")
            }
            $("#buttonToFade").fadeOut("slow");
            $("#clockInOut").html(html);
            $("#alert").html(bootlert);
            $("#buttonToFade").fadeIn("slow");
        });
    }
});