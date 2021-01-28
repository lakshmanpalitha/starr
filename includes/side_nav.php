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
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="/images/logos/starr1.png" alt="Starr Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">STARR</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!-- <li class="nav-item menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              
            <li class="nav-item">
            <a href="index.php" class="nav-link">
                <i class="fas fa-home"></i>
                <p>Home</p>
            </a>
            </li>

            <li class="nav-item">
            <a href="benefiter.php" class="nav-link">
            <i class="far fa-users"></i>
                <p>Benefiter</p>
            </a>
            </li>

            <li class="nav-item">
            <a href="society.php" class="nav-link">
            <i class="fas fa-users"></i>
                <p>Society</p>
            </a>
            </li>

            <li class="nav-item">
            <a href="factory.php" class="nav-link">
            <i class="fas fa-industry"></i>
                <p>Factory</p>
            </a>
            </li>

            <li class="nav-item">
            <a href="nursery.php" class="nav-link">
            <i class="fas fa-baby-carriage"></i>
                <p>Nursery</p>
            </a>
            </li>

            <li class="nav-item">
            <a href="training.php" class="nav-link">
            <i class="fas fa-chalkboard-teacher"></i>
                <p>Training</p>
            </a>
            </li>
              <li class="nav-item">
                <a href="./index.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index2.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v2</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index3.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Dashboard v3</p>
                </a>
              </li>
            </ul>
          </li> -->
          <li class="nav-item">
          <a href="benefiter.php" class="nav-link">
            <i class="far fa-users"></i>
                <p>Smallholder Registration</p>
            </a>
          </li>
          <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="far fa-users"></i>
                <p>Society Registration</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <!-- <i class="nav-icon fas fa-chart-pie"></i> -->
              <p>
              Infrastructure Development
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <p>Rural road rehabilitation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <p>Multipurpose building development</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <!-- <i class="nav-icon fas fa-chart-pie"></i> -->
              <p>
              Income Diversification
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <p>Machine grants</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <p>Business linkages</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <p>Rural Finances</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <!-- <i class="nav-icon fas fa-chart-pie"></i> -->
              <p>
              Training and capacity development
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <p>Training and extension</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <p>Stakeholder capacity improvement</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <!-- <i class="nav-icon fas fa-chart-pie"></i> -->
              <p>
              Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <p>Management & Admin Reports</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <p>M&E Reports</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <!-- <i class="nav-icon fas fa-chart-pie"></i> -->
              <p>
             User Registration 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <p>Field Animator Registration </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <p>CDO/BDO Registration</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <p>DPMU Registration</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <p>PMUStaff Registration</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <!-- <i class="nav-icon fas fa-chart-pie"></i> -->
              <p>
             Territory Registration
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <p>District Registration </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <p>Divisional Secretary Division Registration</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <p>TI Range Registration</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <!-- <i class="far fa-circle nav-icon"></i> -->
                  <p>Grama Niladari Division Registration</p>
                </a>
              </li>
            </ul>
          </li>
         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>