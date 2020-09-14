<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Creative admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <title>Creative - Premium Admin Template</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Font Awesome-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/fontawesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/feather-icon.css">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/photoswipe.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/prism.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/vertical-menu.css">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
    <link id="color" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/light-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/responsive.css">
  </head>
  <body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="loader loader-7">
        <div class="line line1"></div>
        <div class="line line2"></div>
        <div class="line line3"></div>
      </div>
    </div>
    <!-- Loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper vertical">
      <!-- Page Header Start-->
      <div class="page-main-header">
        <div class="main-header-right row">
          <div class="main-header-left d-lg-none">
            <div class="logo-wrapper"><a href="index.html"><img src="<?php echo base_url(); ?>assets/images/creative-logo1.png" alt=""></a></div>
          </div>
          <div class="mobile-sidebar d-none">
            <div class="media-body text-right switch-sm">
              <label class="switch">
                <input id="sidebar-toggle" type="checkbox" checked="checked"><span class="switch-state"></span>
              </label>
            </div>
          </div>
          <div class="vertical-mobile-sidebar"><i class="fa fa-bars sidebar-bar"></i></div>
 

<?php 
$name = $user->name;
$email = $user->email;
$address = $user->address;
$role = ($user->address==1)?'Admin':'User';
$image = !empty($user->image)?$user->image:base_url('assets/images/dashboard/user.png');
 ?>
          <div class="nav-right col pull-right right-menu">
            <ul class="nav-menus">
              <li> 
                <div class="dropdown">
                  <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"><span class="media user-header"><img class="mr-2 rounded-circle img-35" src="<?php echo $image; ?>" alt="" style="height:30px;"><span class="media-body"><span class="f-12 f-w-600"><?php echo $name; ?></span><span class="d-block"><?php echo $role; ?></span></span></span></button>
                  <div class="dropdown-menu p-0">
                    <ul class="profile-dropdown">
                      <li><i data-feather="user"></i><a href="<?php echo base_url('site/userprofile'); ?>">Profile</a></li>
                      <li><i data-feather="user"> </i><a href="<?php echo base_url('site/logout'); ?>">Logout</a></li>
                    </ul>
                  </div>
                </div>
              </li>


     
            </ul>
          </div>
          <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
        </div>
      </div>
      <!-- Page Header Ends -->
	  

	  
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
      

        <!-- Right sidebar Ends-->
        <div class="page-body vertical-menu-mt">
          <div class="container-fluid">
		  
            <div class="page-header">
              <div class="row">
                <div class="col-lg-6">
                  <h3>Update Profile</h3>
                </div>

              </div>
            </div>
         
		  
		  </div>

              <?php if ($this->session->flashdata('msg')) { ?><?php echo $this->session->flashdata('msg'); } ?>
		  
		  
		<!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="edit-profile">
              <div class="row">
                <div class="col-lg-4">
                  <div class="card">
                    <div class="card-header">
                      <h4 class="card-title mb-0">My Profile</h4>
                      <div class="card-options"><a class="card-options-collapse" href="#" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                          <div class="col-auto"><img style="height:50px;" class="img-70 rounded-circle" alt="" src="<?php echo $image; ?>" ></div>
                          <div class="col">
                            <h3 class="mb-1"><?php echo $name; ?></h3>
                            <p class="mb-4"><?php echo $email; ?></p>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-8">
              <?php echo form_open_multipart(base_url('Site/userprofile'), array('id' => 'login-form','class'=>'card')); ?>
                    <div class="card-header">
                      <h4 class="card-title mb-0">Edit Profile</h4>
                      <div class="card-options"><a class="card-options-collapse" href="#" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-toggle="card-remove"><i class="fe fe-x"></i></a></div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-5">
                          <div class="form-group">
                            <label class="form-label">Name</label>
                            <input class="form-control" type="text" placeholder="Company" name="name" id="name" value="<?php echo $name; ?>">
                          </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                          <div class="form-group">
                            <label class="form-label">Email address</label>
                            <input class="form-control" type="email" placeholder="Email"  name="email" id="email" value="<?php echo $email; ?>" readonly>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label class="form-label">Address</label>
                            <input class="form-control" type="text" placeholder="Address" name="address" id="address" value="<?php echo $address; ?>">
                          </div>
                        </div>

                    <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                    <label class="form-label">Profile Image</label>
                    <input type="file" name="image" id="image">
                    </div>
                    </div>

                    <?php if(!empty($user->image)) { ?>
              <img src="<?php echo $user->image; ?>" style="height:100px;">
              <input type="hidden" name="image_old" id="image_old" value="<?php echo $user->image; ?>">
                    <?php } ?>

     

                      </div>
                    </div>
                    <div class="card-footer text-right">
                      <button class="btn btn-primary" type="submit">Update Profile</button>
                    </div>
                  </form>
                </div>
        
              </div>
            </div>
          </div>
          <!-- Container-fluid Ends-->
        
		
		</div>
        <!-- footer start-->
        <footer class="footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 footer-copyright">
                <p class="mb-0">Copyright 2019 © Creative All rights reserved.</p>
              </div>
              <div class="col-md-6">
                <p class="pull-right mb-0">Hand crafted & made with<i class="fa fa-heart"></i></p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- latest jquery-->
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap js-->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap/bootstrap.js"></script>
    <!-- feather icon js-->
    <script src="<?php echo base_url(); ?>assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- Sidebar jquery-->
    <script src="<?php echo base_url(); ?>assets/js/sidebar-menu.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/config.js"></script>
    <!-- Plugins JS start-->
    <script src="<?php echo base_url(); ?>assets/js/counter/jquery.waypoints.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/counter/jquery.counterup.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/counter/counter-custom.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/photoswipe/photoswipe.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/photoswipe/photoswipe-ui-default.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/photoswipe/photoswipe.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/chat-menu.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/tooltip-init.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="<?php echo base_url(); ?>assets/js/script.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/theme-customizer/customizer.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.drilldown.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/vertical-menu.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/megamenu.js"></script>
    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>