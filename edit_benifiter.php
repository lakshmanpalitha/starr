<?php
include('link_service.php');
include('access.php');

$id = 0;
$name = "";
$nic_no = "";
$year = "";   
$target = "";
$address = "";
$contact_no = "";
$land_name = "";
$plot_no = "";
$bank_id = 0;
$bank_code = "";
$branch_code = "";
$branch_name = "";
$account_number = "";
$gender = "";
$district_id = 0;
$permit_id = 0;
$permit_no = "";
$data_permits = "";
$data_dependats = "";
$society_id = 0;

$spouse_name = "";
$spouse_nic_no = "";
$spouse_gender = "";
$spouse_dob = "";
$spouse_highest_edu_level = "";
$spouse_is_fulltime_employee = "";
$spouse_is_parttime_emaployee = "";

$section = "benefiter";
$data = array();

$curr_uid = (isset($_SESSION['curr_uid']) ? $_SESSION['curr_uid'] : null);

$new_ok = false;
$edit_ok = false;
$payment_ok = false;

if(isset($_SESSION['access_obj']))
{
    $section_access = getSectionAccess($section);

    if(isset($section_access->new))
        $new_ok = ($section_access->new=='Y' ? true : false);
    if(isset($section_access->edit))
        $edit_ok = ($section_access->edit=='Y' ? true : false);
    if(isset($section_access->payment))
        $payment_ok = ($section_access->payment=='Y' ? true : false);
}

if(isset($_GET['load']))
{
    $load = $_GET['load'];
    if($load == "mobile")
        include('header.php');
}

if(isset($_GET['id']))
    $id = $_GET['id'];

if($id > 0)    
{
    if(!$edit_ok)
    {
        echo '<p class="error_msg">you are not allowed to edit this content</p>';
        //goto footer;
    }
    $data = callService("/get_benifiter_by_id/$id");
    
    $row = $data[0];
    $name = $row->name; 
    $nic_no = $row->nic_no;
    $gender = $row->gender; 
    $year = $row->year;   
    $target = $row->target;
    $address = $row->address;
    $contact_no = $row->contact_number;
    $land_name = $row->land_name;
    $plot_no = $row->plot_no;  
    $bank_id = $row->bank_id;
    $bank_code = $row->bank_code;
    $branch_code = $row->branch_code;
    $branch_name = $row->branch_name;
    $account_number = $row->account_no;  
    $gender = $row->gender;
    $district_id = $row->district_id;
    $society_id = $row->society_id;
    
    $spouse_name = $row->spouse_name;
    $spouse_nic_no = $row->spouse_nic_no;
    $spouse_gender = $row->spouse_gender;
    $spouse_dob = $row->spouse_dob;
    $spouse_highest_edu_level = $row->spouse_highest_edu_level;
    $spouse_is_fulltime_employee = $row->spouse_is_fulltime_employee;
    $spouse_is_parttime_emaployee = $row->spouse_is_parttime_emaployee;
    //$data_dependats =  callService("/get_dependants_by_benifiter/$id");
    $data_permits =  callService("/get_permits_by_benifiter/$id");
}
                
?>

    <div id="model_content" class="modal-body">
        
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_name">System ID:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="txt_id" id="txt_id" value="<?php echo $id; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_name">Name:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="txt_name" id="txt_name" placeholder="Enter farmer name" value="<?php echo $name; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_nic_no">NIC No:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="txt_nic_no" id="txt_nic_no" placeholder="Enter NIC No" value="<?php echo $nic_no; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="cmb_gender">Gender:</label>
            <div class="col-sm-10">
              <select class="form-control short" name="cmb_gender" id="cmb_gender">
                <option value="M" <?php echo ($gender == "M") ? "selected" :"";?>>Male</option>
                <option value="F" <?php echo ($gender == "F") ? "selected" :"";?>>Female</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="cmb_year">Year:</label>
            <div class="col-sm-10">
              <select class="form-control short" name="cmb_year" id="cmb_year">
                <option value="2017" <?php echo ($year == "2017") ? "selected" :"";?>>2017</option>
                <option value="2018" <?php echo ($year == "2018") ? "selected" :"";?>>2018</option>
                <option value="2019" <?php echo ($year == "2019") ? "selected" :"";?>>2019</option>
                <option value="2020" <?php echo ($year == "2020" || $id==0) ? "selected" :"";?>>2020</option>
              </select>
            </div>
          </div>
          <div class="form-group" style="display: none;">
            <label class="control-label col-sm-2" for="txt_target">Target:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="txt_target" id="txt_target" placeholder="Enter Target" value="<?php echo $target; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_address">Address:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="txt_address" id="txt_address" placeholder="Enter Address" value="<?php echo $address; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_contact_number">Contact No:</label>
            <div class="col-sm-10">
              <input type="text" onkeydown="return isNumber(event);" maxlength="10" class="form-control short" name="txt_contact_number" id="txt_contact_number" placeholder="Enter Contact No" value="<?php echo $contact_no; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="cmb_beni_district">District:</label>
            <div class="col-sm-10">
              <select class="selectpicker" data-live-search="true" title="Select District" name="cmb_ben_district" id="cmb_ben_district" required>
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
            <label class="control-label col-sm-2" for="cmb_society">Society:</label>
            <div class="col-sm-10">
              <select class="selectpicker form-control" data-live-search="true" title="Select Society" name="cmb_society" id="cmb_society">
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
            <label class="control-label col-sm-2" for="cmb_bank">Bank:</label>
            <div class="col-sm-10">
              <select class="selectpicker" data-live-search="true" title="Select Bank" name="cmb_bank" id="cmb_bank" required>
                <?php
                    $data_banks = callService("/get_all_banks");
                    foreach ($data_banks as $bnk) {
                ?>
                    <option data-tokens="<?php echo $bnk->name; ?>" value="<?php echo $bnk->code; ?>" 
                                   <?php echo ($bank_code == $bnk->code) ? "selected" :"";?>><?php echo $bnk->name; ?></option>
                <?php
                    }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_branch_name">Branch Name:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="txt_branch_name" id="txt_branch_name" placeholder="Enter Branch Name" value="<?php echo $branch_name; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_branch_code">Branch Code:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="txt_branch_code" id="txt_branch_code" placeholder="Enter Branch Code" value="<?php echo $branch_code; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_account_no">Account No:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="txt_account_no" id="txt_account_no" placeholder="Enter Account Number" value="<?php echo $account_number; ?>" required>
            </div>
          </div>
          
          <div class="panel-group">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#spouse">Spouse Details</a>
                </h4>
              </div>
              <div id="spouse" class="panel-collapse collapse" style="padding-top: 10px;">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="spouse_name">Name:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="spouse_name" id="spouse_name" placeholder="Enter spouse name" value="<?php echo $spouse_name; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="spouse_nic_no">NIC No:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="spouse_nic_no" id="spouse_nic_no" placeholder="Enter Spouse NIC No" value="<?php echo $spouse_nic_no; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="spouse_gender">Gender:</label>
                    <div class="col-sm-10">
                      <select class="form-control short" name="spouse_gender" id="spouse_gender">
                        <option value="M" <?php echo ($spouse_gender == "M") ? "selected" :"";?>>Male</option>
                        <option value="F" <?php echo ($spouse_gender == "F") ? "selected" :"";?>>Female</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="spouse_dob">DoB:</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control short" name="spouse_dob" id="spouse_dob" value="<?php echo $spouse_dob; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="spouse_highest_edu_level">Education Level:</label>
                    <div class="col-sm-10">
                      <select class="form-control short" name="spouse_highest_edu_level" id="spouse_highest_edu_level">
                        <option value="Ordinary Level School" <?php echo ($spouse_highest_edu_level == "Ordinary Level School") ? "selected" :"";?>>Ordinary Level School</option>
                        <option value="Advance Level School" <?php echo ($spouse_highest_edu_level == "Advance Level School") ? "selected" :"";?>>Advance Level School</option>
                        <option value="Higher Education Diploma" <?php echo ($spouse_highest_edu_level == "Higher Education Diploma") ? "selected" :"";?>>Higher Education Diploma</option>
                        <option value="University Degree" <?php echo ($spouse_highest_edu_level == "University Degree") ? "selected" :"";?>>University Degree</option>
                        <option value="Master's Degree" <?php echo ($spouse_highest_edu_level == "Master's Degree") ? "selected" :"";?>>Master's Degree</option>
                        <option value="Doctorate" <?php echo ($spouse_highest_edu_level == "Doctorate") ? "selected" :"";?>>Doctorate</option>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="spouse_is_fulltime_employee"></label>
                    <div class="col-sm-10">
                        <input name="spouse_is_fulltime_employee" id="spouse_is_fulltime_employee" type="checkbox" <?php echo ($spouse_is_fulltime_employee == "Y") ? "checked" :"";?>/>
                        <label for="chk_spouse_is_fulltime_employee">Fulltime Employee</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="spouse_is_parttime_emaployee"></label>
                    <div class="col-sm-10">
                        <input name="spouse_is_parttime_emaployee" id="spouse_is_parttime_emaployee" type="checkbox" <?php echo ($spouse_is_parttime_emaployee == "Y") ? "checked" :"";?>/>
                        <label for="chk_spouse_is_parttime_emaployee">Part time Employee</label>
                    </div>
                  </div>
              </div>
              </div>
          </div>
          
          <div class="panel-group">
             <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" href="#dependant">Dependant Details</a>
                    </h4>
                  </div>
                  <div id="dependant" class="panel-collapse collapse" style="padding-top: 10px;">
                  <?php
                    //start permit table
                    if($data_dependats == "")
                    {
                  ?> 
                    <table id="tbl_dependant" class="info_table">
                        <thead>
                          <tr>
                            <th style="display: none;"></th>
                            <th>Name</th>
                            <th>NIC</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td style="display: none;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><button class="view_dependant" type="button">select</button></td>
                          </tr>
                        </tbody>
                    </table>
                  <?php
                    }
                    else
                    {
                  ?>
                    <table id="tbl_dependant" class="info_table">
                        <thead>
                          <tr>
                            <th style="display: none;"></th>
                            <th>Name</th>
                            <th>NIC</th>
                            <th>Gender</th>
                            <th>Date of Birth</th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            foreach ($data_dependats as $dt) {
                          ?>
                          <tr>
                            <td style="display: none;"><?php echo $dt->id; ?></td>
                            <td><?php echo $dt->name; ?></td>
                            <td><?php echo $dt->nic_no; ?></td>
                            <td><?php echo $dt->gender; ?></td>
                            <td><?php echo $dt->date_of_birth; ?></td>
                            <td><button class="view_dependant" type="button">select</button></td>
                          </tr>
                          <?php 
                            }
                          ?>
                        </tbody>
                    </table>
                  <?php
                    }
                  ?>
                  
                  <fieldset>
                    <legend>Add/Edit Dependant:</legend>
                    <div class="form-group" style="display: none;">
                        <label class="control-label col-sm-2" for="txt_dependant_id">dependant ID:</label>
                        <div class="col-sm-10">
                          <input type="text" disabled="true" class="form-control" name="txt_dependant_id" id="txt_dependant_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="txt_dependant_name">Name:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="txt_dependant_name" id="txt_dependant_name" placeholder="Enter Dependant Name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="txt_dependant_nic_no">NIC No:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="txt_dependant_nic_no" id="txt_dependant_nic_no" placeholder="Enter NIC Number">
                        </div>
                    </div> 
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cmb_dependant_gender">Gender:</label>
                        <div class="col-sm-10">
                          <select class="form-control short" name="cmb_dependant_gender" id="cmb_dependant_gender">
                            <option value="M" <?php echo ($spouse_gender == "M") ? "selected" :"";?>>Male</option>
                            <option value="F" <?php echo ($spouse_gender == "F") ? "selected" :"";?>>Female</option>
                          </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="dtp_dependant_dob">DoB:</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control short" name="dtp_dependant_dob" id="dtp_dependant_dob" value="<?php echo $spouse_dob; ?>">
                        </div>
                    </div>
                    <div class="form-group">
                    <label class="control-label col-sm-2" for="cmb_dependant_highest_edu_level">Education Level:</label>
                        <div class="col-sm-10">
                          <select class="form-control short" name="cmb_dependant_highest_edu_level" id="cmb_dependant_highest_edu_level">
                            <option value="Ordinary Level School" <?php echo ($spouse_highest_edu_level == "Ordinary Level School") ? "selected" :"";?>>Ordinary Level School</option>
                            <option value="Advance Level School" <?php echo ($spouse_highest_edu_level == "Advance Level School") ? "selected" :"";?>>Advance Level School</option>
                            <option value="Higher Education Diploma" <?php echo ($spouse_highest_edu_level == "Higher Education Diploma") ? "selected" :"";?>>Higher Education Diploma</option>
                            <option value="University Degree" <?php echo ($spouse_highest_edu_level == "University Degree") ? "selected" :"";?>>University Degree</option>
                            <option value="Master's Degree" <?php echo ($spouse_highest_edu_level == "Master's Degree") ? "selected" :"";?>>Master's Degree</option>
                            <option value="Doctorate" <?php echo ($spouse_highest_edu_level == "Doctorate") ? "selected" :"";?>>Doctorate</option>
                          </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="chk_dependant_is_fulltime_employee"></label>
                        <div class="col-sm-10">
                            <input name="chk_dependant_is_fulltime_employee" id="chk_dependant_is_fulltime_employee" type="checkbox"/>
                            <label for="chk_dependant_is_fulltime_employee">Fulltime Employee</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="chk_dependant_is_parttime_emaployee"></label>
                        <div class="col-sm-10">
                            <input name="chk_dependant_is_parttime_emaployee" id="chk_dependant_is_parttime_emaployee" type="checkbox"/>
                            <label for="chk_dependant_is_parttime_emaployee">Part time Employee</label>
                        </div>
                    </div> 
                    <div class="form-group">
                        <div class="col-sm-10">
                            <button id="btn_add_dependant" class="btn-primary btn-sm fa" type="button">Add another</button>
                            <button id="btn_save_dependant" class="btn-primary btn-sm fa" type="button" style="display: none;">Save dependant</button>
                        </div>
                    </div>
                </fieldset> 
              </div>
            </div>
          </div>
              
          <div class="panel-group">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                      <a data-toggle="collapse" href="#permit">Permit Details</a>
                    </h4>
                  </div>
                  <div id="permit" class="panel-collapse collapse">
                    <?php
                        //start permit table
                        if($data_permits == "")
                        {
                    ?>        
                        <div class="col-sm-12" id="permit_list">
                            <table id="tbl_permit" class="table table-hover">
                                <thead>
                                    <th style="display: none;"></th>
                                    <th style="display: none;"></th>
                                    <th style="display: none;"></th>
                                    <th style="display: none;"></th>
                                    <th style="display: none;"></th>
                                    <th style="display: none;"></th>
                                    <th>Crop</th>
                                    <th>Permit #</th>
                                    <th>Land Name</th>
                                    <th>Plot #</th>
                                    <th>Init Size</th>
                                    <th>Actual Size</th>
                                    <th>District</th>
                                    <th>Ti Range</th>
                                    <th>DSD</th>
                                    <th>GND</th>
                                    <th></th>
                                </thead>
                                <tbody style="height: auto;">
                                    <tr>
                                        <td style="display: none;"></td>
                                        <td style="display: none;"></td>
                                        <td style="display: none;"></td>
                                        <td style="display: none;"></td>
                                        <td style="display: none;"></td>
                                        <td style="display: none;"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php
                        }
                        else
                        {
                    ?>
                        <div class="col-sm-12" id="permit_list">
                            <table id="tbl_permit" class="table table-hover">
                                <thead>
                                    <th style="display: none;"></th>
                                    <th style="display: none;"></th>
                                    <th style="display: none;"></th>
                                    <th style="display: none;"></th>
                                    <th style="display: none;"></th>
                                    <th style="display: none;"></th>
                                    <th style="display: none;">Crop</th>
                                    <th>Permit #</th>
                                    <th>Land Name</th>
                                    <th>Plot #</th>
                                    <th>Init Size</th>
                                    <th>Actual Size</th>
                                    <th style="display: none;">District</th>
                                    <th>Ti Range</th>
                                    <th>DSD</th>
                                    <th style="display: none;">GND</th>
                                    <th></th>
                                </thead>
                                <tbody style="height: auto;">
                                    <tr>
                                        <td style="display: none;"></td>
                                        <td style="display: none;"></td>
                                        <td style="display: none;"></td>
                                        <td style="display: none;"></td>
                                        <td style="display: none;"></td>
                                        <td style="display: none;"></td>
                                        <td style="display: none;"></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td style="display: none;"></td>
                                        <td></td>
                                        <td></td>
                                        <td style="display: none;"></td>
                                        <td></td>
                                    </tr>
                                    <?php 
                                        foreach ($data_permits as $pmt) {
                                    ?>
                                    <tr>
                                        <td style="display: none;"><?php echo $pmt->id; ?></td>
                                        <td style="display: none;"><?php echo $pmt->crop_id; ?></td>
                                        <td style="display: none;"><?php echo $pmt->district_id; ?></td>
                                        <td style="display: none;"><?php echo $pmt->ti_id; ?></td>
                                        <td style="display: none;"><?php echo $pmt->dsd_id; ?></td>
                                        <td style="display: none;"><?php echo $pmt->gnd_id; ?></td>
                                        <td style="display: none;"><?php echo $pmt->crop_name; ?></td>
                                        <td><?php echo $pmt->permit_no; ?></td>
                                        <td><?php echo $pmt->land_name; ?></td>
                                        <td><?php echo $pmt->plot_no; ?></td>
                                        <td><?php echo $pmt->land_size_init_ha; ?></td>
                                        <td><?php echo $pmt->land_size_act_ha; ?></td>
                                        <td style="display: none;"><?php echo $pmt->district_name; ?></td>
                                        <td><?php echo $pmt->ti_name; ?></td>
                                        <td><?php echo $pmt->dsd_name; ?></td>
                                        <td style="display: none;"><?php echo $pmt->gnd_name; ?></td>
                                        <td><button class="view_this" type="button">select</button></td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    <?php        
                        }
                        //end permit table
                    ?>
                  <fieldset>
                    <legend>Add/Edit Permit:</legend>
                    <div class="form-group" style="display: none;">
                        <label class="control-label col-sm-2" for="txt_permit_id">permit ID:</label>
                        <div class="col-sm-10">
                          <input type="text" disabled="true" class="form-control" id="txt_permit_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="cmb_crop">Crop:</label>
                        <div class="col-sm-10">
                          <select class="selectpicker" data-live-search="true" title="Select Crop" id="cmb_crop" name="cmb_crop" required>
                                <?php
                                    $data_crops = callService("/get_all_crops");
                                    foreach ($data_crops as $crop) {
                                ?>
                                    <option value="<?php echo $crop->id; ?>" <?php echo ($crop->id == 1) ? "selected" :"";?>><?php echo $crop->name; ?></option>
                                <?php
                                    }
                                ?>
                          </select>
                        </div>
                    </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="txt_permit_no">Permit No:</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="txt_permit_no" placeholder="Enter Permit Number">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="txt_land_name">Land Name:</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="txt_land_name" placeholder="Enter Land Name" value="<?php echo $land_name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="txt_plot_no">Plot No:</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control short" id="txt_plot_no" placeholder="Enter Plot No" value="<?php echo $plot_no; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="txt_land_size_init_ha">Land Size Init:</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control short" id="txt_land_size_init_ha" onkeydown="return isNumber(event);"  placeholder="Enter Land Size in ha">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="txt_land_size_act_ha">Land Size Actual:</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control short" id="txt_land_size_act_ha" onkeydown="return isNumber(event);"  placeholder="Enter Actual Land Size in ha">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="cmb_district">District:</label>
                            <div class="col-sm-3">
                              <select class="selectpicker" data-live-search="true" title="Select District" id="cmb_district">
                                    <?php
                                        $data_district = callService("/get_all_districts?uid=$curr_uid");
                                        foreach ($data_district as $dist) {
                                    ?>
                                        <option value="<?php echo $dist->id; ?>"><?php echo $dist->name; ?></option>
                                    <?php
                                        }
                                    ?>
                              </select>
                            </div>
                            
                            <label class="control-label col-sm-2" for="cmb_dsd">DSD:</label>
                            <div class="col-sm-3">
                              <select class="selectpicker" data-live-search="true" title="Select DSD" id="cmb_dsd">
                              </select>
                            </div>       
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="cmb_ti_range">TI Range:</label>
                            <div class="col-sm-3">
                              <select class="selectpicker" data-live-search="true" title="Select TI Range" id="cmb_ti_range">
                              </select>
                            </div> 
                            
                            <label class="control-label col-sm-2" for="cmb_gnd">GND:</label>
                            <div class="col-sm-3">
                              <select class="selectpicker" data-live-search="true" title="Select GND" id="cmb_gnd">
                              </select>
                            </div>       
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-10">
                                <button id="btn_add_permit" class="btn-primary btn-sm fa" type="button">Add another</button>
                                <button id="btn_save_permit" class="btn-primary btn-sm fa" type="button" style="display: none;">Save permit</button>
                            </div>
                        </div> 
                    </fieldset>
                    </div>
                </div>
            </div>
    </div>