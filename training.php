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
    $section = "training";
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
        exit(header("Location: login.php?redirect_to=training.php"));
    
    if($view_ok)
        $data = callService("/get_all_training");
?>
    <?php
      if($new_ok)
      {
    ?>
      <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="row">
                <div class="col-lg-2"><button id="new_training" class="btn btn-primary btn-xs"  data-toggle="modal" data-target="#editModal">New Training</button></div>
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
            <div id="training_list">
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Type</th>
                        <th>DPMU</th>
                        <th>Budget Line</th>
                        <th>Resource</th>
                        <th>Organization</th>
                        <th>Date</th>
                        <th>Venue</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($data as $row) {
                    ?>
                        <tr>
                            <td><?php echo $row->training_type; ?></td>
                            <td><?php echo $row->dpmu; ?></td>
                            <td><?php echo $row->budget_line; ?></td>
                            <td><?php echo $row->resource_person; ?></td>
                            <td><?php echo $row->organization; ?></td>
                            <td><?php echo $row->start_date; ?></td>
                            <td><?php echo $row->venue; ?></td>
                            <td><button type="button" id="<?php echo "edit_" . $row->id; ?>" class="btn btn-primary btn-xs edit"  data-toggle="modal" data-target="#editModal">Edit</button></td>
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
                      <h4 class="modal-title">Training Detail</h4>
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
        //service_url = "http://localhost/starr/services/index.php";
        //service_url = "http://starr.lk/services/index.php";
        
        $(function() {
            $('body').on('change', '#cmb_district', function() {
                var district_id = $(this).val();
                dsd_list = $("#cmb_dsd");
                
                //var url = service_url + "/get_dsd_by_district/" + district_id;
                
                //Set DSDs according to district selection
                $.ajax({
                    type: "GET",
                    url: 'refresh_content.php',
                    data: {option: 'get_dsd_by_district', district_id: district_id},
                    async: false,
                    dataType: "json",
                    success: function(result)
                            {
                                //data = JSON.parse(result);
                                dsd_list.find('option')
                                        .remove()
                                        .end();
                                $.each(result, function(index, element) {
                                    var option = new Option(element.name, element.id); 
                                    dsd_list.append($(option)).selectpicker('refresh');
                                });
                            },
                    failure: function () {
                        alert("Failed!");
                    }
                });
                
                ti_list = $("#cmb_ti");
                
                //ti = ti_list[index];//this is not used but this is how to get relavent ti combo from array
                //url = service_url + "/get_ti_by_district/" + district_id;
                
                //Set TI range according to district selection
                $.ajax({
                    type: "GET",
                    url: 'refresh_content.php',
                    data: {option: 'get_ti_by_district', district_id: district_id},
                    async: false,
                    dataType: "json",
                    success: function(result)
                            {
                                //data = JSON.parse(result);
                                ti_list.find('option')
                                        .remove()
                                        .end();
                                $.each(result, function(index, element) {
                                    var option = new Option(element.name, element.id); 
                                    ti_list.append($(option)).selectpicker('refresh');
                                });
                            },
                    failure: function () {
                        alert("Failed!");
                    }
                });  
            });
            
            $('body').on('change', '[id^=cmb_dsd]', function() {
                str = $(this)[0].id; 
                //var index=str.substring(str.lastIndexOf("[")+1,str.lastIndexOf("]"));
                
                gnd_list = $("[id^=cmb_gnd]");
                
                //gnd = gnd_list[index];//this is not used but this is how to get relavent gnd combo from array
                
                var dsd_id = $(this).find(":selected").val();
                
                //var url = service_url + "/get_gnd_by_dsd/" + dsd_id;
                //Set GNDs according to DSD selection
                $.ajax({
                    type: "GET",
                    url: 'refresh_content.php',
                    data: {option: 'get_gnd_by_dsd', dsd_id: dsd_id},
                    async: false,
                    dataType: "json",
                    success: function(result)
                            {
                                //data = JSON.parse(result);
                                gnd_list.find('option')
                                        .remove()
                                        .end();
                                $.each(result, function(index, element) {
                                    var option = new Option(element.name, element.id); 
                                    gnd_list.append($(option)).selectpicker('refresh');
                                });
                            },
                    failure: function () {
                        alert("Failed!");
                    }
                });
                //gnd_list.html('<option>city1</option><option>city2</option>').selectpicker('refresh');	  
            });
            
            $("#f_edit_form").submit(function(e) {
                e.preventDefault();
                var $form = $(this);
                
                var data = $form.serializeArray();
                
                //freez form
                var $inputs = $("#f_edit_form").find("input, select, button, textarea");                                              
                $inputs.prop("disabled", true);
                // make a POST ajax call 
                $.ajax({
                    type: "POST",
                    url: 'refresh_content.php',
                    data: {
                        option: "save_training",
                        data: $.param(data)
                    },
                    dataType: 'json', 
                    async:false,
                    beforeSend: function ( xhr ) {
                        // maybe tell the user that the request is being processed
                        //$("#status").show().html("<img src='images/preloader.gif' width='32' height='32' alt='processing...'>");
                    }
                }).done(function( result ) {
                        $inputs.prop("disabled", false);
                        if (JSON.parse(result)[0].id !== undefined)
                        {
                            showMessage("Data Saved");
                            $("#id").val(JSON.parse(result)[0].id);
                        }
                        else
                        {
                            showErrorMessage("Error saving training details");
                            //showErrorMessage(JSON.parse(result)); //uncomment this and check the error message
                        }
                        $inputs.prop("disabled", false);
                        
                        RefreshTrainingList();
                    });
            });
                
            $("#new_training").on("click", function () {
                var id = this.id;
                var farmer_id = id.substring(5, id.length);
                $.ajax({
                    type: "GET",
                    url: "edit_training.php",
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
                var obj_id = this.id;
                var id = obj_id.substring(5, obj_id.length);
                $.ajax({
                    type: "GET",
                    url: "edit_training.php",
                    data: {id: id },
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
        
        function RefreshTrainingList()
        {
            $.ajax({
                type: "GET",
                url: "refresh_content.php",
                data: {option: 'list_training' },
                dataType: "html",
                success: function(res)
                        {
                            $("#training_list").empty();
			                $("#training_list").html(res);
                        },
                failure: function () {
                    alert("Failed!");
                }
            });
        }
      </script>
</body>
</html>
