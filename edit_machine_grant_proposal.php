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
    $section = "factory";
    $data = array();
    
    $view_ok = false;
    $new_ok = false;
    $edit_ok = false;
    $add_beneficiaries_ok = false;
    
    if(isset($_SESSION['access_obj']))
    {
        $section_access = getSectionAccess($section);
        if(isset($section_access->view))
            $view_ok = ($section_access->view=='Y' ? true : false);
        if(isset($section_access->new))
            $new_ok = ($section_access->new=='Y' ? true : false);
        if(isset($section_access->edit))
            $edit_ok = ($section_access->edit=='Y' ? true : false);
        if(isset($section_access->add_beneficiaries))
            $add_beneficiaries_ok = ($section_access->add_beneficiaries=='Y' ? true : false);
    }
    else
        exit(header("Location: login.php?redirect_to=machine_grant_proposal.php"));
       
    $curr_uid = (isset($_SESSION['curr_uid']) ? $_SESSION['curr_uid'] : null);
    $id = 0;
    $name = "";
    $society_id = 0;
    $district_id = 0;
    $year = date("Y");
    $is_benefiter_list_submited = 'N';
    $is_commitee_minutes_submited = 'N';
    $assigned_fa_id = 0;
    $pass_to_cdo  = 'N';
    $assigned_cdo_id = 0;
    $is_pmu_accepted  = 'N';
    $pmu_accepted_by = 0;

    if(isset($_GET['id']))
        $id = $_GET['id'];

    if($id > 0 && $view_ok)    
    {
        $data = callService("/get_machine_grant_by_id/$id");
        
        $row = $data[0];
        $name = $row->name;
        $district_id = $row->district_id;
        $society_id = $row->society_id;
        $year = $row->year;
        $is_benefiter_list_submited = $row->is_benefiter_list_submited;
        $is_commitee_minutes_submited = $row->is_commitee_minutes_submited;
        $assigned_fa_id = $row->assigned_fa_id;
        $pass_to_cdo  = $row->pass_to_cdo;
        $assigned_cdo_id = $row->assigned_cdo_id;
        $is_pmu_accepted  = $row->is_pmu_accepted;
        $pmu_accepted_by = $row->pmu_accepted_by;
    }
    else
    {
        $top_district = callService("/get_user_top_district/$curr_uid");
        $district_id = $top_district[0]->district_id;
    }
?>
    <div class="row">
        <div class="col-lg-1 side_border"></div>
        <div class="col-lg-10" id="container" style="padding: 25px 0px;">
        <h4 class="modal-title">Edit machine grant proposal</h4>
        </div>
        <div class="col-lg-1 side_border"></div>
    </div>
    <?php
        if($view_ok)
        {
    ?> 
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10"> 
            <form class="form-horizontal" id="f_edit_form">    
                <!-- Example row of columns -->
                <div class="form-group" style="display: none;">
                    <label class="control-label col-sm-2" for="id">ID:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="id" id="id" value="<?php echo $id; ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-2" for="name">Name:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="name" id="name" placeholder="Enter name" value="<?php echo $name; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="district_id">District:</label>
                    <div class="col-sm-10">
                      <select class="selectpicker" data-live-search="true" title="Select District" name="district_id" id="district_id" required>
                        <?php
                            $data_district = callService("/get_all_districts?uid=$curr_uid");
                            foreach ($data_district as $dist) {
                        ?>
                            <option data-tokens="<?php echo $dist->name; ?>" value="<?php echo $dist->id; ?>" 
                                            <?php echo ($district_id == $dist->id) ? "selected" :"";?>><?php echo $dist->name; ?></option>
                        <?php
                            }
                        ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="society_id">Society:</label>
                    <div class="col-sm-10">
                      <select class="selectpicker form-control" data-live-search="true" title="Select Society" name="society_id" id="society_id">
                        <?php
                        if($district_id > 0)
                        {
                            $data_district_sos = callService("/get_society_by_district/$district_id");
                            foreach ($data_district_sos as $dist_sos) {
                        ?>
                            <option data-tokens="<?php echo $dist_sos->name; ?>" value="<?php echo $dist_sos->id; ?>" 
                                <?php echo ($society_id == $dist_sos->id) ? "selected" :"";?>><?php echo $dist_sos->name; ?></option>
                        <?php
                            }
                        }
                        ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="year">Year:</label>
                    <div class="col-sm-10">
                      <select class="form-control short" id="year" name="year">
                        
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="is_benefiter_list_submited"></label>
                    <div class="col-sm-10">
                        <input name="is_benefiter_list_submited" id="is_benefiter_list_submited" type="checkbox" <?php echo ($is_benefiter_list_submited == "Y") ? "checked" :"";?>/>
                        <label for="is_benefiter_list_submited">Benefiter List Submited</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="is_commitee_minutes_submited"></label>
                    <div class="col-sm-10">
                        <input name="is_commitee_minutes_submited" id="is_commitee_minutes_submited" type="checkbox" <?php echo ($is_commitee_minutes_submited == "Y") ? "checked" :"";?>/>
                        <label for="is_commitee_minutes_submited">Commitee Minutes Submited</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="assigned_fa_id">Assigned FA:</label>
                    <div class="col-sm-10">
                      <select class="selectpicker form-control" data-live-search="true" title="Select FA" name="assigned_fa_id" id="assigned_fa_id">
                        <?php
                        if($district_id > 0)
                        {
                            $data_district_fa = callService("/get_fa_list_by_district/$district_id");
                            foreach ($data_district_fa as $dist_fa) {
                        ?>
                            <option data-tokens="<?php echo $dist_fa->name; ?>" value="<?php echo $dist_fa->id; ?>" 
                                <?php echo ($assigned_fa_id == $dist_fa->id) ? "selected" :"";?>><?php echo $dist_fa->name; ?></option>
                        <?php
                            }
                        }
                        ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="pass_to_cdo" data-toggle="collapse"></label>
                    <div class="col-sm-10">
                        <label data-toggle="collapse" data-target="#assigned_cdo_div">
                            <input name="pass_to_cdo" id="pass_to_cdo" type="checkbox" <?php echo ($pass_to_cdo == "Y") ? "checked" :"";?>/> Pass to CDO	
                        </label>
                    </div>
                </div>
                <?php
                    $show_cdo = "";
                    if($pass_to_cdo == "N")
                        $show_cdo = "collapse";
                ?>
                <div class="form-group <?php echo $show_cdo; ?>" id="assigned_cdo_div">
                    <label class="control-label col-sm-2" for="assigned_cdo_id">Assigned CDO:</label>
                    <div class="col-sm-10">
                      <select class="selectpicker form-control" data-live-search="true" title="Select CDO" name="assigned_cdo_id" id="assigned_cdo_id">
                        <?php
                        if($district_id > 0)
                        {
                            $data_district_fa = callService("/get_fa_list_by_district/$district_id");
                            foreach ($data_district_fa as $dist_fa) {
                        ?>
                            <option data-tokens="<?php echo $dist_fa->name; ?>" value="<?php echo $dist_fa->id; ?>" 
                                <?php echo ($assigned_cdo_id == $dist_fa->id) ? "selected" :"";?>><?php echo $dist_fa->name; ?></option>
                        <?php
                            }
                        }
                        ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="is_pmu_accepted"></label>
                    <div class="col-sm-10">
                        <label data-toggle="collapse" data-target="#assigned_pmu_div">
                            <input name="is_pmu_accepted" id="is_pmu_accepted" type="checkbox" <?php echo ($is_pmu_accepted == "Y") ? "checked" :"";?>/>Accepted by PMU	
                        </label>
                    </div>
                </div>
                <?php
                    $show_pmu = "";
                    if($is_pmu_accepted == "N")
                        $show_pmu = "collapse";
                ?>
                <div class="form-group <?php echo $show_pmu; ?>" id="assigned_pmu_div">
                    <label class="control-label col-sm-2" for="pmu_accepted_by">PMU Officer:</label>
                    <div class="col-sm-10">
                      <select class="selectpicker form-control" data-live-search="true" title="Select PMU Officer" name="pmu_accepted_by" id="pmu_accepted_by">
                        <?php
                            $data_pmu_officer = callService("/get_pmu_officer_list");
                            foreach ($data_pmu_officer as $pmu_o) {
                        ?>
                            <option data-tokens="<?php echo $pmu_o->name; ?>" value="<?php echo $pmu_o->id; ?>" 
                                <?php echo ($pmu_accepted_by == $pmu_o->id) ? "selected" :"";?>><?php echo $pmu_o->name; ?></option>
                        <?php
                            }
                        ?>
                      </select>
                    </div>
                </div>
                <div style="clear: both;">
                  <div id="message" style="float: left; text-align: left;"></div>
                  <div style="float: right;">
                      <button id="btn_save" type="submit" class="btn btn-default">Save</button>
                      <button id="btn_cancel" type="button" class="btn btn-default">Cancel</button>
                  </div>
                </div>
              </form>
          </div>
          <div class="col-lg-1"></div>
    </div>
          
    <?php
        }
    ?>
      <?php include('footer.php'); ?>
      <script>
        $( document ).ready(function() {
            var $filter_year = $('#year');
            var curr_year = (new Date).getFullYear();
            for(var i=2017; i <= curr_year; i++)
            {
                if(i==curr_year)
                {
                    $filter_year.append($("<option selected />").val(i).text(i));
                }
                else
                {
                    $filter_year.append($("<option />").val(i).text(i));
                }
            }
        });
        
        $("#btn_cancel").on("click", function () {
            window.location.href='machine_grant_proposal.php?id=0';
        });
        
        $(function() {
            $('body').on('change', '#district_id', function() {
                society_list = $("[id^=society_id]");
                
                var dist_id = $(this).find(":selected").val();
                
                //Set DSDs according to district selection
                $.ajax({
                    type: "GET",
                    url: "refresh_content.php",
                    data: {option: 'get_society_by_district', district_id:dist_id},
                    async: false,
                    dataType: "json",
                    success: function(result)
                            {
                                //data = JSON.parse(result);
                                society_list.find('option')
                                        .remove()
                                        .end();
                                var option = new Option('None', 0); 
                                society_list.append($(option)).selectpicker('refresh'); //Add option All
                                
                                $.each(result, function(index, element) {
                                    var option = new Option(element.name, element.id); 
                                    society_list.append($(option)).selectpicker('refresh');
                                });
                            },
                    failure: function () {
                        alert("Failed!");
                    }
                });  
            });
            
            $("#f_edit_form").submit(function(e) {
                
                //stop form from submitting
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
                        token:token, option: "save_machine_grant_base",
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
                        debugger;
                        if (JSON.parse(result)[0].id !== undefined)
                        {
                            showMessage("Data Saved");
                            $("#id").val(JSON.parse(result)[0].id);
                        }
                        else
                        {
                            showErrorMessage("Error saving society details");
                            //$("#message").html(JSON.parse(result)); //uncomment this and check the error message
                        }
                        
                        //RefreshFactoryList();
                    });
            });
            
        });
      </script>
</body>
</html>