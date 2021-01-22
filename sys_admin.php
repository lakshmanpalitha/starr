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
      
      <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="row">
                <div class="row">
                    <div class="col-lg-2"> 
                        <ul class="nav nav-pills nav-stacked">
                            <li class="active"><a data-toggle="pill" href="#users">Users</a></li>
                            <li><a data-toggle="pill" href="#roles">Roles</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-10"> 
                        <div class="tab-content">
                            <div id="users" class="tab-pane fade in active">
                                <h4>System Users</h4>
                                <div class="row" style="padding-top: 15px;">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-2"><?php if($users_ok){?> <button id="new_user" class="btn btn-primary btn-xs"  data-toggle="modal" data-target="#editUserModal">New User</button> <?php } ?></div>
                                            <div class="col-lg-10"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12" id="container" style="padding: 25px 0px;">
                                        <div id="user_list">
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
                                                        <td><?php if($users_ok){?> <button type="button" id="<?php echo "edit_user_" . $row->id; ?>" class="btn btn-primary btn-xs edit_user_"  data-toggle="modal" data-target="#editUserModal">Edit</button><?php }?> </td>
                                                    </tr>
                                                <?php
                                                    }
                                                ?>
                                                </tbody>
                                              </table>
                                        </div>
                                    </div>
                                  </div>  
                            </div>
                            <div id="roles" class="tab-pane fade">
                              <h4>Access Roles</h4>
                              <div class="row" style="padding-top: 15px;">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-2"><?php if($roles_ok){?> <button id="new_role" class="btn btn-primary btn-xs"  data-toggle="modal" data-target="#editRoleModal">New Role</button><?php }?> </div>
                                            <div class="col-lg-10"></div>
                                        </div>
                                    </div>
                              </div>
                              <div class="row">
                                    <div class="col-lg-12" id="container" style="padding: 25px 0px;">
                                        <div id="role_list">
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
                                                        <td><?php if($roles_ok){?> <button type="button" id="<?php echo "edit_role_" . $row->id; ?>" class="btn btn-primary btn-xs edit_role_"  data-toggle="modal" data-target="#editRoleModal">Edit</button><?php }?> </td>
                                                    </tr>
                                                <?php
                                                    }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-1"></div>
      </div>
      
      <div class="modal fade" id="editUserModal" role="dialog">
            <div class="modal-dialog">
                <form class="form-horizontal" id="edit_user_form">
                    <!-- Modal content-->
                    <div class="modal-content" style="min-width: 900px;">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">User Details</h4>
                        </div>
                        <div id="model_content" class="modal-body">
                          <p>Some text in the modal.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
       <div class="modal fade" id="editRoleModal" role="dialog">
            <div class="modal-dialog">
                <form class="form-horizontal" id="edit_role_form">
                    <!-- Modal content-->
                    <div class="modal-content" style="min-width: 900px;">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Role Details</h4>
                        </div>
                        <div id="role_model_content" class="modal-body">
                          <p>Some text in the modal.</p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <?php include('footer.php'); ?>
      <script>
        //service_url = "http://localhost/starr/services/index.php";
        //service_url = "http://starr.lk/services/index.php";
        
        $(function() {
            
            $('body').on('click', '.rem_sec', function(e) {
                e.preventDefault();
                var id = this.id;
                
                var sec_id = id.substring(8, id.length);
                var sec_name = "";
                $('#row_' + sec_id).each(function(){  
                    sec_name = $(this).find('td').eq(0).text();
                });
                
                $('#cmb_sections_avail').append($('<option>', {
                    value: sec_id,
                    text: sec_name
                }));
                //remove added sections
                $('#row_' + sec_id).remove();
                
                //remove added auth objects
                $('#auth_objects tr').each(function (i, row) {
                    var array = row.id.split('_');
                    if(array[1] == sec_id)
                        row.remove();
                });
            });
            
            $('body').on('click', '#add_section', function(e) {
                e.preventDefault();
                var valuesArr = new Array();
                var textArr = new Array();
                $("#cmb_sections_avail option:selected").each(function () {
                   var itm = $(this);
                   if (itm.length) {
                    valuesArr.push(itm.val());
                    textArr.push(itm.text());
                   }
                   this.remove();
                });
                
                if(valuesArr != null)
                {
                    var i;
                    for (i = 0; i < textArr.length; ++i) {
                        $('#added_sections tbody').append('<tr id="row_' + valuesArr[i] + '"><td class="section_td">' + textArr[i] +'</td><td class="section_td"><button id="rem_sec_' + valuesArr[i] + '" class="btn btn-primary btn-xs rem_sec" >Remove</button></td></tr>');
                    
                        //add auth objects for given section
                        //var url = service_url + "/get_auth_object_by_section/" + valuesArr[i];
                        $.ajax({
                            type: "GET",
                            url: 'refresh_content.php',
                            data: {option: 'get_auth_object_by_section', sec_id: valuesArr[i]},
                            async: false,
                            dataType: "json",
                            success: function(result)
                                    {
                                        var section_tr = '<tr id="sec_' + valuesArr[i] + '" style="background-color: #DDF1F8;"><td colspan="2">' + textArr[i] + '</td></tr>';
                                        $('#auth_objects tbody').append(section_tr);
                                        
                                        $.each(result, function(index, element) {
                                            //var option = new Option(element.name, element.id);
                                            var tr = '<tr id="row_'+ element.section_id + '_' + element.auth_id +'"><td class="section_td">'+ element.auth_name +'</td> <td class="section_td"><label><input type="checkbox" id="chk_'+ element.section_id + '_' + element.auth_id +'" value="Y"></label></td></tr>'; 
                                            $('#auth_objects tbody').append(tr);
                                        });
                                    },
                            failure: function () {
                                alert("Failed!");
                            }
                        });
                    }
                }
                 
            });
            
            $('body').on('click', '.edit_role_', function() {
                var id = this.id;
                var role_id = id.substring(10, id.length);
                $.ajax({
                    type: "GET",
                    url: "edit_role.php",
                    data: {id: role_id },
                    async: false,
                    dataType: "html",
                    success: function(result)
                            {
                                $("#role_model_content").empty();
    			                $("#role_model_content").html(result);
                                $('.selectpicker').selectpicker({
                                    size: 7
                                });
                            },
                    failure: function () {
                        alert("Failed!");
                    }
                });
            });
            
            $("#new_role").on("click", function () {
                var id = 0;
                $.ajax({
                    type: "GET",
                    url: "edit_role.php",
                    data: {id: id },
                    //contentType: "application/json; charset=utf-8",
                    dataType: "html",
                    success: function(result)
                            {
                                $("#role_model_content").empty();
    			                $("#role_model_content").html(result);
                                $('.selectpicker').selectpicker({
                                    size: 7
                                });
                            },
                    failure: function () {
                        alert("Failed!");
                    }
                });
            });
            
            $("#edit_role_form").submit(function(e) {
                // Grab all values
                var id = $("#txt_id").val();
                var name = $("#txt_role_name").val().trim();
                var auth_id_arr = [];
                var auth_value_arr = [];
                
                var myObj = [];
                
                $('#auth_objects tr').each(function (i, row) {
                    var array = row.id.split('_');
                    if(array.length > 2) //pick rows having auth object id (array 1 element is section_id, arra 2 element is auth_object_id)
                    {   
                        var section_id = array[1];
                        var auth_object_id = array[2];
                        checkbox_name = 'chk_' + section_id + '_' + auth_object_id;
                        var value = "";
                        if($('#' + checkbox_name).is(":checked"))
                            value = 'Y';
                        else
                            value = 'N';
                        myObj.push({"id":auth_object_id, "val":value});
                        //auth_id_arr.push(auth_object_id);
                        //auth_value_arr.push(value); 
                    }
                });
                
                //new_arr.push(auth_id_arr);   
                //new_arr.push(auth_value_arr);              
                var data = {
                    id : id,
                    name : name,
                    auth_value_arr : myObj
                    //auth_id_arr : auth_id_arr
                };
                
                if(name != "")
                {
                    var $inputs = $("#edit_role_form").find("input, select, button, textarea");                                              
                    $inputs.prop("disabled", true);
                    //url = service_url + "/save_role";
                    
                    //freez form
                    var $inputs = $("#edit_role_form").find("input, select, button, textarea");                                              
                    $inputs.prop("disabled", true);
                    
                    // stop form from submitting
                    e.preventDefault();
                    
                    $.ajax({
                    type: "POST",
                    url: 'refresh_content.php',
                    data: {
                        option: "save_role",
                        data: JSON.stringify(data)
                    },
                    dataType: 'json', 
                    async:false,
                    beforeSend: function ( xhr ) {
                        // maybe tell the user that the request is being processed
                        //$("#status").show().html("<img src='images/preloader.gif' width='32' height='32' alt='processing...'>");
                    }
                }).done(function( result ) {
                        if (JSON.parse(result)[0].id !== undefined)
                        {
                            $("#message").html("Data Saved");
                            var role_id = JSON.parse(result)[0].id;
                            $("#txt_id").val(role_id);
                            
                        }
                        else
                        {
                            $("#message").html("Error saving factory details");
                            $("#message").html(JSON.parse(result)); //uncomment this and check the error message
                        }
                        $inputs.prop("disabled", false);
                        RefreshRoleList();
                    });
                }
            }); 
            
            $("#edit_user_form").submit(function(e) {
                // Grab all values
                var id = $("#txt_id").val();
                var u_name = $("#txt_u_name").val().trim();
                var p_word = $("#txt_p_word").val();
                var roles = [];
                roles = $('#cmbRoles').val();
                districts = $('#cmbDistricts').val();
                crops = $('#cmbCrops').val();
                
                var data = {
                    id : id,
                    u_name : u_name,
                    p_word : p_word,
                    roles : roles,
                    districts : districts,
                    crops : crops
                };
                
                if(u_name != "")
                {
                    var $inputs = $("#edit_role_form").find("input, select, button, textarea");                                              
                    $inputs.prop("disabled", true);
                    
                    //freez form
                    var $inputs = $("#edit_role_form").find("input, select, button, textarea");                                              
                    $inputs.prop("disabled", true);
                    
                    // stop form from submitting
                    e.preventDefault();
                    
                    $.ajax({
                        type: "POST",
                        url: 'refresh_content.php',
                        data: {
                            option: "save_user",
                            data: JSON.stringify(data)
                        },
                        dataType: 'json', 
                        async:false,
                        beforeSend: function ( xhr ) {
                            // maybe tell the user that the request is being processed
                            //$("#status").show().html("<img src='images/preloader.gif' width='32' height='32' alt='processing...'>");
                        }
                    }).done(function( result ) {
                            if (JSON.parse(result)[0].id !== undefined)
                            {
                                $("#message").html("Data Saved");
                                $("#txt_id").val(JSON.parse(result)[0].id);
                            }
                            else
                            {
                                $("#message").html("Error saving factory details");
                                $("#message").html(JSON.parse(result)); //uncomment this and check the error message
                            }
                            $inputs.prop("disabled", false);
                            RefreshUserList();
                        });
                }
            }); 
            
            $("#new_user").on("click", function () {
                var id = 0;
                $.ajax({
                    type: "GET",
                    url: "edit_user.php",
                    data: {id: id },
                    //contentType: "application/json; charset=utf-8",
                    dataType: "html",
                    success: function(result)
                            {
                                $("#model_content").empty();
    			                $("#model_content").html(result);
                                $('.selectpicker').selectpicker({
                                    size: 7
                                });
                            },
                    failure: function () {
                        alert("Failed!");
                    }
                });
            });
            
            $('body').on('click', '.edit_user_', function() {
                var id = this.id;
                var user_id = id.substring(10, id.length);
                $.ajax({
                    type: "GET",
                    url: "edit_user.php",
                    data: {id: user_id },
                    async: false,
                    dataType: "html",
                    success: function(result)
                            {
                                $("#model_content").empty();
    			                $("#model_content").html(result);
                                $('.selectpicker').selectpicker({
                                    size: 7
                                });
                            },
                    failure: function () {
                        alert("Failed!");
                    }
                });
            });
            
        });
        
        function RefreshUserList()
        {
            $.ajax({
                type: "GET",
                url: "refresh_content.php",
                data: {option: 'list_user' },
                dataType: "html",
                success: function(res)
                        {
                            $("#user_list").empty();
			                $("#user_list").html(res);
                        },
                failure: function () {
                    alert("Failed!");
                }
            });
        }
        
        function RefreshRoleList()
        {
            $.ajax({
                type: "GET",
                url: "refresh_content.php",
                data: {option: 'list_role' },
                dataType: "html",
                success: function(res)
                        {
                            $("#role_list").empty();
			                $("#role_list").html(res);
                        },
                failure: function () {
                    alert("Failed!");
                }
            });
        }
      </script>
</body>
</html>