<!DOCTYPE html>
<html lang="en">
<?php include_once('header.php'); ?>
<body>
<?php include_once('nav_bar.php');
    include_once('link_service.php'); 
    include_once('access.php');
?>	

<?php 
    $section = "nursery";
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
        exit(header("Location: login.php?redirect_to=nursery.php"));
    
    if($view_ok)
        $data = callService("/get_all_nursery");
    //if(isset($_SESSION['login_user']))
        //echo $_SESSION['login_user'];
    //else
        //echo "not found";
?>
    <?php
      if($new_ok)
      {
    ?>
      <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="row">
                <div class="col-lg-2"><button id="new_nursery" class="btn btn-primary btn-xs"  data-toggle="modal" data-target="#editModal">New Nursery</button></div>
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
            <div id="nursery_list">
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact No</th>
                        <th>Owner</th>
                        <th>Reg No</th>
                        <th>Society</th>
                        <th>District</th>
                        <th>DSD</th>
                        <th>GND</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($data as $row) {
                    ?>
                        <tr>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo $row->address; ?></td>
                            <td><?php echo $row->contact_no; ?></td>
                            <td><?php echo $row->owner_name; ?></td>
                            <td><?php echo $row->reg_no; ?></td>
                            <td><?php echo $row->society_name; ?></td>
                            <td><?php echo $row->district; ?></td>
                            <td><?php echo $row->dsd; ?></td>
                            <td><?php echo $row->gnd; ?></td>
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
                      <h4 class="modal-title">Nursery Detail</h4>
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
                
                //Set DSDs according to district selection
                $.ajax({
                    type: "GET",
                    url: 'refresh_content.php',
                    data: {token:token, option:"get_dsd_by_district", district_id: district_id},
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
                
                //Set TI range according to district selection
                $.ajax({
                    type: "GET",
                    url: 'refresh_content.php',
                    data: {token:token, option:"get_dsd_by_district", district_id: district_id},
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
                
                //Set GNDs according to DSD selection
                $.ajax({
                    type: "GET",
                    url: 'refresh_content.php',
                    data: {token:token, option:"get_gnd_by_dsd", dsd_id: dsd_id},
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
                
                society_list = $("[id^=cmb_society]");
                
                //Set Societies according to DSD selection
                $.ajax({
                    type: "GET",
                    url: 'refresh_content.php',
                    data: {token:token, option:"get_society_by_dsd", dsd_id: dsd_id},
                    async: false,
                    dataType: "json",
                    success: function(result)
                            {
                                //data = JSON.parse(result);
                                society_list.find('option')
                                        .remove()
                                        .end();
                                $.each(result, function(index, element) {
                                    var option = new Option(element.name, element.id); 
                                    society_list.append($(option)).selectpicker('refresh');
                                });
                            },
                    failure: function () {
                        alert("Failed!");
                    }
                });
                
                benifiter_list = $("[id^=cmb_benifiter]");
                
                //Set Societies according to DSD selection
                $.ajax({
                    type: "GET",
                    url: 'refresh_content.php',
                    data: {token:token, option:"get_benifiter_by_dsd", dsd_id: dsd_id},
                    async: false,
                    dataType: "json",
                    success: function(result)
                            {
                                //data = JSON.parse(result);
                                benifiter_list.find('option')
                                        .remove()
                                        .end();
                                $.each(result, function(index, element) {
                                    var option = new Option(element.name, element.id); 
                                    benifiter_list.append($(option)).selectpicker('refresh');
                                });
                            },
                    failure: function () {
                        alert("Failed!");
                    }
                });	  
            });
            
            $("#f_edit_form").submit(function(e) {
                
                // Grab all values
                var id = $("#txt_id").val();
                var reg_no = $("#txt_reg_no").val();
                var name = $("#txt_name").val();
                var address = $("#txt_address").val();
                var contact_no = $("#txt_contact_no").val();
                var owner_name = $("#txt_owner_name").val();
                var owner_gender = $("#cmb_owner_gender").val();
                var starting_year = $("#txt_starting_year").val();
                var production_capacity = $("#txt_production_capacity").val();
                var num_plants_available = $("#txt_num_plants_available").val();
                var extended_capacity = $("#txt_extended_capacity").val();
                var selling_area = $("#txt_selling_area").val();
                var certification = $("#txt_certification").val();
                var avg_plants_sell_per_annum = $("#txt_avg_plants_sell_per_annum").val();
                var plant_prod_cost = $("#txt_plant_prod_cost").val();
                var profit_per_annum = $("#txt_profit_per_annum").val();
                var obtaining_bank_loan = $("#cmb_obtaining_bank_loan").val();
                var amount_of_loan = $("#txt_amount_of_loan").val();
                var future_expectations = $("#txt_future_expectations").val();
                var district_id = $('#cmb_district').val();
                var dsd_id = $('#cmb_dsd').val();
                var ti_id = $('#cmb_ti').val();
                var gnd_id = $('#cmb_gnd').val();
                var society_id = $('#cmb_society').val();
                var benifiter_id = $('#cmb_benifiter').val();
                
                url = service_url + "/save_nursery";  
                
                //freez form
                var $inputs = $("#f_edit_form").find("input, select, button, textarea");                                              
                $inputs.prop("disabled", true);
                
                // stop form from submitting
                e.preventDefault();
     
                // make a POST ajax call 
                $.ajax({
                    type: "POST",
                    url: 'refresh_content.php',
                    async:false,
                    data: {token:token, option: 'save_nursery', id:id, reg_no:reg_no, name:name, address:address, contact_no:contact_no, owner_name:owner_name, owner_gender:owner_gender, starting_year:starting_year, production_capacity:production_capacity, num_plants_available:num_plants_available, extended_capacity:extended_capacity, selling_area:selling_area, certification:certification, avg_plants_sell_per_annum:avg_plants_sell_per_annum, plant_prod_cost:plant_prod_cost, profit_per_annum:profit_per_annum, obtaining_bank_loan:obtaining_bank_loan, amount_of_loan:amount_of_loan, future_expectations:future_expectations, district_id:district_id, dsd_id:dsd_id, ti_id:ti_id, gnd_id: gnd_id, society_id:society_id, benifiter_id:benifiter_id},
                    beforeSend: function ( xhr ) {
                        // maybe tell the user that the request is being processed
                        //$("#status").show().html("<img src='images/preloader.gif' width='32' height='32' alt='processing...'>");
                    }
                    }).done(function( result ) {
                        debugger;
                        if (JSON.parse(result)[0].id !== undefined)
                        {
                            $("#message").html("Data Saved");
                            $("#txt_id").val(JSON.parse(result)[0].id);
                        }
                        else
                        {
                            $("#message").html("Error saving nursery details");
                            $("#message").html(JSON.parse(result)); //uncomment this and check the error message
                        }
                        $inputs.prop("disabled", false);
                        
                        RefreshnurseryList();
                    });
            });
                
            $("#new_nursery").on("click", function () {
                var id = this.id;
                var farmer_id = id.substring(5, id.length);
                $.ajax({
                    type: "GET",
                    url: "edit_nursery.php",
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
                    url: "edit_nursery.php",
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
        
        function RefreshnurseryList()
        {
            $.ajax({
                type: "GET",
                url: "refresh_content.php",
                data: {token:token, option: 'list_nursery' },
                dataType: "html",
                success: function(res)
                        {
                            $("#nursery_list").empty();
			                $("#nursery_list").html(res);
                        },
                failure: function () {
                    alert("Failed!");
                }
            });
        }
      </script>
</body>
</html>
