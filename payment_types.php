<!DOCTYPE html>
<html lang="en">
<?php include_once('header.php'); ?>
<body>
<?php 
    include_once('nav_bar.php');
    include_once('link_service.php');  
    include_once('access.php');
    
    $section = "payment_types";
    $data = array();
    
    $view_ok = false;
    $new_ok = false;
    $edit_ok = false;
    
    if(isset($_SESSION['access_obj']))
    {
        $section_access = getSectionAccess($section);
        if(isset($section_access->view))
            $view_ok = ($section_access->view=='Y' ? true : false);
        if(isset($section_access->new))
            $new_ok = ($section_access->new=='Y' ? true : false);
        if(isset($section_access->edit))
            $edit_ok = ($section_access->edit=='Y' ? true : false);
    }
    else
        exit(header("Location: login.php?redirect_to=payment_types.php"));
    
    if($view_ok)
        $data = callService("/get_all_pay_types");
?>
    <?php
      if($new_ok)
      {
    ?>
      <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="row">
                <div class="col-lg-2"><button id="new_payment" class="btn btn-primary btn-xs"  data-toggle="modal" data-target="#editModal">New Pay Type</button></div>
                <div class="col-lg-10"></div>
            </div>
        </div>
        <div class="col-lg-1"></div>
      </div>
      <?php
        }
      ?>
      <?php
        if($view_ok)
        {
      ?>
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-lg-1 side_border"></div>
        <div class="col-lg-10" id="container" style="padding: 25px 0px;">
            <div id="payment_type_list">
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th style="width: 20%;">Type</th>
                        <th style="width: 20%;">Description</th>
                        <th>Rate (Rs/ha)</th>
                        <th>Crop</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($data as $row) {
                    ?>
                        <tr>
                            <td style="width: 20%;"><?php echo $row->name; ?></td>
                            <td style="width: 20%;"><?php echo $row->description; ?></td>
                            <td><?php echo $row->rate_per_ha; ?></td>
                            <td><?php echo $row->crop; ?></td>
                            <td><?php if($edit_ok){ ?><button type="button" id="<?php echo "edit_" . $row->id; ?>" class="btn btn-primary btn-xs edit"  data-toggle="modal" data-target="#editModal">Edit</button><?php } ?></td>
                        </tr>
                    <?php
                        }
                    ?>
                    </tbody>
                  </table>
            </div>
        </div>
        <div class="col-lg-1 side_border"></div>
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
                      <h4 class="modal-title">Pay Type Detail</h4>
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
        $(function() {
            //service_url = "http://localhost/starr/services/index.php";
            
            $('body').on('change', '#cmb_crop', function() {
                str = $(this)[0].id; 
                //var index=str.substring(str.lastIndexOf("[")+1,str.lastIndexOf("]"));
                
                prev_pay_type = $("#cmb_prev_pay_type");
                
                var crop_id = $(this).find(":selected").val();
                
                var url = service_url + "/get_pay_types_by_crop/" + crop_id;
                //Set GNDs according to DSD selection
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {},
                    async: false,
                    dataType: "json",
                    success: function(result)
                            {
                                //data = JSON.parse(result);
                                prev_pay_type.find('option')
                                        .remove()
                                        .end();
                                $.each(result, function(index, element) {
                                    var option = new Option(element.name, element.id); 
                                    prev_pay_type.append($(option)).selectpicker('refresh');
                                });
                            },
                    failure: function () {
                        alert("Failed!");
                    }
                });
                //gnd_list.html('<option>city1</option><option>city2</option>').selectpicker('refresh');	  
            });
            
            $("#f_edit_form").submit(function(e) {
                
                // Grab all values
                var id = $("#txt_id").val();
                var name = $("#txt_name").val();
                var description = $("#txt_description").val();
                var rate_per_ha = $("#txt_rate_per_ha").val();
                var crop_id = $('#cmb_crop').val();
                var previous_payment_id = $('#cmb_prev_pay_type').val();
                
                url = "http://localhost/starr/services/index.php/save_pay_type";  
                
                //freez form
                var $inputs = $("#f_edit_form").find("input, select, button, textarea");                                              
                $inputs.prop("disabled", true);
                
                // stop form from submitting
                e.preventDefault();
                     
                // make a POST ajax call 
                $.ajax({
                    type: "POST",
                    url: url,
                    async:false,
                    data: {id:id, name:name, description:description, rate_per_ha:rate_per_ha, crop_id:crop_id, previous_payment_id:previous_payment_id},
                    beforeSend: function ( xhr ) {
                        // maybe tell the user that the request is being processed
                        //$("#status").show().html("<img src='images/preloader.gif' width='32' height='32' alt='processing...'>");
                    }
                    }).done(function( result ) {
                        if (JSON.parse(result)[0].id !== undefined)
                        {
                            $("#message").html("Data Saved");
                            $("#txt_id").val(JSON.parse(result)[0].id);
                        }
                        else
                        {
                            $("#message").html("Error saving society details");
                            //$("#message").html(JSON.parse(result)); //uncomment this and check the error message
                        }
                        $inputs.prop("disabled", false);
                        
                        RefreshPaymentTypeList();
                    });
            });
                
            $("#new_payment").on("click", function () {
                var id = this.id;
                var farmer_id = id.substring(5, id.length);
                $.ajax({
                    type: "GET",
                    url: "edit_payment_type.php",
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
            
            $('body').on('click', '.edit', function() {
                var id = this.id;
                var type_id = id.substring(5, id.length);
                $.ajax({
                    type: "GET",
                    url: "edit_payment_type.php",
                    data: {type_id: type_id },
                    async: false,
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
        });
        
        function RefreshPaymentTypeList()
        {
            $.ajax({
                type: "GET",
                url: "refresh_content.php",
                data: {option: 'list_payement_types' },
                dataType: "html",
                success: function(res)
                        {
                            $("#payment_type_list").empty();
			                $("#payment_type_list").html(res);
                            debugger;
                        },
                failure: function () {
                    alert("Failed!");
                }
            });
        }
      </script>
</body>
</html>
