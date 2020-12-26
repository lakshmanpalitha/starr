<?php
ob_start();
if(!isset($_SESSION))
    session_start();
?>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta name="robots" content="noindex, nofollow">

    <title>MIS STARR Project</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!--
    <link rel="stylesheet" type="text/css" href="css/layout.css">
	<link rel="stylesheet" type="text/css" href="css/other.css">
    -->
    <!-- <link rel="stylesheet" href="css/lobi_other_style.css"/> -->
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.5.3/js/bootstrapValidator.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.1/jquery.twbsPagination.min.js"></script>
    <script src="js/jquery.tablesorter.js"></script>
    <script src='http://cdnjs.cloudflare.com/ajax/libs/bootstrap-validator/0.4.5/js/bootstrapvalidator.min.js'></script>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    
    <!-- Colors CSS -->
    <link rel="stylesheet" type="text/css" href="css/color/green.css">
    
    
    
    
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
  
    <!-- Modernizer js -->
    <script src="js/modernizr.custom.js"></script>
    
    <link rel="icon" href="images/favicon.ico"/>
    <!-- Custom styles for this template -->
    <style type="text/css">
         
         .error_msg{
            color: red;
         }
         h4{
            color: #5BB12F;
         }
         
         .section_td{
            min-width: 40%;
            width: auto;
            height: 30px;
         }
         /*start nav bar*/     
        .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
        color: #000;  /*Sets the text hover color on navbar*/
        }
        
        .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active >   
         a:hover, .navbar-default .navbar-nav > .active > a:focus {
        color: white; /*BACKGROUND color for active*/
        background-color: #030033;
        }
        
          .navbar-default {
            background-color: #0f006f;
            border-color: #0f006f;
        }
        
          .dropdown-menu > li > a:hover,
           .dropdown-menu > li > a:focus {
            color: #262626;
           text-decoration: none;
          background-color: #66CCFF;  /*change color of links in drop down here*/
           }
        
        
          .navbar-default .navbar-nav > li > a {
           color: white; /*Change active text color here*/
            }
            
          .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
            background-color: silver;
            color: white; /*Change rollover cell color here*/
        }
        
        .module_box_img{
                width: 40px;
                margin-top: -20px;
        }
        .top_logo{
            padding-right: 12px;
        }
        .header_row{
            color: white;
            background-color: #0f006f;
        }
        
        .advance_search {
            margin-left: 53px;
            background-color: #f0f0f0;
            border-radius: 3px;
            padding: 20px;
            margin-top: 10px;
        }
        
        .side_border {
            /*background-color: #CADEE6;*/
            
        }
                
        dl {
            margin-bottom:50px;
            margin-left: 0 !important;
    margin-right: 0 !important;
        }
         
        dl dt {
            float:left; 
            font-weight:bold; 
            margin-right:10px; 
            padding:5px;
            width: auto !important; 
        }
         
        dl dd {
            text-align: justify;
            max-height: 100px;
            margin-left: 140px !important;
            margin-bottom: 5px;
            margin-right: 10px;
            margin:5px 0; 
            padding:5px 0;
        }
        
        .bookmark
        {
            padding: 0px;
            width: 30px; 
            height: 30px;
        }
        
        .download
        {
            padding: 0px;
            width: 30px; 
            height: 30px;
        }
        
        .view_map
        {
            padding: 0px;
            width: 30px; 
            height: 30px;
        }
        
        #pagination-demo{
          display: inline-block;
          margin-bottom: 1.75em;
        }
        #pagination-demo li{
          display: inline-block;
        }
        
        .footer {
            margin: 0 auto;
            font-family: Arial, Helvetica, sans-serif;
            height: 100px;
        }
        
table {
  text-align: left;
  position: relative;
  border-collapse: collapse; 
}
th, td {
  padding: 0.25rem;
}
tr.red th {
  /*background: #D4D6DC;
  color: white;*/
}
tr.green th {
  background: green;
  color: white;
}
tr.purple th {
  background: purple;
  color: white;
}
th {
  background: white;
  position: sticky;
  top: 0;
  box-shadow: 0 2px 2px -1px rgba(0, 0, 0, 0.4);
}
        /*end table style*/
    fieldset 
	{
		border: 1px solid #ddd !important;
		margin: 0;
		xmin-width: 0;
		padding: 10px;       
		position: relative;
		border-radius:4px;
		background-color:#f5f5f5;
		padding-left:10px!important;
        margin-bottom: 12px;
	}	
	
		legend
		{
			font-size:14px;
			font-weight:bold;
			margin-bottom: 0px; 
			width: 35%; 
			border: 1px solid #ddd;
			border-radius: 4px; 
			padding: 5px 5px 5px 10px; 
			background-color: #ffffff;
		}
            
    </style>
    
    <script>
        //service_url = "http://localhost/phase2/vendor/slim/slim/index.php";
        //service_url = "http://localhost/starr/services/index.php";
        //service_url = "http://starr.lk/mis-system/vendor/slim/slim/index.php";

        service_url = 'http://localhost/starr_alone/refresh_content.php';
        
        $(function() {
            //allow only float value typing on textbox
            $('body').on('keypress keyup blur', '.allownumericwithdecimal', function() {
                //this.value = this.value.replace(/[^0-9\.]/g,'');
                $(this).val($(this).val().replace(/[^0-9\.]/g,''));
                    if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                        event.preventDefault();
                    }
                });
        });
        
        function isNumber(event) {
          if (event) {
            var charCode = (event.which) ? event.which : event.keyCode;
            if (charCode != 190 && charCode > 31 && 
               (charCode < 48 || charCode > 57) && 
               (charCode < 96 || charCode > 105) && 
               (charCode < 37 || charCode > 40) && 
                charCode != 110 && charCode != 8 && charCode != 46 )
               return false;
          }
          return true;
        }
        
        function showMessage(message)
        {
            $("#message").css("color","black");
            $("#message").show().html(message);
            setTimeout(function(){ $("#message").hide().html('');}, 5000);
        }
        
        function showErrorMessage(message)
        {
            $("#message").css("color","red");
            $("#message").show().html(message);
            setTimeout(function(){ $("#message").hide().html('');}, 5000);
        }
        
        function showMessageOnDiv(div_id, message)
        {
            $("#" + div_id).css("color","black");
            $("#" +div_id).show().html(message);
            setTimeout(function(){ $("#message").hide().html('');}, 5000);
        }
        
        function showErrorMessageOnDiv(div_id, message)
        {
            $("#" +div_id).css("color","red");
            $("#" +div_id).show().html(message);
            setTimeout(function(){ $("#message").hide().html('');}, 5000);
        }
    </script>
</head>