<?php
include('link_service.php');
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
$daily_collection = 0;
$monthly_collection = 0;
$daily_production = 0;
$monthly_production = 0;
$collection_source = "";
$collection_method = "";

if(isset($_GET['id']))
    $id = $_GET['id'];

if($id > 0)    
{
    $data = callService("/get_factory_by_id/$id");
    
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
    $daily_collection = $row->daily_collection;
    $monthly_collection = $row->monthly_collection;
    $daily_production = $row->daily_production;
    $monthly_production = $row->monthly_production;
    $collection_source = $row->collection_source;
    $collection_method = $row->collection_method;
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
              <input type="text" class="form-control" name="name" id="name" placeholder="Enter factory name" value="<?php echo $name; ?>" required>
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
            <label class="control-label col-sm-2" for="daily_collection">Daily Collection:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="daily_collection" id="daily_collection" placeholder="Enter daily collection" value="<?php echo $daily_collection; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="monthly_collection">Monthly Collection:</label>
            <div class="col-sm-10">
              <input type="text" name="" class="form-control" name="monthly_collection" id="monthly_collection" placeholder="Enter monthly collection" value="<?php echo $monthly_collection; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="daily_production">Daily Production:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="daily_production" id="daily_production" placeholder="Enter daily production" value="<?php echo $daily_production; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="monthly_production">Monthly Production:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="monthly_production" id="monthly_production" placeholder="Enter monthly production" value="<?php echo $monthly_production; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="collection_source">Collection Source:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="collection_source" id="collection_source" placeholder="Enter collection source" value="<?php echo $collection_source; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="collection_method">Collection Method:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="collection_method" id="collection_method" placeholder="Enter Collection Method" value="<?php echo $collection_method; ?>" >
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="district">District:</label>
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