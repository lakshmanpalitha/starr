<?php
include_once('link_service.php');
    
    $type_id = 0;
    $name = "";
    $description = ""; 
    $rate_per_ha = 0;  
    $crop_id = 0;     
    $previous_payment_id = 0;
        
    if(isset($_GET['type_id']))
        $type_id = $_GET['type_id'];
    
    if($type_id > 0)    
    {
        $data = callService("/get_pay_type_by_id/$type_id");
        
        $row = $data[0];
        $name = $row->name;
        $description = $row->description; 
        $rate_per_ha = $row->rate_per_ha;  
        $crop_id = $row->crop_id;     
        $previous_payment_id = $row->previous_payment_id;
    }
                
?>

    <div id="model_content" class="modal-body">
          <div class="form-group" style="display: none;">
            <label class="control-label col-sm-2" for="txt_fname">ID:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_id" value="<?php echo $type_id; ?>">
            </div>
          </div>
            
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_name">Pay type:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_name" placeholder="Enter pay type" value="<?php echo $name; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_description">Description:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_description" placeholder="Enter description" value="<?php echo $description; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_rate_per_ha">Rate per ha:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_rate_per_ha" placeholder="Enter description" value="<?php echo $rate_per_ha; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="cmb_crop">Crop:</label>
            <div class="col-sm-10">
              <select class="selectpicker" data-live-search="true" title="Select Crop" id="cmb_crop" required>
                    <?php
                        $data_crops = callService("/get_all_crops");
                        foreach ($data_crops as $crop) {
                    ?>
                        <option value="<?php echo $crop->id; ?>" <?php echo ($crop->id == 1 || $crop->id == $crop_id) ? "selected" :"";?>><?php echo $crop->name; ?></option>
                    <?php
                        }
                    ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="cmb_prev_pay_type">Previous Pay Type:</label>
            <div class="col-sm-10">
              <select class="selectpicker" data-live-search="true" title="Select Payment Type" id="cmb_prev_pay_type">
                    <?php if($crop_id > 0)
                    {
                    ?>
                    <option value="0" <?php echo (($type_id == 0) ? "selected" :'');?>>Please select if necessary</option>
                    <?php
                        $data_pre_pt = callService("/get_pay_types_by_crop/$crop_id");
                        foreach ($data_pre_pt as $pt) {
                    ?>
                        <option value="<?php echo $pt->id; ?>" <?php echo (($pt->id == $previous_payment_id && $previous_payment_id!= 0) ? "selected" :'');?>><?php echo $pt->name; ?></option>
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