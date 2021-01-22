<!DOCTYPE html>
<html lang="en">
<?php include_once('header.php'); ?>
<body>
<?php include_once('nav_bar.php'); ?>
<?php include_once('link_service.php'); ?>
<?php include_once('access.php'); ?>
<?php
    $section = "benefiter";
    $data = array();
    $curr_uid = (isset($_SESSION['curr_uid']) ? $_SESSION['curr_uid'] : null);
    
    $view_ok = true;
    $new_ok = false;
    $edit_ok = false;
    $payment_ok = false;
    /* 
    if(isset($_SESSION['access_obj']))
    {
        $section_access = getSectionAccess($section);
    
        if(isset($section_access->view))
            $view_ok = ($section_access->view=='Y' ? true : false);
        if(isset($section_access->new))
            $new_ok = ($section_access->new=='Y' ? true : false);
        if(isset($section_access->edit))
            $edit_ok = ($section_access->edit=='Y' ? true : false);
        if(isset($section_access->payment))
            $payment_ok = ($section_access->payment=='Y' ? true : false);
    }
    else
        exit(header("Location: login.php?redirect_to=reports.php"));
    */    
    $data = null;
    $dist_id = 0;
    if($view_ok)
    {
        
    }
    ?>	
      <div class="row m-10">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="row">
                <div class="col-lg-8">
                    <label class="control-label col-lg-1" for="cmb_district">Reports:</label>
                    <select class="selectpicker col-lg-7" data-live-search="true" title="Select Report" id="cmb_report" required>
                        <?php
                            $data_rpt = callService("/get_all_reports");
                            foreach ($data_rpt as $rpt) {
                        ?>
                                <option value="<?php echo $rpt->id; ?>"><?php echo $rpt->name; ?></option>
                        <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="col-lg-4"></div>
            </div>
        </div>
        <div class="col-lg-1"></div>
      </div>
      
      <div class="row m-10 collapse" id="rpt_options">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="row" id="rpt_parameters">
                <div class="card">
                  <div class="card-block">
                    <h6 class="card-subtitle mb-2 text-muted">Report Options</h6>
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-lg-8">
                            <label class="control-label col-lg-1" for="cmb_district">Year:</label>
                            <select class="selectpicker col-lg-2" data-live-search="false" title="Select Year" id="cmb_year" required>
                                <option value="All">All</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2019">2020</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-lg-10">
                            <label for="cmb_filter_district">District:</label>
                              <select class="selectpicker" data-live-search="true" title="List by District" id="cmb_filter_district" required>
                                    <option value="0" selected="">All</option>
                                    <?php
                                        $data_district = callService("/get_all_districts?uid=$curr_uid");
                                        foreach ($data_district as $dist) {
                                    ?>
                                        <option value="<?php echo $dist->id; ?>" <?php echo ($dist_id == $dist->id) ? "selected" :"";?>><?php echo $dist->name; ?></option>
                                    <?php
                                        }
                                    ?>
                              </select>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-lg-1"></div>
      </div>
      
      <div class="row m-10">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="row" id="rpt_actions">
                <button id="btn_view_report" type="submit" class="btn btn-default">View</button>
                <button id="btn_download_report" type="submit" class="btn btn-default">Download</button>
            </div>
        </div>
        <div class="col-lg-1"></div>
      </div>
      
      <!-- Example row of columns -->
      <div class="row">
        <div class="col-lg-1 side_border"></div>
        <div class="col-lg-10" id="container" style="padding: 25px 0px;">
            
        </div>
        <div class="col-lg-1 side_border"></div>
      </div>
      
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
        service_url = "http://starr.lk/services/index.php";
        
        $(function() {
            $('body').on('change', '#cmb_report', function() {
                var report_name = $("#cmb_report :selected").text();
                
                if(report_name == "Benifiter Details")
                {
                    $('#rpt_options').collapse("show");
                } 
                else
                {
                    $('#rpt_options').collapse("hide");
                } 
            });
                
            $("#btn_view_report").on("click", function () {
                var report_name = $("#cmb_report :selected").text();
                var year = 0;
                var dist_id = 0;
                if($("#cmb_year").val() != 'All')
                    year = $("#cmb_year").val();
                if($("#cmb_filter_district").val() != 'All')
                    dist_id = $("#cmb_filter_district").val();
                    
                $.ajax({
                    type: "GET",
                    url: "refresh_content.php",
                    data: {option: 'report', name: report_name, year: year, dist_id:dist_id },
                    dataType: "html",
                    success: function(res)
                            {
                                $("#container").empty();
    			                $("#container").html(res);
                            },
                    failure: function () {
                        alert("Failed!");
                    }
                });
                
                /*    
                $.ajax({
                    type: "GET",
                    url: "refresh_content.php",
                    data: {option: 'report', name: report_name, year: year, dist_id:dist_id },
                    dataType: "html",
                    success: function(res)
                            {
                                $("#container").empty();
    			                $("#container").html(res);
                            },
                    failure: function () {
                        alert("Failed!");
                    }
                });
                */
                
                
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
