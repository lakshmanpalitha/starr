<!DOCTYPE html>
<html lang="en">
<?php include_once('header.php'); ?>
<body>
<?php 
    include_once('nav_bar.php'); 
    include_once('link_service.php'); 
    include_once('access.php');
?>	

<?php 
    $section = "system";
    $data = array();
    
    $tshda_update_ok = false;
    
    if(isset($_SESSION['access_obj']))
    {
        $section_access = getSectionAccess($section);
        if(isset($section_access->tshda_update))
            $tshda_update_ok = ($section_access->tshda_update=='Y' ? true : false);
    }
    else
        exit(header("Location: login.php?redirect_to=tshda_updates.php"));
?>
    <?php
      if($tshda_update_ok)
      {
    ?>
      <div class="row main_tbl_container">
        <div class="col-lg-1"></div>
        <div class="col-lg-10 fieldset_container">
            <div class="row">
                <span><h4>Synchronise with TSHDA Data</h4></span>
            </div>
            <div class="row">
                <label class="control-label col-sm-2" for="dtp_start_date">Start Date:</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control short" id="dtp_start_date">
                </div>
            </div>
            <div class="row">
                <label class="control-label col-sm-2" for="dtp_end_date">End Date:</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control short" id="dtp_end_date">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-10 right"><button id="btn_update_tshda" class="btn btn-primary btn-xs"  data-toggle="modal" data-target="#editModal">Update System</button></div>
            </div>
        </div>
        <div class="col-lg-1"></div>
      </div>
    <?php
      }
    ?>
    <div class="modal fade" id="editModal" role="dialog">
            <div class="modal-dialog">
                <form class="form-horizontal" id="f_edit_form">
                <!-- Modal content-->
                <div class="modal-content" style="min-width: 900px;">
                    
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Factory Detail</h4>
                    </div>
                    <div id="model_content" class="modal-body">
                      <p>Some text in the modal.</p>
                    </div>    
                </div>
                
                </form>
            </div>
        </div>
      <?php include('footer.php'); ?>
      <script>
         $("#new_factory").on("click", function () {
                var id = this.id;
                var farmer_id = id.substring(5, id.length);
                $.ajax({
                    type: "GET",
                    url: "edit_factory.php",
                    data: {farmer_id: farmer_id },
                    //contentType: "application/json; charset=utf-8",
                    dataType: "html",
                    success: function(result)
                            {
                                $("#model_content").empty();
    			                $("#model_content").html(result);
                                
                                $('.selectpicker').selectpicker({
                                    size: 4
                                });
                            },
                    failure: function () {
                        alert("Failed!");
                    }
                });
                
            });
      </script>
</body>
</html>
