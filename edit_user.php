<?php
include('link_service.php');
$id = 0;
$u_name = "";
$p_word = "";
$u_roles = array();

if(isset($_GET['id']))
    $id = $_GET['id'];

if($id > 0)    
{
    $data = callService("/get_user_by_id/$id");
    
    $row = $data[0];
    $u_name = $row->u_name;
    $p_word = $row->p_word;
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
            <label class="control-label col-sm-2" for="txt_u_name">Username:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_u_name" placeholder="Enter username" value="<?php echo $u_name; ?>" required>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="txt_p_word">Password:</label>
            <div class="col-sm-10">
              <input type="password" class="form-control" id="txt_p_word" placeholder="Enter password" value="<?php echo $p_word; ?>">
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="cmbRoles">Roles:</label>
            <div class="col-sm-10">
              <select class="selectpicker" multiple  data-actions-box="true" title="Choose acess roles" id="cmbRoles">
                <?php
                    $all_role_data = callService("/get_all_roles"); 
                    
                    $user_role_data = callService("/get_user_roles/$id");
                    $flat_arr = json_decode(json_encode($user_role_data), TRUE);
                    
                    foreach ($all_role_data as $row) {
                        $selected = "";
                        if(in_array($row->id, array_column($flat_arr, 'sys_role_id'))) {
                            $selected = "selected";
                        }
                ?>
                    <option value="<?php echo $row->id; ?>" <?php echo $selected; ?>><?php echo $row->name; ?></option>
                <?php
                    }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="cmbDistricts">District:</label>
            <div class="col-sm-10">
              <select class="selectpicker" multiple  data-actions-box="true" title="Choose district" id="cmbDistricts">
                <?php
                    $all_dist_data = callService("/get_all_districts"); 
                    
                    $user_dist_data = callService("/get_user_districts/$id");
                    $flat_arr = json_decode(json_encode($user_dist_data), TRUE);  
                    
                    foreach ($all_dist_data as $row) {
                        $selected = "";
                        if(in_array($row->id, array_column($flat_arr, 'district_id'))) {
                            $selected = "selected";
                        }
                ?>
                    <option value="<?php echo $row->id; ?>" <?php echo $selected; ?>><?php echo $row->name; ?></option>
                <?php
                    }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="control-label col-sm-2" for="cmbCrops">Crops:</label>
            <div class="col-sm-10">
              <select class="selectpicker" multiple title="Choose crop" id="cmbCrops">
                <?php
                    $all_crop_data = callService("/get_all_crops"); 
                    
                    $user_crop_data = callService("/get_user_crops/$id");
                    $flat_arr = json_decode(json_encode($user_crop_data), TRUE);  
                    
                    foreach ($all_crop_data as $row) {
                        $selected = "";
                        if(in_array($row->id, array_column($flat_arr, 'crop_id'))) {
                            $selected = "selected";
                        }
                ?>
                    <option value="<?php echo $row->id; ?>" <?php echo $selected; ?>><?php echo $row->name; ?></option>
                <?php
                    }
                ?>
              </select>
            </div>
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