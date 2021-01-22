$("#login_form").submit(function(e) {
    var redirect_page = "<?php echo $redirect_page; ?>"; 
    // stop form from submitting
    e.preventDefault();
    
    var $form = $(this);

    var data = $form.serializeArray();
    var u_name = $("#u_name").val();
    var p_word = $("#p_word").val(); 
    
    //freez form
    //var $inputs = $("#login_form").find("input, select, button, textarea");                                              
    //$inputs.prop("disabled", true);
    
    // make a POST ajax call 
    $.ajax({
        type: "POST",
        url: 'refresh_content.php',
        //async:false,
        data: {option:'login_user', u_name: u_name, p_word: p_word},
        beforeSend: function ( xhr ) {
            // maybe tell the user that the request is being processed
            //$("#status").show().html("<img src='images/preloader.gif' width='32' height='32' alt='processing...'>");
        }
        }).done(function( result ) {
          debugger;
            var ret_val = JSON.parse(result);
            //if(ret_val.u_name !== 'undefined')
                //window.location.replace(redirect_page);
            if(ret_val.status[0] == 1)
            {
              SetLoginData(ret_val.user[0]);
                
              window.location.replace(redirect_page);
            }
            else if(ret_val.status[0] == -1)
            {
                $("#message").html("<p style=\"color:red\">Incorrect login details</p>");
            }
            $inputs.prop("disabled", false);
        });
});

function SetLoginData(user)
{
$.ajax({
    type: "GET",
    url: "refresh_content.php",
    data: {option: 'login_data', user:user },
    dataType: "html",
    success: function(res)
            {
                $("#login_note").empty();
                $("#login_note").html(res);
            },
    failure: function () {
        alert("Failed!");
    }
});
}