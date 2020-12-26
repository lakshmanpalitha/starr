<?php 
    include_once('link_service.php'); 
    include_once('access.php');	
    
    $section = "system";
    $view_admin_ok = false;
     
    if(isset($_SESSION['access_obj']))
    {
        $section_access = getSectionAccess($section);
        if(isset($section_access->view))
            $view_admin_ok = ($section_access->view=='Y' ? true : false);
    }
?>
<div id="throbber" style="display:none; min-height:120px;"></div>
<div id="noty-holder"></div>
<div id="wrapper">
<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <div class="container">
    
    <div id="navbar" class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="index.php">Home</a></li>
        <li><a href="benefiter.php">Benefiter</a></li>
        <li><a href="society.php">Society</a></li>
        <li><a href="factory.php">Factory</a></li>
        <li><a href="nursery.php">Nursery</a></li>
        <li><a href="training.php">Training</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Machine Grant<span class="caret"></span></a>
            <ul class="dropdown-menu nav_li">
                <li><a href="machine_grant_proposal.php">Proposal</a></li>
            </ul>
        </li>
        <li><a href="reports.php">Reports</a></li>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Config <span class="caret"></span></a>
            <ul class="dropdown-menu nav_li">
                <li><a href="payment_types.php">Payment Types</a></li>
                <li><a href="tshda_updates.php">TSHDA Updates</a></li>
            </ul>
        </li>
      <?php 
        if($view_admin_ok)
        { 
      ?>
        <li><a href="sys_admin.php">Admin</a></li>
      <?php 
        }
      ?>
        <!--
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu nav_li">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li class="dropdown-header">Nav header</li>
            <li><a href="#">Separated link</a></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
         -->
      </ul>
    </div><!--/.nav-collapse -->
</nav>    
  </div>
    <div class="row header_row" style="min-height: 50px; text-align: center; color: white; padding-top: 35px;">
        <div class="col-lg-1"></div>
        <div class="col-lg-3">
            <div style="position: absolute; z-index: 1000000; margin-top: -20px;">
            <a class="top_logo" href=""><img src="images/logos/ifad1.png" width="120" height="80" /></a>
            <a class="top_logo" href=""><img src="images/logos/sl_gvt.png" style="margin-top: -5px;" width="65" height="90" /></a>
            <a class="top_logo" href=""><img src="images/logos/starr1.png" width="70" height="70" /></a>
            </div>
        </div>
        <div class="col-lg-8" style="text-align: left;"><h3>Smallholder Tea and Rubber Revitalization (STARR) Project</h3></div>
    </div>
    <div class="row header_row" style="padding-bottom: 5px; margin-bottom: 15px;">
        <div class="col-lg-8"></div>
        <div class="col-lg-4" style="text-align: right;" id="login_note">
            <?php 
                if(isset($_SESSION['login_user'])) 
                {
            ?>
                Welcome <?php echo $_SESSION['login_user']; ?> | <a class="logout" style="color: white; padding-right: 20px; cursor: pointer;">Logout</a>
            <?php
                } 
                else
                {
            ?>
                <a  href="login.php" style="color: white; padding-right: 20px;">Login</a> <!-- login modal is included in footer.php -->
            <?php        
                }
            ?>
        </div>
    </div>

    