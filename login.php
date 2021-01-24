<?php

$redirect_page = (isset($_GET['redirect_to']) ? $_GET['redirect_to'] : 'index.php');

?>

<?php
ob_start();
if(!isset($_SESSION))
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
 <!-- Google Font: Source Sans Pro -->
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/js/plugins/select2/css/select2.min.css">

  <link rel="stylesheet" href="dist/js/plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="dist/js/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="dist/js/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="dist/js/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="dist/css/styles.css">
<style type="text/css">
.modal-header .close
{
    display: none;
}
.LoginPage{
    overflow: hidden;
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    background: url(images/login/background.jpg) 0 0 no-repeat;
    background-size: cover;
    align-items:right;

}
.LoginPage::before{
    content: '';
    background-color: #fff;
    opacity: 0.8;
    overflow: hidden;
    position: absolute;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    background-size: cover;
}
.login-box, .register-box {
    width: 400px;
}
.logo-image{
  margin-bottom:10px;
}
</style>
<body class="hold-transition login-page LoginPage">
      <!-- <div class="row" style="padding-top: 50px;">
        <div class="col-lg-4 col-sm-4 col-xs-2"></div>
        <div class="col-lg-4 col-sm-4 col-xs-8">
            <form class="form-horizontal" id="login_form">

                <div class="modal-content" style="min-width: 200px;">
                    
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">System Login</h4>
                    </div>
                    <div id="model_content" class="modal-body">
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="u_name">Username:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" name="u_name" id="u_name" placeholder="Enter your username" required>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="p_word">Password:</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" name="p_word" id="p_word" placeholder="Enter password" required>
                        </div>
                      </div> 
                    </div> 
                    <div class="modal-footer">
                    <div style="clear: both;">
                        <div id="message" style="float: left; text-align: left;"></div>
                        <div style="float: right;">
                          <button id="btn_login" type="submit" class="btn btn-primary">Login</button>
                        </div>
                     </div>
                  </div>   
                </div>
             </form>
        </div>
        <div class="col-lg-4 col-sm-4 col-xs-2"></div>
      </div> -->


      <div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <img class="logo-image" src="images/logos/starr-logo.png" alt="Starr logo">
      <a href="#" class="h1"><b>MIS</b>Login</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form id="login_form">
        <div class="input-group mb-3">
        <input type="text" class="form-control" name="u_name" id="u_name" placeholder="Enter your username" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
        <input type="password" class="form-control" name="p_word" id="p_word" placeholder="Enter password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
          <button id="btn_login" type="submit" class="btn btn-primary">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
<!-- 
      <div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div> -->
      <!-- /.social-auth-links -->

      <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>


<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="dist/js/adminlte.js"></script>

<script src="js/login.js"></script>

</body>
</html>