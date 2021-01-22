<?php
include('link_service.php');
include('access.php');
$curr_uid = (isset($_SESSION['curr_uid']) ? $_SESSION['curr_uid'] : null);

$id = 0;
$reg_no = "";
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
$owner_name =  "";
$owner_gender =  "";
$starting_year = 0;
$production_capacity = 0;
$num_plants_available = 0;
$crop_id = 0;
$extended_capacity = 0;        
$selling_area = 0;
$certification = "";
$avg_plants_sell_per_annum = 0;
$plant_prod_cost = 0;
$profit_per_annum = 0;
$obtaining_bank_loan = "";
$amount_of_loan = 0;
$future_expectations = "";
$benifiter_id = 0;
$society_id = 0;

$section = "nursery";
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
    $data = callService("/get_nursery_by_id/$id");
    
    $row = $data[0];
    $name = $row->name;
    $reg_no = $row->reg_no;
    $district_id = $row->district_id;
    $district = $row->district;
    $dsd_id = $row->dsd_id;
    $dsd = $row->dsd;
    $gnd_id = $row->gnd_id;
    $gnd = $row->gnd;
    $ti_id = $row->ti_id;
    $ti = $row->ti;
    $address = $row->address;
    $contact_no = $row->contact_no;
    $owner_name =  $row->owner_name;
    $owner_gender =  $row->owner_gender;
    $starting_year = $row->starting_year;
    $production_capacity = $row->production_capacity;
    $num_plants_available = $row->num_plants_available;
    $crop_id = $row->crop_id;
    $extended_capacity = $row->extended_capacity;        
    $selling_area = $row->selling_area;
    $certification = $row->certification;
    $avg_plants_sell_per_annum = $row->avg_plants_sell_per_annum;
    $plant_prod_cost = $row->plant_prod_cost;
    $profit_per_annum = $row->profit_per_annum;
    $obtaining_bank_loan = $row->obtaining_bank_loan;
    $amount_of_loan = $row->amount_of_loan;
    $future_expectations = $row->future_expectations;
    $benifiter_id = $row->benifiter_id;
    $society_id = $row->society_id;
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
            <label class="control-label col-sm-2" for="txt_id">ID:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_id" value="<?php echo $id; ?>">
            </div>
          </div>
          
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_reg_no">Reg No:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_reg_no" placeholder="Enter registration no" value="<?php echo $reg_no; ?>" required>
            </div>
          </div>  
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_name">Name:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_name" placeholder="Enter nursery name" value="<?php echo $name; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_address">Address:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_address" placeholder="Enter address" value="<?php echo $address; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_contact_no">Contact No:</label>
            <div class="col-sm-10">
              <input type="text" onkeydown="return isNumber(event);" maxlength="10" class="form-control short" id="txt_contact_no" placeholder="Enter contact number" value="<?php echo $contact_no; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_owner_name">Owner Name:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_owner_name" placeholder="Owner Name" value="<?php echo $owner_name; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="cmb_owner_gender">Owner Gender:</label>
            <div class="col-sm-10">
              <select class="form-control" id="cmb_owner_gender">
                <option value="M" <?php echo ($owner_gender == "M") ? "selected" :"";?>>Male</option>
                <option value="F" <?php echo ($owner_gender == "F") ? "selected" :"";?>>Female</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_starting_year">Starting Year:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_starting_year" placeholder="Enter starting year" value="<?php echo $starting_year; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_production_capacity">Production Capacity:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_production_capacity" placeholder="Enter production capascity" value="<?php echo $production_capacity; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_num_plants_available">Num Plants Avail:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_num_plants_available" placeholder="Enter num plants available" value="<?php echo $num_plants_available; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_extended_capacity">Extended Capacity:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_extended_capacity" placeholder="Enter extended capacity" value="<?php echo $extended_capacity; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_selling_area">Selling Area:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_selling_area" placeholder="Enter selling area" value="<?php echo $selling_area; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_certification">Certification:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_certification" placeholder="Enter certification" value="<?php echo $certification; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_avg_plants_sell_per_annum">Avg Plants Sale Year:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_avg_plants_sell_per_annum" placeholder="Enter avg plants sell per annum" value="<?php echo $avg_plants_sell_per_annum; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_plant_prod_cost">Plant Production Cost:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_plant_prod_cost" placeholder="Enter plant production cost" value="<?php echo $plant_prod_cost; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_profit_per_annum">Profit Per Annum:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_profit_per_annum" placeholder="Enter profit per annum" value="<?php echo $profit_per_annum; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="cmb_obtaining_bank_loan">Obtained Bank Loan:</label>
            <div class="col-sm-10">
              <select class="form-control" id="cmb_obtaining_bank_loan">
                <option value="N" <?php echo ($obtaining_bank_loan == "N") ? "selected" :"";?>>No</option>
                <option value="Y" <?php echo ($obtaining_bank_loan == "Y") ? "selected" :"";?>>Yes</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_amount_of_loan">Amount of Loan:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_amount_of_loan" placeholder="Enter loan amount" value="<?php echo $amount_of_loan; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_future_expectations">Future Expectations:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_future_expectations" placeholder="Enter Future Expectations" value="<?php echo $future_expectations; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="cmb_district">District:</label>
            <div class="col-sm-4">
              <select class="selectpicker" data-live-search="true" title="Select District" id="cmb_district" required>
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
            <label class="control-label col-sm-2" for="cmb_dsd">DSD:</label>
            <div class="col-sm-4">
              <select class="selectpicker" data-live-search="true" title="Select DSD" id="cmb_dsd" required>
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
            <label class="control-label col-sm-2" for="cmb_ti">TI Range:</label>
            <div class="col-sm-4">
              <select class="selectpicker" data-live-search="true" title="TI Range" id="cmb_ti">
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
            <label class="control-label col-sm-2" for="cmb_gnd">GND:</label>
            <div class="col-sm-4">
              <select class="selectpicker" data-live-search="true" title="Select GND" id="cmb_gnd">
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
          <div class="form-group">
            <label class="control-label col-sm-2" for="cmb_society">Society:</label>
            <div class="col-sm-4">
              <select class="selectpicker" data-live-search="true" title="Select Society" id="cmb_society">
                    <?php
                        if($district_id > 0)
                        {
                            $data_society = callService("/get_society_by_dsd/$dsd_id");
                            foreach ($data_society as $so) {
                    ?>
                            <option value="<?php echo $so->id; ?>" <?php echo ($so->id == $society_id) ? "selected" :"";?>><?php echo $so->name; ?></option>
                    <?php
                            }
                        }
                    ?>
              </select>
            </div>
            <label class="control-label col-sm-2" for="cmb_benifiter">Benifiter:</label>
            <div class="col-sm-4">
              <select class="selectpicker" data-live-search="true" title="Select Benifiter" id="cmb_benifiter">
                    <?php
                        if($dsd_id > 0)
                        {
                            $data_benifiter = callService("/get_benifiter_by_dsd/$dsd_id");
                            foreach ($data_benifiter as $ben) {
                    ?>
                            <option value="<?php echo $ben->id; ?>" <?php echo ($ben->id == $benifiter_id) ? "selected" :"";?>><?php echo $ben->name; ?></option>
                    <?php
                            }
                        }
                    ?>
              </select>
            </div>
            <!--
    $benifiter_id = $row->benifiter_id;
    $society_id = $row->society_id;
            --!>
          </div>
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