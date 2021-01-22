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
    $section = "machine_grant_proposal";
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
    
    $user_district_id = (isset($_SESSION['user_district_id']) ? $_SESSION['user_district_id'] : null);    
    if($view_ok && $user_district_id > 0)
        $data = callService("/get_machine_grant_by_district/$user_district_id");
?>
    <?php
      if($new_ok)
      {
    ?>
      <div class="row">
        <div class="col-lg-1 side_border"></div>
        <div class="col-lg-10" id="container" style="padding: 25px 0px;">
        <h4 class="modal-title">Machine grant proposal</h4>
        </div>
        <div class="col-lg-1 side_border"></div>
      </div>
       
      <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="row">
                <div class="col-lg-2"><button id="new_machine_grant_proposal" class="btn btn-primary btn-xs">New Proposal</button></div>
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
            <div id="factory_list">
                <table class="table table-hover">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Year</th>
                        <th>District</th>
                        <th>DSD</th>
                        <th>Society</th>
                        <th></th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($data as $row) {
                    ?>
                        <tr>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo $row->year; ?></td>
                            <td><?php echo $row->district_name; ?></td>
                            <td><?php echo $row->dsd_name; ?></td>
                            <td><?php echo $row->society_name; ?></td>
                            <td>
                            <?php if($edit_ok){ ?>
                                <button type="button" id="<?php echo "edit_" . $row->id; ?>" class="btn btn-primary btn-xs edit">Edit</button>
                            <?php } ?>
                            </td>
                            <td>
                            <?php if($add_beneficiaries_ok){ ?>
                                <button type="button" id="<?php echo "bene_" . $row->id; ?>" class="btn btn-primary btn-xs ben_list">Beneficiaries</button>
                            <?php } ?>
                            </td>
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
      <?php include('footer.php'); ?>
      <script>
        //service_url = "http://localhost/starr/services/index.php";
        //service_url = "http://starr.lk/mis-system/services/index.php";
        
        $(function() {  
            });
              
        $("#new_machine_grant_proposal").on("click", function () {
            window.location.href='edit_machine_grant_proposal.php?id=0';
        });
        
        $('body').on('click', '.edit', function() {
            var obj_id = this.id;
            var id = obj_id.substring(5, obj_id.length);
            window.location.href='edit_machine_grant_proposal.php?id=' + id;
        });
        $('body').on('click', '.ben_list', function() {
            var obj_id = this.id;
            var id = obj_id.substring(5, obj_id.length);
            window.location.href='edit_machine_grant_beneficiary.php?id=' + id;
        });
      </script>
</body>
</html>
