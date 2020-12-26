<?php 
    if(!isset($_SESSION))
        session_start();
    
    $call_page = "";
    if(isset($_GET["call_page"]))
        $call_page = $_GET["call_page"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<?php include('header.php'); ?>
<body>
<?php include('nav_bar.php'); ?>	

    
    <!-- /#page-wrapper -->
<!-- /#wrapper -->
    
    <!-- Jumbotron 
      <div class="jumbotron" style="background-image: url('images/background.jpg'); background-repeat: no-repeat;background-size: 100% auto; min-height: 400px; padding-top: 100px;">
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-5" style="color: white;">
                <h2>STARR Project for poverty reduction and uplifting livelihood</h2>
                <p class="lead">The smallholders dominate Sri Lanka's tea and rubber sectors, which have been making a notable
                                contribution to the national economy for over a century. They account for 73% share of the country's
                                tea production and 63% share of rubber production. There are tremendous opportunities and
                                challengers for the sustainable smallholder tea and rubber development, particularly in terms of
                                productivity and market linkages that impacts directly on the smallholders' livelihood and poverty
                                levels.</p>
                <p><a class="btn btn-lg btn-success" href="#" role="button">STARR Project</a></p>
            </div>
            <div class="col-lg-5"></div>
            <div class="col-lg-1"></div>
        </div>
      </div>
    -->
        <div class="row" style="background-image: url('images/background.jpg'); background-repeat: no-repeat;background-size: 100% auto; min-height: 400px; margin-top: -15px;">
            <div class="col-lg-1"></div>
            <div class="col-lg-5" style="color: white;">
                <h2>STARR Project for poverty reduction and uplifting livelihood</h2>
                <p class="lead">The smallholders dominate Sri Lanka's tea and rubber sectors, which have been making a notable
                                contribution to the national economy for over a century. They account for 73% share of the country's
                                tea production and 63% share of rubber production. There are tremendous opportunities and
                                challengers for the sustainable smallholder tea and rubber development, particularly in terms of
                                productivity and market linkages that impacts directly on the smallholders' livelihood and poverty
                                levels.</p>
                <p><a target="_blank" class="btn btn-lg btn-success" href="http://starr.lk/" role="button">STARR Project</a></p>
            </div>
            <div class="col-lg-5"></div>
            <div class="col-lg-1"></div>
        </div>  
      <!-- Start Feature Section -->
        <section id="feature" class="feature-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-1 col-sm-6 col-xs-12"></div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="feature">
                            <a href="benefiter.php"><i class="" style="padding-bottom: 5px;"><img src="images/home/benefiter.png" class="module_box_img" /></i></a>
                            <div class="feature-content">
                                <h4>Benefiters</h4>
                                <p>Beneficiary details are collected at this component. Benefiters personal and household information are mainly captured here.</p>
                            </div>
                        </div>
                    </div><!-- /.col-md-3 -->
                    <!--
                    <div class="col-md-2 col-sm-6 col-xs-12">
                        <div class="feature">
                            <a href="benefiter.php"><i class="" style="padding-bottom: 5px;"><img src="images/home/payment.png" class="module_box_img" /></i></a>
                            <div class="feature-content">
                                <h4>Payments</h4>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                            </div>
                        </div>
                    </div>
                    -->
                    <!-- /.col-md-3 -->
                    <div class="col-md-2 col-sm-6 col-xs-12">
                        <div class="feature">
                            <a href="society.php"><i class="" style="padding-bottom: 5px;"><img src="images/home/society.png" class="module_box_img" /></i></a>
                            <div class="feature-content">
                                <h4>Society</h4>
                                <p>Beneficiary's society details are collected at this component. Society registration details and it's officials details are captured in this component.</p>
                            </div>
                        </div>
                    </div><!-- /.col-md-3 -->
                    <div class="col-md-2 col-sm-6 col-xs-12">
                        <div class="feature">
                            <a href="nursery.php"><i class="" style="padding-bottom: 5px;"><img src="images/home/nursery.png" class="module_box_img" /></i></a>
                            <div class="feature-content">
                                <h4>Nursery</h4>
                                <p>Nursery details are collected at this component. Nursery registration details and its owner details are captured in this component.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                        <div class="feature">
                            <a href="factory.php"><i class="" style="padding-bottom: 5px;"><img src="images/home/factory.png" class="module_box_img" /></i></a>
                            <div class="feature-content">
                                <h4>Factory</h4>
                                <p>Factory details are collected at this component. Factory registration details and its owner details are captured in this component.</p>
                            </div>
                        </div>
                    </div>
                </div><!-- /.row -->
                <div class="row justify-content-md-center">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        
                    </div><!-- /.col-md-3 -->
                    <!-- 
                    <div class="col-md-2 col-sm-6 col-xs-12">
                        <div class="feature">
                            <a href=""><i class="" style="padding-bottom: 5px;"><img src="images/home/rural_financing.png" class="module_box_img" /></i></a>
                            <div class="feature-content">
                                <h4>Rural Financing</h4>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                            </div>
                        </div>
                    </div>
                    -->
                    <!-- /.col-md-3 -->
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="feature">
                            <a href="training.php"><i class="" style="padding-bottom: 5px;"><img src="images/home/training.png" class="module_box_img" /></i></a>
                            <div class="feature-content">
                                <h4>Training</h4>
                                <p>Trainings conducted by project office, DPMUs and societies are captured here in this component.</p>
                            </div>
                        </div>
                    </div><!-- /.col-md-3 -->
                    <div class="col-md-2 col-sm-6 col-xs-12">
                        <div class="feature">
                            <a href=""><i class="" style="padding-bottom: 5px;"><img src="images/home/gis.png" class="module_box_img" /></i></a>
                            <div class="feature-content">
                                <h4>GIS</h4>
                                <p>GIS component developed by project office is linked here.</p>
                            </div>
                        </div>
                    </div><!-- /.col-md-3 -->
                    <div class="col-md-2 col-sm-6 col-xs-12">
                        <!--
                        <div class="feature">
                            <a href="reports.php"><i class="" style="padding-bottom: 5px;"><img src="images/home/reports.png" class="module_box_img" /></i></a>
                            <div class="feature-content">
                                <h4>Reports</h4>
                                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                            </div>
                        </div>
                        -->
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12">
                        
                    </div>
                </div>
            </div><!-- /.container -->
        </section>
        <!-- End Feature Section -->
                      
      <div class="row">
        <div class="col-lg-1 side_border" style="padding-bottom: 35px !important;"></div>
        <div class="row" style="text-align: center; margin-right: 200px;">
        <p style="font-size: 20px;"> </p>
        </div>
        <div class="col-lg-10" id="search_opt">
            
            <?php 
            $show_adv = "true";
            //include('search_option.php'); 
            ?>
            
            
        </div>
        <div class="col-lg-1 side_border" style="padding-bottom: 35px !important;"></div>
      </div>
      
      <!-- Other content of home page -->
      <div class="row" style="margin-top: 25px;">
        <div class="col-lg-1 hidden-xs hidden-sm hidden-md side_border"></div>
        <div class="col-lg-10" id="container">
            <?php 
            if($call_page == "about")
            {
                include('about.php'); 
            }
            if($call_page == "contact")
            {
                include('contact.php'); 
            }
            else
            { 
            ?>
            
            <div class="row">
                <?php //include('data_home.php'); ?>
                
                <?php //include('models_home.php'); ?>
                
                <?php //vinclude('tools_home.php'); ?>
            </div>
            
            <?php 
            } 
            ?>
        </div>
        <div class="col-lg-1 hidden-xs hidden-sm hidden-md side_border"></div>
      </div>
      
    <?php include('footer.php'); ?>
      
	<script type="text/javascript">
	$(function(){
        $('[data-toggle="tooltip"]').tooltip();
        $(".side-nav .collapse").on("hide.bs.collapse", function() {                   
            $(this).prev().find(".fa").eq(1).removeClass("fa-angle-right").addClass("fa-angle-down");
        });
        $('.side-nav .collapse').on("show.bs.collapse", function() {                        
            $(this).prev().find(".fa").eq(1).removeClass("fa-angle-down").addClass("fa-angle-right");        
        });
    })    
    $(document).ready(function() { window.iframeLoaded = function() { 
        //debugger; 
        $(".logoBar").css("display", "none"); }; 
        
        });
	</script>
</body>

</html>
