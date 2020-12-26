<?php

$redirect_page = (isset($_GET['redirect_to']) ? $_GET['redirect_to'] : 'index.php');

?>

<!DOCTYPE html>
<html lang="en">
<?php include_once('header.php'); ?>
<style type="text/css">
.modal-header .close
{
    display: none;
}
</style>
<body>
      <div class="row" style="padding-top: 50px;">
        <div class="col-lg-4 col-sm-4 col-xs-2"></div>
        <div class="col-lg-4 col-sm-4 col-xs-8">
            <form class="form-horizontal" id="login_form">
                <!-- Modal content-->
                <div class="modal-content" style="min-width: 200px;">
                    
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">System Login</h4>
                    </div>
                    <div id="model_content" class="modal-body">
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="u_name">Username:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="u_name" id="u_name" placeholder="Enter your username" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="p_word">Password:</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" name="p_word" id="p_word" placeholder="Enter password" required>
                        </div>
                      </div> 
                    </div> 
                    <div class="modal-footer">
                    <div style="clear: both;">
                        <div id="message" style="float: left; text-align: left;"></div>
                        <div style="float: right;">
                          <button id="btn_login" type="submit" class="btn btn-primary">Login</button>
                        </div>
                     </div>
                  </div>   
                </div>
             </form>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-2"></div>
      </div>
</body>
<script>
    //service_url = "http://localhost/starr/services/index.php";
    //service_url = "http://starr.lk/services/index.php";
    
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
</script>
</html>