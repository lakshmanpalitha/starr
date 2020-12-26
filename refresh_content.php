<?php
if(!isset($_SESSION))
    session_start();
include_once('link_service.php');
include_once('access.php');

$option = "";
if(isset($_GET['option']))
    $option = $_GET['option'];

if(isset($_POST['option']))
    $option = $_POST['option']; 
$token = "";
if(isset($_GET['token']))
    $token = $_GET['token'];

if(isset($_POST['token']))
    $token = $_POST['token'];

$is_token_valid = 't'; //t for true value f for false value
if($token!="")
    $is_token_valid = validateToken($token);

if($option!="login_user") //user login is allowed without a token
    if($is_token_valid=="f")
        goto invalid_token;

//validate login token
function validateToken($token)
{
    $val = false;
    
    $data = callService("/get_token_validated/" . $token);
    if(!empty($data[0]->token_exists))
        $val = $data[0]->token_exists;
    return $val;
}

?>

<?php
if($option == "login_user")
{ 
    $dataPosted = "";
    if(isset($_GET['u_name']))
    {
        $dataPosted = http_build_query(
            array(
                'u_name' => $_GET['u_name'],
                'p_word' => $_GET['p_word']
            )
        ); 
    }
    if(isset($_POST['u_name']))
    {
        $dataPosted = http_build_query(
            array(
                'u_name' => $_POST['u_name'],
                'p_word' => $_POST['p_word']
            )
        ); 
    }
    
    $data = postService("get_login_user", $dataPosted);
    //$data2 = json_decode($data);
    //$_SESSION['login_user'] = $data2[0]->u_name;
    //echo $data;
    
    $ret_val = array();    
    $dec_data = json_decode($data);
    $object = new Section;
    
    if($dec_data != null) //login success
    {            
        $_SESSION['login_user'] = $dec_data[0]->u_name;
        $_SESSION['curr_uid'] = $dec_data[0]->id;
        $_SESSION['token'] = $dec_data[0]->token;
        $ret_val["status"][] = "1";
        $ret_val["user"][] = $dec_data[0]->u_name;
        $ret_val["token"][] = $dec_data[0]->token;
        
        $curr_uid = $dec_data[0]->id;
        $top_district = callService("/get_user_top_district/$curr_uid");
        $_SESSION['user_district_id'] = $top_district[0]->district_id; //set default district id for user
        
        //set access permitions
        $data = callService("/get_user_access_objs/" . $dec_data[0]->u_name);
        $object = new Section;
        foreach ($data as $item) 
        {
            $section = $item->section_name;
            $auth_obj = $item->auth_obj_name;
            if(!isset($object->$section))
                $object->$section = new AuthObj;
            $object->$section->$auth_obj = $item->value;
        }
        $_SESSION['access_obj']= serialize($object);
        
        echo json_encode($ret_val);
    }
    else //login fail
    {
        if(isset($_SESSION['login_user']))
            unset($_SESSION['login_user']);
        if(isset($_SESSION['access_obj']))
            unset($_SESSION['access_obj']);            
        $ret_val["status"][] = "-1"; 
     }   
      
    $_SESSION['access_obj']= serialize($object);
}
elseif($option == "logout_data")
{
    if(isset($_SESSION['login_user']))
        unset($_SESSION['login_user']);
    if(isset($_SESSION['curr_uid']))
        unset($_SESSION['curr_uid']);
    if(isset($_SESSION['access_obj']))
        unset($_SESSION['access_obj']);
?>
    <a href="" data-toggle="modal" data-target="#loginModal" style="color: white; padding-right: 20px;">Login</a>
<?php   
} //end logout_data
elseif($option == "set_payment_status")
{
    $dataPosted = http_build_query(
        array(
            'id' => $_GET['id'],
            'comment' => $_GET['comment'],
            'status' => $_GET['status']
        )
    ); 
    
    $data = postService("/set_payment_status", $dataPosted);
    echo json_encode($data);
}
elseif($option == "save_benifiter")
{
    //$_POST['data']['curr_uid'] = $curr_uid;
    $dataPosted = http_build_query(
        array(
            'data' => $_POST['data'],
            'session' => $sessionData
        )
    ); 
    //$dataPosted['data']['curr_uid'] = $curr_uid;
    //$myarray = array_push_assoc($dataPosted, 'curr_uid', 'hello');
    $data = postService("/save_benifiter", $dataPosted);
    
    echo json_encode($data);   
}
elseif($option == "save_permit")
{                                      
    $dataPosted = http_build_query(
        array(
            'benifiter_id' => $_GET['benifiter_id'],
            'id' => $_GET['id'],
            'crop_id' => $_GET['crop_id'],
            'permit_no' => $_GET['permit_no'],
            'land_name' => $_GET['land_name'],
            'plot_no' => $_GET['plot_no'],
            'land_size_init_ha' => $_GET['land_size_init_ha'],
            'land_size_act_ha' => $_GET['land_size_act_ha'],
            'district_id' => $_GET['district_id'],
            'ti_id' => $_GET['ti_id'],
            'dsd_id' => $_GET['dsd_id'],
            'gnd_id' => $_GET['gnd_id']
        )
    ); 
    
    $data = postService("/save_permit", $dataPosted);
    
    echo json_encode($data);   
}
elseif($option == "save_payment")
{ 
    $dataPosted = http_build_query(
        array(
            'data' => $_POST['data']
        )
    ); 
    
    $data = postService("/save_payment", $dataPosted);
    echo json_encode($data);   
}
elseif($option == "save_society")
{
    $dataPosted = http_build_query(
        array(
            'data' => $_POST['data'],
            'session' => $sessionData
        )
    );
    $data = postService("/save_society", $dataPosted);
    
    echo json_encode($data);   
}
elseif($option == "save_factory")
{
    $dataPosted = http_build_query(
        array(
            'data' => $_POST['data'],
            'session' => $sessionData
        )
    );
    $data = postService("/save_factory", $dataPosted);
    
    echo json_encode($data);   
}
elseif($option == "save_role")
{
    $dataPosted = http_build_query(
        array(
            'data' => $_POST['data'],
            'session' => $sessionData
        )
    );
    $data = postService("/save_role", $dataPosted);
    
    echo json_encode($data);   
}
elseif($option == "save_user")
{
    $dataPosted = http_build_query(
        array(
            'data' => $_POST['data'],
            'session' => $sessionData
        )
    );
    $data = postService("/save_user", $dataPosted);
    
    echo json_encode($data);   
}
elseif($option == "save_training")
{
    $dataPosted = http_build_query(
        array(
            'data' => $_POST['data'],
            'session' => $sessionData
        )
    );
    $data = postService("/save_training", $dataPosted);
    
    echo json_encode($data);   
}
elseif($option == "save_machine_grant_base")
{
    $dataPosted = http_build_query(
        array(
            'data' => $_POST['data'],
            'session' => $sessionData
        )
    );
    $data = postService("/save_machine_grant_base", $dataPosted);
    
    echo json_encode($data);   
}
elseif($option == "get_machine_grant_by_district")
{ 
    $data = callService("/get_machine_grant_by_district/" . $_GET['district_id']);
    
    echo json_encode($data);
}
elseif($option == "get_machine_grant_by_id")
{ 
    $data = callService("/get_machine_grant_by_id/" . $_GET['id']);
    
    echo json_encode($data);
}
elseif($option == "get_auth_object_by_section")
{ 
    $data = callService("/get_auth_object_by_section/" . $_GET['sec_id']);
    
    echo json_encode($data);
}
elseif($option == "get_society_by_district")
{ 
    $data = callService("/get_society_by_district/" . $_GET['district_id']);
    
    echo json_encode($data);
}
elseif($option == "get_dsd_by_district")
{ 
    $data = callService("/get_dsd_by_district/" . $_GET['district_id']);
    
    echo json_encode($data);
}
elseif($option == "get_ti_by_district")
{ 
    $data = callService("/get_ti_by_district/" . $_GET['district_id']);
    
    echo json_encode($data);
}
elseif($option == "get_gnd_by_dsd")
{ 
    $data = callService("/get_gnd_by_dsd/" . $_GET['dsd_id']);
    
    echo json_encode($data);
}
elseif($option == "get_pay_types_for_benifiter")
{ 
    $benifiter_id = $_GET['benifiter_id'];
    $permit_no = $_GET['permit_no'];
    $crop_id = $_GET['crop_id'];
    $data = callService("/get_pay_types_for_benifiter/$benifiter_id?permit_no=$permit_no&crop_id=$crop_id");
    
    echo json_encode($data);
}
elseif($option == "list_payement_types")
{
    $data = callService("/get_all_pay_types");
?>
    <table class="table table-hover">
        <thead>
          <tr>
            <th style="width: 20%;">Type</th>
            <th style="width: 20%;">Description</th>
            <th>Rate (Rs/ha)</th>
            <th>Crop</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php
            foreach ($data as $row) {
        ?>
            <tr>
                <td style="width: 20%;"><?php echo $row->name; ?></td>
                <td style="width: 20%;"><?php echo $row->description; ?></td>
                <td><?php echo $row->rate_per_ha; ?></td>
                <td><?php echo $row->crop; ?></td>
                <td><button type="button" id="<?php echo "edit_" . $row->id; ?>" class="btn btn-primary btn-xs edit"  data-toggle="modal" data-target="#editModal">Edit</button></td>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table> 
<?php   
} //end list_payement_types        

elseif($option == "list_benifiter_payments")
{
    $benifiter_id = (isset($_GET['benifiter_id']) ? pg_escape_string($_GET['benifiter_id']) : null);
    $permit_no = (isset($_GET['permit_no']) ? pg_escape_string($_GET['permit_no']) : null);
?>
    <table class="table table-hover" id="prev_payment_tbl">
        <thead>
          <tr>
            <th>Type</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Comment</th>
            <th></th>
          </tr>
        </thead>
        <tbody style="max-height: 150px;">
            <?php
                $data_pay = callService("/get_payments_by_benifiter/$benifiter_id?permit_no=$permit_no");
                foreach ($data_pay as $pay) {
            ?>
                <tr>
                    <td><?php echo $pay->payment_type; ?></td>
                    <td><?php echo $pay->amount; ?></td>
                    <td><?php echo $pay->pay_date; ?></td>
                    <td><?php echo $pay->comment; ?></td>
                    <?php
                        if ($pay === end($data_pay)) { //show revert button
                        ?>
                            <td><button type="button" id="<?php echo "rev_" . $pay->id; ?>" class="btn btn-primary btn-xs revert"  data-toggle="collapse" data-target="#revert_comment">Revert</button></td>
                        <?php
                        }
                    ?>
                </tr>
                
                <?php
                    if ($pay === end($data_pay)) { //show revert comment
                    ?>
                        <tr id="revert_comment" class="collapse"><td colspan = "3"><textarea id="txtRevComment"></textarea></td></div> <td></td> <td></td> <td><button id="<?php echo "revert_" . $pay->id; ?>" type="button" class="btn btn-default save_revert">save</button></td></tr>
                    <?php
                    }
                ?>
                    
            <?php
                }
            ?>
        </tbody> 
      </table>
<?php   
} //end list_benifiter_payments  
elseif($option == "list_society")
{
    $section = 'society';
    $view_ok = false;
    $data = array();
    if(isset($_SESSION['access_obj']))
    {
        $section_access = getSectionAccess($section);
    
        if(isset($section_access->view))
            $view_ok = ($section_access->view=='Y' ? true : false);
    }
    if($view_ok)
    {
        $curr_uid = (isset($_SESSION['curr_uid']) ? $_SESSION['curr_uid'] : null);
        $data = callService("/get_all_society?uid=$curr_uid");
    }
?>
    <table class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Contact No</th>
            <th>Males</th>
            <th>Females</th>
            <th>District</th>
            <th>DSD</th>
            <th>GND</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php
            foreach ($data as $row) {
        ?>
            <tr>
                <td><?php echo $row->name; ?></td>
                <td><?php echo $row->contact_no; ?></td>
                <td><?php echo $row->num_of_male; ?></td>
                <td><?php echo $row->num_of_female; ?></td>
                <td><?php echo $row->district; ?></td>
                <td><?php echo $row->dsd; ?></td>
                <td><?php echo $row->gnd; ?></td>
                <td><button type="button" id="<?php echo "edit_" . $row->id; ?>" class="btn btn-primary btn-xs edit"  data-toggle="modal" data-target="#editModal">Edit</button></td>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
<?php   
} //end list_society
elseif($option == "list_benifiter")
{
    $section = 'benefiter';
    $view_ok = false;
    $edit_ok = false;
    $payment_ok = false;
    $data = array();
    if(isset($_SESSION['access_obj']))
    {
        $section_access = getSectionAccess($section);
    
        if(isset($section_access->view))
            $view_ok = ($section_access->view=='Y' ? true : false);
        if(isset($section_access->edit))
            $edit_ok = ($section_access->edit=='Y' ? true : false);
        if(isset($section_access->payment))
            $payment_ok = ($section_access->payment=='Y' ? true : false);
    }
    if($view_ok)
    {
        $curr_uid = (isset($_SESSION['curr_uid']) ? $_SESSION['curr_uid'] : null);
        $data = callService("/get_all_benifiters?uid=$curr_uid");
    }
?>
    <table class="table table-hover" id="tbl_benifiter">
        <thead>
          <tr>
            <th style="width: 20%;">Name</th>
            <th>NIC</th>
            <th>Gender</th>
            <th>Year</th>
            <th>District</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php
            foreach ($data as $row) {
        ?>
            <tr>
                <td style="width: 20%;"><?php echo $row->name; ?></td>
                <td><?php echo $row->nic_no; ?></td>
                <td><?php echo $row->gender; ?></td>
                <td><?php echo $row->year; ?></td>
                <td><?php echo $row->district_name; ?></td>
                <?php if($edit_ok){ ?>
                    <td><button type="button" id="<?php echo "edit_" . $row->id; ?>" class="btn btn-primary btn-xs edit"  data-toggle="modal" data-target="#editModal" data-backdrop="static">Edit</button></td>
                <?php } ?>
                <?php if($payment_ok){ ?>
                    <td><button type="button" id="<?php echo "pay_" . $row->id; ?>" class="btn btn-primary btn-xs pay"  data-toggle="modal" data-target="#payModal" data-backdrop="static">Pay</button></td>
                <?php } ?>
            </tr>
        <?php
            }
        ?>
        </tbody>
      </table>
<?php   
} //end list_benifiter 
elseif($option == "list_factory")
{
    $data = callService("/get_all_factory");
?>
    <table class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Address</th>
            <th>Contact No</th>
            <th>Daily Col</th>
            <th>Monthly Col</th>
            <th>District</th>
            <th>DSD</th>
            <th>GND</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php
            foreach ($data as $row) {
        ?>
            <tr>
                <td><?php echo $row->name; ?></td>
                <td><?php echo $row->address; ?></td>
                <td><?php echo $row->contact_no; ?></td>
                <td><?php echo $row->daily_collection; ?></td>
                <td><?php echo $row->monthly_collection; ?></td>
                <td><?php echo $row->district; ?></td>
                <td><?php echo $row->dsd; ?></td>
                <td><?php echo $row->gnd; ?></td>
                <td><button type="button" id="<?php echo "edit_" . $row->id; ?>" class="btn btn-primary btn-xs edit"  data-toggle="modal" data-target="#editModal">Edit</button></td>
            </tr>
        <?php
            }
        ?>
        </tbody>
      </table>
<?php   
} //end list_society
elseif($option == "list_training")
{
    $data = callService("/get_all_training");
?>
    <table class="table table-hover">
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
<?php   
} //end list_nursery
elseif($option == "list_nursery")
{
    $data = callService("/get_all_nursery");
?>
    <table class="table table-hover">
        <thead>
          <tr>
            <th>Name</th>
            <th>Address</th>
            <th>Contact No</th>
            <th>Owner</th>
            <th>Reg No</th>
            <th>Society</th>
            <th>District</th>
            <th>DSD</th>
            <th>GND</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php
            foreach ($data as $row) {
        ?>
            <tr>
                <td><?php echo $row->name; ?></td>
                <td><?php echo $row->address; ?></td>
                <td><?php echo $row->contact_no; ?></td>
                <td><?php echo $row->owner_name; ?></td>
                <td><?php echo $row->reg_no; ?></td>
                <td><?php echo $row->society_name; ?></td>
                <td><?php echo $row->district; ?></td>
                <td><?php echo $row->dsd; ?></td>
                <td><?php echo $row->gnd; ?></td>
                <td><button type="button" id="<?php echo "edit_" . $row->id; ?>" class="btn btn-primary btn-xs edit"  data-toggle="modal" data-target="#editModal">Edit</button></td>
            </tr>
        <?php
            }
        ?>
        </tbody>
      </table>
<?php   
} //end list_nursery
elseif($option == "login_data")
{
    $user = "";
    if(isset($_GET['user']))
        $user = $_GET['user'];
?>
    Welcome <?php echo $user; ?> | <a class="logout" href="" style="color: white; padding-right: 20px; cursor: pointer;">Logout</a>
<?php   
} //end login_data
elseif($option == "list_user")
{
    $section = "system";
    $authorizations = "";
    $view_ok = false;
    $roles_ok = false;
    $users_ok = false;
     
    if(isset($_SESSION['access_obj']))
    {
        $section_access = getSectionAccess($section);
    
        if(isset($section_access->view))
            $view_ok = ($section_access->view=='Y' ? true : false);
        if(isset($section_access->manage_roles))
            $roles_ok = ($section_access->manage_roles=='Y' ? true : false);
        if(isset($section_access->manage_users))
            $users_ok = ($section_access->manage_users=='Y' ? true : false);
    }
    else
        exit(header("Location: login.php?redirect_to=sys_admin.php"));
        
    $user_data = null;
    $role_data = null;
    if($view_ok)
    {
        $user_data = callService("/get_all_users");
        $role_data = callService("/get_all_roles");
    }
?>
    <table class="table table-hover">
        <thead>
          <tr>
            <th style="width: 20%;">User</th>
            <th style="width: 25%;">Roles</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php
            foreach ($user_data as $row) {
        ?>
            <tr>
                <td style="width: 20%;"><?php echo $row->u_name; ?></td>
                <td style="width: 25%;"><?php echo $row->roles; ?></td>
                <td><button type="button" id="<?php echo "edit_user_" . $row->id; ?>" class="btn btn-primary btn-xs edit_user_"  data-toggle="modal" data-target="#editUserModal">Edit</button></td>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
<?php   
} //end list_user
elseif($option == "list_role")
{
    $section = "system";
    $authorizations = "";
    $view_ok = false;
    $roles_ok = false;
    $users_ok = false;
     
    if(isset($_SESSION['access_obj']))
    {
        $section_access = getSectionAccess($section);
    
        if(isset($section_access->view))
            $view_ok = ($section_access->view=='Y' ? true : false);
        if(isset($section_access->manage_roles))
            $roles_ok = ($section_access->manage_roles=='Y' ? true : false);
        if(isset($section_access->manage_users))
            $users_ok = ($section_access->manage_users=='Y' ? true : false);
    }
    else
        exit(header("Location: login.php?redirect_to=sys_admin.php"));
        
    $user_data = null;
    $role_data = null;
    if($view_ok)
    {
        $user_data = callService("/get_all_users");
        $role_data = callService("/get_all_roles");
    }
?>
    <table class="table table-hover">
        <thead>
          <tr>
            <th style="width: 20%;">Role</th>
            <th style="width: 25%;">Sections</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php
            foreach ($role_data as $row) {
        ?>
            <tr>
                <td style="width: 20%;"><?php echo $row->name; ?></td>
                <td style="width: 25%;"><?php echo $row->sections; ?></td>
                <td><button type="button" id="<?php echo "edit_role_" . $row->id; ?>" class="btn btn-primary btn-xs edit_role_"  data-toggle="modal" data-target="#editRoleModal">Edit</button></td>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
<?php   
} //end list_role
//start list_permit data by benifiter
elseif($option == "list_permit")
{
    $benifiter_id = "";
    if(isset($_GET['benifiter_id']))
    {    
        $benifiter_id = $_GET['benifiter_id'];
    }
    $data_permits =  callService("/get_permits_by_benifiter/$benifiter_id");
?>
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
<?php   
} //end list_permit_data
//start filter benifiter
elseif($option == "list_filter_benifiter")
{
    $qry_str = "";
    if(isset($_GET['dist_id']))
    {    
        $dist_id = $_GET['dist_id'];
        if($dist_id != "")
        {
            if($qry_str == "")
                $qry_str .= "?dist_id=$dist_id";
            else
                $qry_str .= "&dist_id=$dist_id";
        }
    }
    if(isset($_GET['society_id']))
    {    
        $society_id = $_GET['society_id'];
        if($society_id != "")
        {
            if($qry_str == "")
                $qry_str .= "?society_id=$society_id";
            else
                $qry_str .= "&society_id=$society_id";
        }
    }
    if(isset($_GET['year']))
    {    
        $year = $_GET['year'];
        if($year != "")
        {
            if($qry_str == "")
                $qry_str .= "?year=$year";
            else
                $qry_str .= "&year=$year";
        }
    }
    
    $section = "benefiter";
    
    $view_ok = GetSectionAccessAuth($section, 'view');
    $new_ok = GetSectionAccessAuth($section, 'new');
    $edit_ok = GetSectionAccessAuth($section, 'edit');
    $payment_ok = GetSectionAccessAuth($section, 'payment');
    
    $benifiter_data = "";
    if($view_ok)
    {
        $benifiter_data = callService("/get_all_benifiters$qry_str");
    }
?>
    <table class="table table-hover" id="tbl_benifiter">
        <thead>
          <tr>
            <th style="width: 20%;">Name</th>
            <th>NIC</th>
            <th>Gender</th>
            <th>Year</th>
            <th>District</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
        <?php
            
            foreach ($benifiter_data as $row) {
        ?>
            <tr>
                <td style="width: 20%;"><?php echo $row->name; ?></td>
                <td><?php echo $row->nic_no; ?></td>
                <td><?php echo $row->gender; ?></td>
                <td><?php echo $row->year; ?></td>
                <td><?php echo $row->district_name; ?></td>
                <?php if($edit_ok){ ?>
                    <td><button type="button" id="<?php echo "edit_" . $row->id; ?>" class="btn btn-primary btn-xs edit"  data-toggle="modal" data-target="#editModal" data-backdrop="static">Edit</button></td>
                <?php } ?>
                <?php if($payment_ok){ ?>
                    <td><button type="button" id="<?php echo "pay_" . $row->id; ?>" class="btn btn-primary btn-xs pay"  data-toggle="modal" data-target="#payModal" data-backdrop="static">Pay</button></td>
                <?php } ?>
            </tr>
        <?php
            }
        ?>
        </tbody>
    </table>
<?php   
} //end filter_benifiter
elseif($option == "report")
{
    $rpt_name = "";
    if(isset($_GET['name']))
        $rpt_name = $_GET['name'];
    
    $year = "";
    if(isset($_GET['year']))
        $year = $_GET['year'];
        
    $dist_id = 0;
    if(isset($_GET['dist_id']))
        $dist_id = $_GET['dist_id'];
    
    try {
        /*
        $d = new Client(
            "http://localhost:8080/jasperserver",
            "jasperadmin",
            "jasperadmin",
            ""
        );
        */
        $parameters = array();
        
        if($rpt_name != "")
        {
            if($rpt_name == "Society Details")
            {
                echo "<iframe width='1000' height='750' src='https://datastudio.google.com/embed/reporting/38399500-b15b-4a36-b6ba-496838561dbe/page/N0uWB' frameborder='0' style=''border:0' allowfullscreen></iframe>";
            }
            if($year > 0)
            {
                $parameters["where_stmt"] = "where b.year=$year";
                if($dist_id>0)
                    $parameters["where_stmt"] = "where b.year=$year and b.district_id=$dist_id";
            }
            else
                $parameters["where_stmt"] = "";
        }
        
        //echo $d->reportService()->runReport('/Starr_Reports/starr_test1', 'html');
        //$report = $d->reportService()->runReport('/st_reports/benifiter_detail', 'html', null, null, $parameters);
        //$info = $d->serverInfo();
    
    } catch (RESTRequestException $e) {
        echo 'RESTRequestException:';
        echo 'Exception message:   ',  $e->getMessage(), "\n";
        echo 'Set parameters:      ',  $e->parameters, "\n";
        echo 'Expected status code:',  $e->expectedStatusCodes, "\n";
        echo 'Error code:          ',  $e->errorCode, "\n";
    } 
        
?>
    <div>
        <?php //echo $report; ?>
    </div>
<?php   
} //end report
?>

<?php
invalid_token:
    if($is_token_valid == "f")    
        echo json_encode("invalid token");
?>