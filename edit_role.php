<?php
include('link_service.php');
$id = 0;
$name = "";
$role_sec_data = array();

if(isset($_GET['id']))
    $id = $_GET['id'];

if($id > 0)    
{
    $data = callService("/get_role_by_id/$id");
    
    $row = $data[0];
    $name = $row->name;
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
            <label class="control-label col-sm-2" for="txt_role_name">Role Name:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="txt_role_name" placeholder="Enter role name" value="<?php echo $name; ?>" required>
            </div>
          </div>
          
          <fieldset>
            <legend>Access Levels:</legend>
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4"><label for="cmb_sections_avail">Available Sections:</label></div>
                    <div class="col-lg-2"></div>
                    <div class="col-lg-4"><label for="cmb_sections_avail">Added Sections:</label></div>
                    <div class="col-lg-1"></div>
                </div>
                <!-- List Available Sections and Added Sections -->
                <div class="row">
                    <div class="col-lg-1"></div>
                    <div class="col-lg-4">
                        <select id="cmb_sections_avail" name="selValue" class="form-control"  style="min-height: 150px;" multiple>
                               <?php
                                    $all_sec_data = callService("/get_all_sections"); 
                                    
                                    $role_sec_data = callService("/get_sections_by_role/$id");
                                    $flat_arr = json_decode(json_encode($role_sec_data), TRUE);  
                                    var_dump($flat_arr);
                                    foreach ($all_sec_data as $row) {
                                        $selected = "";
                                        if(in_array($row->id, array_column($flat_arr, 'section_id'))) {
                                            $selected = "selected";
                                        }
                                        else //set avilable sections
                                        {
                               ?>
                                            <option value="<?php echo $row->id; ?>"><?php echo $row->name; ?></option>
                               <?php
                                        }
                                    }
                               ?>
                        </select>
                    </div>
                    <div class="col-lg-1">
                        <button id="add_section" class="btn btn-primary btn-sm">></button>    
                    </div>
                    <div class="col-lg-5">
                        <table id="added_sections" class="table table-hover">
                            <tbody style="max-height: 150px;">
                            <?php
                                $role_sec_data_separate = callService("/get_sections_by_role_separate/$id");
                                foreach ($role_sec_data_separate as $row) {
                                    if($row->section_id > 0)
                                    {
                            ?>
                                    <tr id="row_<?php echo $row->section_id; ?>"><td class="section_td"><?php echo $row->section_name; ?></td><td class="section_td"><button id="rem_sec_<?php echo $row->section_id; ?>" class="btn btn-primary btn-xs rem_sec" >Remove</button></td></tr>
                            <?php        
                                    }
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-1"></div>
                </div>
                <!-- List Auth Objects -->
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <table id="auth_objects" class="table table-hover">
                            <tbody style="max-height: 150px;">
                            <?php
                                $section = "";
                                $role_auth_data = callService("/get_auth_object_by_role/$id");
                                foreach ($role_auth_data as $row) {
                                    if($section != $row->section_name)
                                    {
                                        $section = $row->section_name;
                            ?>
                                <tr id="sec_<?php echo $row->section_id; ?>" style="background-color: #DDF1F8;"><td colspan="2"><?php echo $row->section_name; ?></td></tr>
                            <?php
                                    }
                                    $checked = "";
                                    if($row->value == "Y")
                                        $checked = "checked=\"checked\"";
                                    else
                                        $checked = "";
                                        
                                    if($row->section_id > 0)
                                    {
                            ?>
                                    <tr id="row_<?php echo $row->section_id . "_" . $row->auth_id; ?>"><td class="section_td"><?php echo $row->auth_name; ?></td> <td class="section_td"><label><input type="checkbox" id="chk_<?php echo $row->section_id . "_" . $row->auth_id; ?>" value="Y" <?php echo $checked; ?>></label></td></tr>
                            <?php 
                                    }       
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-lg-3"></div>
                </div>
            </div>
          </fieldset>
    </div>
          
    <div class="modal-footer">
        <div style="clear: both;">
          <div id="message" style="float: left; text-align: left;"></div>
          <div style="float: right;">
              <button id="btn_save_role" type="submit" class="btn btn-default">Save</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
    </div>
    
    <script>
    
    </script>