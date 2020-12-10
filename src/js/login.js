$( document ).ready(function() {
        $("#login_form").submit(function(e) {
            // Grab all values
            var u_name = $("#inputEmailAddress").val();
            var p_word = $("#inputPassword").val();
            var redirect_page = "index.html";
            
            //freez form
            var $inputs = $("#login_form").find("input, select, button, textarea");                                              
            $inputs.prop("disabled", true);
            
            // stop form from submitting
            e.preventDefault();
            
            $.ajax({
                type: "POST",
                url: BASE_PATH+ "/refresh_content.php",
                async:false,
                data: {option: 'login_user', u_name:u_name, p_word:p_word},
                crossDomain: true,
                beforeSend: function ( xhr ) {
                    // maybe tell the user that the request is being processed
                    //$("#status").show().html("<img src='images/preloader.gif' width='32' height='32' alt='processing...'>");
                },
                error: function( jqXHR , status, errorThrown ){
                    alert(status);

                }
                }).done(function( result ) {
                    var ret_val = JSON.parse(result);
                    
                    if(ret_val.status[0] == 1)
                    {
                        SetLoginData(ret_val.user[0]);
                        
                       // window.location.replace(redirect_page);
                    }
                    else if(ret_val.status[0] == -1)
                    {
                        $("#message").html("<p style=\"color:red\">Incorrect login details</p>");
                    }
                    $inputs.prop("disabled", false);
            });
        });
        
});


