<?php
include('link_service.php');
include('access.php');

$curr_uid = (isset($_SESSION['curr_uid']) ? $_SESSION['curr_uid'] : null);
$id = 0;
$name = "";
$district_id = 0;
$district = "";
$dsd_id = 0;
$dsd = "";
$gnd_id = 0;
$gnd = "";
$ti_id = 0;
$ti = "";
$address = "";
$contact_no = "";
$num_of_male = 0;
$num_of_female = 0;

$reg_number = "";
$reg_date = "";
$society_code = "";
$s_group_code = "";
$fa_code = "";
$president_name = "";
$president_address = "";
$president_contact_no = "";
$sec_name = "";
$sec_contact_no = "";
$treasure_address = "";
$sec_address = "";
$treasure_contact_no = "";
$president_gender = "";
$sec_gender = "";
$treasure_name = "";
$treasure_gender = "";
$president_dob = "";
$sec_dob = "";
$treasure_dob = "";
$num_ha = "";

$section = "society";
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
    
    $data = callService("/get_society_by_id/$id");
    
    $row = $data[0];
    $name = $row->name;
    $district_id = $row->district_id;
    $district = $row->district;
    $dsd_id = $row->dsd_id;
    $dsd = $row->dsd;
    $gnd_id = $row->gnd_id;
    $gnd = $row->gnd;
    $ti_id = $row->ti_id;
    $ti = "";
    $address = $row->address;
    $contact_no = $row->contact_no;
    $num_of_male = $row->num_of_male;
    $num_of_female = $row->num_of_female;
    
    $reg_number = $row->reg_number;
    $reg_date = $row->reg_date;
    $society_code = $row->society_code;
    $s_group_code = $row->s_group_code;
    $fa_code = $row->fa_code;
    
    $president_name = $row->president_name;
    $president_dob = $row->president_dob;
    $president_address = $row->president_address;
    $president_contact_no = $row->president_contact_no;
    $president_gender = $row->president_gender;
    
    $sec_name = $row->sec_name;
    $sec_dob = $row->sec_dob;
    $sec_address = $row->sec_address;
    $sec_contact_no = $row->sec_contact_no;
    $sec_gender = $row->sec_gender;
    
    $treasure_name = $row->treasure_name;
    $treasure_dob = $row->treasure_dob;
    $treasure_address = $row->treasure_address;
    $treasure_contact_no = $row->treasure_contact_no;
    $treasure_gender = $row->treasure_gender;
}
else
{
    if(!$new_ok)
    {
        
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
            <label class="control-label col-sm-2" for="name">Name:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="name" id="name" placeholder="Enter society name" value="<?php echo $name; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="address">Address:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="address" id="address" placeholder="Enter address" value="<?php echo $address; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="contact_no">Contact No:</label>
            <div class="col-sm-10">
              <input type="text" onkeydown="return isNumber(event);" maxlength="10" class="form-control short" name="contact_no" id="contact_no" placeholder="Enter contact number" value="<?php echo $contact_no; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="num_of_male">Num of Males:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="num_of_male" id="num_of_male" placeholder="Enter number of males" value="<?php echo $num_of_male; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="num_of_female">Num of Females:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="num_of_female" id="num_of_female" placeholder="Enter number of females" value="<?php echo $num_of_female; ?>">
            </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-sm-2" for="reg_number">Reg No:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="reg_number" id="reg_number" placeholder="Enter registration number" value="<?php echo $reg_number; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="reg_date">Reg Date:</label>
            <div class="col-sm-10">
              <input type="date" class="form-control short" name="reg_date" id="reg_date" value="<?php echo $reg_date; ?>" style="max-width: 160px;">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="society_code">Society Code:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="society_code" id="society_code" placeholder="Enter society code" value="<?php echo $society_code; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="s_group_code">S Group Code:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="s_group_code" id="s_group_code" placeholder="Enter S group code" value="<?php echo $s_group_code; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="fa_code">FA Code:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="fa_code" id="fa_code" placeholder="Enter FA code" value="<?php echo $fa_code; ?>" >
            </div>
          </div>
          
          <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="panel-group">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" href="#president">President Details</a>
                            </h4>
                          </div>
                          <div id="president" class="panel-collapse collapse">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="president_name">Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="president_name" id="president_name" placeholder="Enter president name" value="<?php echo $president_name; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="president_address">Address:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="president_address" id="president_address" placeholder="Enter president address" value="<?php echo $president_address; ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="president_contact_no">Contact No:</label>
                                <div class="col-sm-10">
                                    <input type="text" onkeydown="return isNumber(event);" maxlength="10" class="form-control short" name="president_contact_no" id="president_contact_no" placeholder="Enter president contact number" value="<?php echo $president_contact_no; ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="president_gender">Gender:</label>
                                <div class="col-sm-10">
                                  <select class="form-control short" name="president_gender" id="president_gender">
                                    <option value="M" <?php echo ($president_gender == "M") ? "selected" :"";?>>Male</option>
                                    <option value="F" <?php echo ($president_gender == "F") ? "selected" :"";?>>Female</option>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="president_dob">DoB:</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control short" name="president_dob" id="president_dob" value="<?php echo $president_dob; ?>">
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
          </div>
          
          <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="panel-group">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" href="#secretary">Secretary Details</a>
                            </h4>
                          </div>
                          <div id="secretary" class="panel-collapse collapse">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="sec_name">Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="sec_name" id="sec_name" placeholder="Enter Secretary name" value="<?php echo $sec_name; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="sec_address">Address:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="sec_address" id="sec_address" placeholder="Enter Secretary address" value="<?php echo $sec_address; ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="sec_contact_no">Contact No:</label>
                                <div class="col-sm-10">
                                    <input type="text" onkeydown="return isNumber(event);" maxlength="10" class="form-control short" name="sec_contact_no" id="sec_contact_no" placeholder="Enter Secretary contact number" value="<?php echo $sec_contact_no; ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="sec_gender">Gender:</label>
                                <div class="col-sm-10">
                                  <select class="form-control short" name="sec_gender" id="sec_gender">
                                    <option value="M" <?php echo ($sec_gender == "M") ? "selected" :"";?>>Male</option>
                                    <option value="F" <?php echo ($sec_gender == "F") ? "selected" :"";?>>Female</option>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="sec_dob">Secretary  DoB:</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control" name="sec_dob" id="sec_dob" value="<?php echo $sec_dob; ?>" style="max-width: 160px;">
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
          </div>
          
          <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="panel-group">
                        <div class="panel panel-default">
                          <div class="panel-heading">
                            <h4 class="panel-title">
                              <a data-toggle="collapse" href="#treasure">Treasure Details</a>
                            </h4>
                          </div>
                          <div id="treasure" class="panel-collapse collapse">
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="treasure_name">Name:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="treasure_name" id="treasure_name" placeholder="Enter treasure name" value="<?php echo $treasure_name; ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="treasure_address">Address:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="treasure_address" id="treasure_address" placeholder="Enter treasure address" value="<?php echo $treasure_address; ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="treasure_contact_no">Contact No:</label>
                                <div class="col-sm-10">
                                    <input type="text" onkeydown="return isNumber(event);" maxlength="10" class="form-control short" name="treasure_contact_no" id="treasure_contact_no" placeholder="Enter treasure contact number" value="<?php echo $treasure_contact_no; ?>" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="treasure_gender">Gender:</label>
                                <div class="col-sm-10">
                                  <select class="form-control short" name="treasure_gender" id="treasure_gender">
                                    <option value="M" <?php echo ($treasure_gender == "M") ? "selected" :"";?>>Male</option>
                                    <option value="F" <?php echo ($treasure_gender == "F") ? "selected" :"";?>>Female</option>
                                  </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-sm-2" for="treasure_dob">DoB:</label>
                                <div class="col-sm-10">
                                    <input type="date" class="form-control short" name="treasure_dob" id="treasure_dob" value="<?php echo $treasure_dob; ?>">
                                </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-sm-2" for="district_id">District:</label>
            <div class="col-sm-4">
              <select class="selectpicker" data-live-search="true" title="Select District" name="district_id" id="district_id" required>
                    <?php
                        $data_dist = callService("/get_all_districts?uid=$curr_uid");
                        foreach ($data_dist as $dist) {
                    ?>
                        <option value="<?php echo $dist->id; ?>" <?php echo ($dist->id == $district_id) ? "selected" :"";?>><?php echo $dist->name; ?></option>
                    <?php
                        }
                    ?>
              </select>
            </div>
            <label class="control-label col-sm-2" for="dsd">DSD:</label>
            <div class="col-sm-4">
              <select class="selectpicker" data-live-search="true" title="Select DSD" name="dsd_id" id="dsd_id" required>
                    <?php
                        if($district_id > 0)
                        {
                            $data_dsd = callService("/get_dsd_by_district/$district_id");
                            foreach ($data_dsd as $dsd) {
                    ?>
                            <option value="<?php echo $dsd->id; ?>" <?php echo ($dsd->id == $dsd_id) ? "selected" :"";?>><?php echo $dsd->name; ?></option>
                    <?php
                            }
                        }
                    ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="ti">TI Range:</label>
            <div class="col-sm-4">
              <select class="selectpicker" data-live-search="true" title="TI Range" name="ti_id" id="ti_id">
                    <?php
                        if($district_id > 0)
                        {
                            $data_ti = callService("/get_ti_by_district/$district_id");
                            foreach ($data_ti as $ti) {
                    ?>
                            <option value="<?php echo $ti->id; ?>" <?php echo ($ti->id == $ti_id) ? "selected" :"";?>><?php echo $ti->name; ?></option>
                    <?php
                            }
                        }
                    ?>
              </select>
            </div>
            <label class="control-label col-sm-2" for="gnd">GND:</label>
            <div class="col-sm-4">
              <select class="selectpicker" data-live-search="true" title="Select GND" name="gnd_id" id="gnd_id">
                    <?php
                        if($dsd_id > 0)
                        {
                            $data_gnd = callService("/get_gnd_by_dsd/$dsd_id");
                            foreach ($data_gnd as $dnd) {
                    ?>
                            <option value="<?php echo $dnd->id; ?>" <?php echo ($dnd->id == $gnd_id) ? "selected" :"";?>><?php echo $dnd->name; ?></option>
                    <?php
                            }
                        }
                    ?>
              </select>
            </div>
          </div>
    </div>