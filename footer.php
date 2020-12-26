        <!-- Site footer -->
      <div class="row">
        <div class="col-lg-1 side_border"></div>
        <div class="col-lg-10">
            <div class="row">
                <div class="col-lg-3" style="text-align: right;"> <img src="images/logos/ifad_footer.jpg" width="80" height="60" > </div>
                <div class="col-lg-6" style="text-align: center;"> 
                    <p>Smallholder Tea and Rubber Revitalization (STARR) Project</p>
        		    <p>STARR Project, Battaramulla, Sri lanka. Telephone +94-11 2882244 | Fax: +94-11 2793844 |<br> Email: info@starr.lk</p>
        		</div>
                <div class="col-lg-3"> <img src="images/logos/starr1.png" width="70" height="60" /> </div>
            </div>
        </div>
        <div class="col-lg-1 side_border"></div>
      </div>
      
      <div class="modal fade" id="loginModal" role="dialog">
            <div class="modal-dialog">
                <form class="form-horizontal" id="login_form">
                    <!-- Modal content-->
                    <div class="modal-content" style="min-width: 200px;">
                        
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">System Login</h4>
                        </div>
                        <div id="model_content" class="modal-body">
                          <div class="form-group">
                            <label class="control-label col-sm-2" for="uname">Username:</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="uname" placeholder="Enter your username" required>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-2" for="pword">Password:</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control" id="pword" placeholder="Enter password" required>
                            </div>
                          </div> 
                        </div> 
                        <div class="modal-footer">
                        <div style="clear: both;">
                            <div id="message" style="float: left; text-align: left;"></div>
                            <div style="float: right;">
                              <button id="btn_login" type="submit" class="btn btn-primary">Login</button>
                              <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                            </div>
                         </div>
                      </div>   
                    </div>
                 </form>
            </div>
      </div>
      
      <script>
        service_url = "http://localhost/starr/services/index.php";
        //service_url = "http://starr.lk/mis-system/services/index.php";
        
        $("#login_form").submit(function(e) {
                // Grab all values
                var u_name = $("#uname").val();
                var p_word = $("#pword").val();
                
                url = service_url + "/sys_login";  
                
                //freez form
                var $inputs = $("#login_form").find("input, select, button, textarea");                                              
                $inputs.prop("disabled", true);
                
                // stop form from submitting
                e.preventDefault();
     
                // make a POST ajax call 
                $.ajax({
                    type: "POST",
                    url: url,
                    async:false,
                    data: {u_name:u_name, p_word:p_word},
                    beforeSend: function ( xhr ) {
                        // maybe tell the user that the request is being processed
                        //$("#status").show().html("<img src='images/preloader.gif' width='32' height='32' alt='processing...'>");
                    }
                    }).done(function( result ) {
                        var ret_val = JSON.parse(result);
                        if(ret_val.status[0] == 1)
                        {
                            $('#loginModal').modal('toggle');
                            SetLoginData(ret_val.user[0]);
                        }
                        else if(ret_val.status[0] == -1)
                        {
                            $("#message").html("<p style=\"color:red\">Incorrect login details</p>");
                        }
                        $inputs.prop("disabled", false);
                    });
        });
        
        $('body').on('click', '.logout', function() {
            $.ajax({
                type: "GET",
                url: "refresh_content.php",
                data: {option: 'logout_data'},
                dataType: "html",
                success: function(res)
                        {
                            $("#login_note").empty();
			                $("#login_note").html(res);
                            window.location.replace("index.php");
                        },
                failure: function () {
                    alert("Failed!");
                }
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
      <?php ob_end_flush(); ?>