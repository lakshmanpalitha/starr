<?php
include('link_service.php');
include('access.php');
$curr_uid = (isset($_SESSION['curr_uid']) ? $_SESSION['curr_uid'] : null);

$id = 0;
$training_type_id = 0;
$target = 0;
$training_group_id = 0;
$budget_line = "";
$start_date = "";
$resource_person = "";
$amount = 0;
$end_date = "";
$target_group = 0;
$target_group_if_other = "";
$organized_by = "";
$dpmu = "";
$venue = "";
$num_male_participants = 0;
$num_female_participants = 0;
$duration_hrs = 0;
$society_names = "";
$num_society_members = "";
$organization = "";
$designation = "";
$qualification = "";
$contact_no = "";

$section = "training";
$data = array();
$new_ok = false;
$edit_ok = false;
if(isset($_SESSION['access_obj']))
{
    $section_access = getSectionAccess($section);

    if(isset($section_access->new))
        $new_ok = ($section_access->new=='Y' ? true : false);
    if(isset($section_access->edit))
        $edit_ok = ($section_access->edit=='Y' ? true : false);
}

if(isset($_GET['id']))
    $id = $_GET['id'];

if($id > 0)    
{
    if(!$edit_ok)
    {
        echo '<p class="error_msg">you are not allowed to edit this content</p>';
        goto footer;
    }
    $data = callService("/get_training_by_id/$id");
    $row = $data[0];
    $training_type_id = $row->training_type_id;
    $target = $row->target;
    $training_group_id = $row->training_group_id;
    $budget_line = $row->budget_line;
    $start_date = $row->start_date;
    $resource_person = $row->resource_person;
    $amount = $row->amount;
    $end_date = $row->end_date;
    $target_group = $row->target_group;
    $target_group_if_other = $row->target_group_if_other;
    $organized_by = $row->organized_by;
    $dpmu = $row->dpmu;
    $venue = $row->venue;
    $num_male_participants = $row->num_male_participants;
    $num_female_participants = $row->num_female_participants;
    $duration_hrs = $row->duration_hrs;
    $society_names = $row->society_names;
    $num_society_members = $row->num_society_members;
    $organization = $row->organization;
    $designation = $row->designation;
    $qualification = $row->qualification;
    $contact_no = $row->contact_no;
}
else
{
    if(!$new_ok)
    {
        echo '<p class="error_msg">you are not allowed for this operation</p>';
        goto footer;
    }
}                
?>

    <div id="model_content" class="modal-body">
          <div class="form-group" style="display: none;">
            <label class="control-label col-sm-2" for="id">ID:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="id" id="id" value="<?php echo $id; ?>">
            </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-sm-2" for="training_type">Training Type:</label>
            <div class="col-sm-10">
              <select class="selectpicker" data-live-search="true" title="Select Training Type" name="training_type_id" id="training_type_id" required>
                    <?php
                        $data_tt = callService("/get_all_training_type");
                        foreach ($data_tt as $tt) {
                    ?>
                        <option value="<?php echo $tt->id; ?>" <?php echo ($tt->id == $training_type_id) ? "selected" :"";?>><?php echo $tt->name; ?></option>
                    <?php
                        }
                    ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="organized_by">Organized by:</label>
            <div class="col-sm-10">
              <select class="selectpicker" data-live-search="true" title="Select Organized by" name="organized_by" id="organized_by" required>
                    <option value="PMU" <?php echo ($organized_by == "PMU") ? "selected" :"";?>>PMU</option>
                    <option value="DPMU" <?php echo ($organized_by == "DPMU") ? "selected" :"";?>>DPMU</option>
                    <option value="RDD" <?php echo ($organized_by == "RDD") ? "selected" :"";?>>RDD</option>
                    <option value="TSHDA" <?php echo ($organized_by == "TSHDA") ? "selected" :"";?>>TSHDA</option>
                    <option value="TRI" <?php echo ($organized_by == "TRI") ? "selected" :"";?>>TRI</option>
                    <option value="RRI" <?php echo ($organized_by == "RRI") ? "selected" :"";?>>RRI</option>
                    <option value="MPI" <?php echo ($organized_by == "MPI") ? "selected" :"";?>>MPI</option>
                    <option value="Other" <?php echo ($organized_by == "Other") ? "selected" :"";?>>Other</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="target_group">Target Group:</label>
            <div class="col-sm-10">
              <select class="selectpicker" data-live-search="true" title="Select Target Group" name="target_group" id="target_group" required>
                    <option value="Farmer" <?php echo ($target_group == "Farmer") ? "selected" :"";?>>Farmer</option>
                    <option value="PMU" <?php echo ($target_group == "PMU") ? "selected" :"";?>>PMU</option>
                    <option value="Staff" <?php echo ($target_group == "Staff") ? "selected" :"";?>>Staff</option>
                    <option value="DPMU" <?php echo ($target_group == "DPMU") ? "selected" :"";?>>DPMU</option>
                    <option value="Staff" <?php echo ($target_group == "Staff") ? "selected" :"";?>>Staff</option>
                    <option value="Society" <?php echo ($target_group == "Society") ? "selected" :"";?>>Society</option>
                    <option value="Other" <?php echo ($target_group == "Other") ? "selected" :"";?>>Other</option>
              </select>
            </div>
          </div> 
          <div class="form-group">
            <label class="control-label col-sm-2" for="target_group_if_other">Specify Other:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="target_group_if_other" id="target_group_if_other" placeholder="Enter target" value="<?php echo $target_group_if_other; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="dpmu">DPMU:</label>
            <div class="col-sm-10">
              <select class="selectpicker" data-live-search="true" title="Select DPMU" name="dpmu" id="dpmu" required>
                    <option value="Galle" <?php echo ($dpmu == "Galle") ? "selected" :"";?>>Galle</option>
                    <option value="Matara" <?php echo ($dpmu == "Matara") ? "selected" :"";?>>Matara</option>
                    <option value="Rathnapura" <?php echo ($dpmu == "Rathnapura") ? "selected" :"";?>>Rathnapura</option>
                    <option value="Kandy" <?php echo ($dpmu == "Kandy") ? "selected" :"";?>>Kandy</option>
                    <option value="Nuwaraeliya" <?php echo ($dpmu == "Nuwaraeliya") ? "selected" :"";?>>Nuwaraeliya</option>
                    <option value="Badulla" <?php echo ($dpmu == "Badulla") ? "selected" :"";?>>Badulla</option>
                    <option value="Monaragala" <?php echo ($dpmu == "Monaragala") ? "selected" :"";?>>Monaragala</option>
                    <option value="Ampara" <?php echo ($dpmu == "Ampara") ? "selected" :"";?>>Ampara</option> 
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="start_date">Start Date:</label>
            <div class="col-sm-10">
              <input type="date" class="form-control" style="max-width: 160px;" name="start_date" id="start_date" placeholder="Enter start date" value="<?php echo $start_date; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="end_date">End Date:</label>
            <div class="col-sm-10">
              <input type="date" class="form-control" style="max-width: 160px;" name="end_date" id="end_date" placeholder="Enter end date" value="<?php echo $end_date; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="duration_hrs">Duration hours:</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" name="duration_hrs" id="duration_hrs" placeholder="Enter duration hours" value="<?php echo ($id > 0) ? $duration_hrs :"";?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="venue">Venue:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="venue" id="venue" placeholder="Enter venue" value="<?php echo $venue; ?>" required>
            </div>
          </div> 
          <div class="form-group">
            <label class="control-label col-sm-2" for="target">Target:</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" name="target" id="target" placeholder="Enter target" value="<?php echo ($id > 0) ? $target :"";?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="num_male_participants">Male Participants:</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" name="num_male_participants" id="num_male_participants" placeholder="Enter num of male participants" value="<?php echo ($id > 0) ? $num_male_participants :"";?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="num_female_participants">Female Participants:</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" name="num_female_participants" id="num_female_participants" placeholder="Enter num of female participants" value="<?php echo ($id > 0) ? $num_female_participants :"";?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="budget_line">Budget Line:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="budget_line" id="budget_line" placeholder="Enter budget line" value="<?php echo $budget_line; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="amount">Amount:</label>
            <div class="col-sm-10">
              <input type="number" class="form-control" name="amount" id="amount" placeholder="Enter amount" value="<?php echo ($id > 0) ? $amount :"";?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="society_names">Society Names:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="society_names" id="society_names" placeholder="Enter society names separated by coma" value="<?php echo $society_names; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="num_society_members">Num of Memebers:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="num_society_members" id="num_society_members" placeholder="Enter each society nums separated by coma" value="<?php echo $num_society_members; ?>" >
            </div>
          </div>
          
        <fieldset>
            <legend>Resource Details:</legend>
            <div class="form-group">
                <label class="control-label col-sm-2" for="resource_person">Resource Person:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="resource_person" id="resource_person" placeholder="Enter Resource Person" value="<?php echo $resource_person; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="organization">Organization:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="organization" id="organization" placeholder="Enter organization" value="<?php echo $organization; ?>" >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="designation">Designation:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="designation" id="designation" placeholder="Enter designation" value="<?php echo $designation; ?>" >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="qualification">Qualification:</label>
                <div class="col-sm-10">
                  <select class="selectpicker" data-live-search="true" title="Select Qualification" name="qualification" id="qualification" >
                        <option value="Diploma" selected="">Diploma</option>
                        <option value="Degree">Degree</option>
                        <option value="Masters">Master's Degree</option>
                        <option value="Phd">Phd</option>
                        <option value="Other">Other</option>
                  </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contact_no">Contact No:</label>
                <div class="col-sm-10">
                  <input type="text" onkeydown="return isNumber(event);" maxlength="10" class="form-control short" name="contact_no" id="contact_no" placeholder="Enter contact no" value="<?php echo $contact_no; ?>" >
                </div>
            </div>  
        </fieldset>
        <?php footer:?>  
        <div class="modal-footer">
            <div style="clear: both;">
              <div id="message" style="float: left; text-align: left;"></div>
              <div style="float: right;">
                  <button id="btn_save" type="submit" class="btn btn-default">Save</button>
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
        </div>
    </div>
    
