<?php
ob_start();
if(!isset($_SESSION))
    session_start();
?>
<?php include_once( 'includes/head.php');?>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <?php include_once('includes/app_header.php'); ?>

        <?php 
            include_once('includes/side_nav.php');
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

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Training</h1>
                        </div><!-- /.col -->
                        <!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <?php if($new_ok) { ?>
            <button id="new_training" class="float-new-button btn btn-block btn-success btn-lg" data-toggle="modal"
                data-target="#editModal"><i class="fas fa-plus"></i>&nbsp; New Training</button>
            <?php } ?>

            <!-- /.content -->
            <section class="content">
                <!-- <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">DataTable with minimal features &amp; hover style</h3>
                                </div>
                                <div class="card-body">
                                    fff
                                </div>

                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Search Training</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-3">
                                            <label for="cmb_filter_district">Name:</label>
                                            <div>
                                                <select class="selectpicker select2 col-12" data-live-search="true"
                                                    title="List by District" id="cmb_filter_district" required>
                                                    <option value="0" selected="">All</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="cmb_filter_ti_range">Contact No:</label>
                                                <div>
                                                    <select class="selectpicker  select2 col-12" data-live-search="true"
                                                        title="List by Society" id="cmb_filter_society" required>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="cmb_filter_year">DSD:</label>
                                                <div>
                                                    <select class="form-control select2 col-12" id="cmb_filter_year">

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="cmb_filter_year">GND:</label>
                                                <div>
                                                    <select class="form-control select2 col-12" id="cmb_filter_year">

                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label for="cmb_filter_year"> &nbsp;</label>
                                                <div>
                                                    <button id="btn_search" type="button"
                                                        class="btn btn-primary btn-block"><i class="fa fa-search"></i>
                                                        &nbsp;&nbsp; Show Society</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                    if($view_ok)
                    {
                ?>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Society List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div  class="card-body main_tbl_container">
                    <div id="training_list" class="main_tbl_container">
                    <table class="table table-hover table-sm">
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
                    <!-- /.card-body -->
                </div>

                <?php } ?>

                <!-- <div class="modal fade" id="payModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <form class="form-horizontal" id="payment_form">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                ...
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                          </form>
                        </div>
                    </div>
                </div> -->

                <script>
                //global variables
                var token = "<?php echo $_SESSION['token']; ?>";
                </script>



        <div class="modal fade" id="editModal">
        <div class="modal-dialog modal-xl">
          <div class="modal-content">
            <div class="modal-header">

              <h4 class="modal-title">New Training</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="model_content">
              <p>One fine body&hellip;</p>
            </div>
            <div class="modal-footer justify-content-between">
            <button id="btnEditSave" type="submit" class="btn btn-default">Save</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
</div>
</div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <?php include_once('includes/app_footer.php');?>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <?php include_once('includes/footer.php');?>

    <script src="js/training.js"></script>

</body>

</html>