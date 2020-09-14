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
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/style.css">
    <link id="color" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/light-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/responsive.css">
<script src="<?php echo base_url(); ?>assets/js/jquery-3.2.1.min.js"></script>
	<script src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>
	<script src="<?php echo base_url('assets/js/additional-methods.min.js'); ?>"></script>

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
    <div class="page-wrapper">
      <div class="container-fluid p-0">
        <!-- login page start-->
        <div class="authentication-main mt-0">
          <div class="row">
            <div class="col-md-12">
              <div class="auth-innerright auth-bg">
                <div class="authentication-box">
                  <div class="mt-4">
                    <div class="card-body p-0">

                      <div class="cont text-center">
                        <div> 
                          <?php echo form_open_multipart(base_url('Site/loginusers'), array('id' => 'login-form','class'=>'theme-form')); ?>
                            <h4>LOGIN</h4>
                            <h6>Enter your Username and Password</h6>

                <?php if ($this->session->flashdata('msg')) { ?><?php echo $this->session->flashdata('msg'); } ?>
                            <div class="form-group">
                              <label class="col-form-label pt-0">Email</label>
                           <input class="form-control" type="text" required="" name="emaillogin" id="emaillogin">
                            </div>
                            <div class="form-group">
                              <label class="col-form-label">Password</label>
                            <input class="form-control" type="password" required="" name="passwordlogin" id="passwordlogin">
                            </div>
                            <div class="checkbox p-0">
                              <input id="checkbox1" type="checkbox">
                              <label for="checkbox1">Remember me</label>
                            </div>
                            <div class="form-group form-row mt-3 mb-0">
                              <button class="btn btn-primary btn-block" type="submit">LOGIN</button>
                            </div>
                            <div class="login-divider"></div>
                          </form>
                        </div>
                        <div class="sub-cont">
                          <div class="img">
                            <div class="img__text m--up">
                              <h2>New User?</h2>
                              <p>Sign up and discover great amount of new opportunities!</p>
                            </div>
                            <div class="img__text m--in">
                              <h2>One of us?</h2>
                              <p>If you already has an account, just sign in. We've missed you!</p>
                            </div>
                            <div class="img__btn"><span class="m--up">Sign up</span><span class="m--in">Sign in</span></div>
                          </div>
                          <div>

                          <?php echo form_open_multipart(base_url('Site/saveUsers'), array('id' => 'addclient-form','class'=>'theme-form')); ?>

                              <h4 class="text-center">NEW USER</h4>
                              <h6 class="text-center">Enter your Username and Password For Signup</h6>
                              <div class="form-row">
                                <div class="col-md-12">
                                  <div class="form-group">
                               <input class="form-control" type="text" placeholder="Name" name="name" id="name">
                                  </div>
                                </div>
                                <div class="col-md-12">
                                  <div class="form-group">
                             <input class="form-control" type="text" placeholder="Email" name="email" id="email">
                                  </div>
                                </div>
                              </div>
                              <div class="form-group">
                                <input class="form-control" type="password" placeholder="Password" name="password" id="password">
                              </div>

                               <div class="form-group">
                            <input class="form-control" type="password" placeholder="Confirm Password" name="confirm" id="confirm">
                              </div>

<div class="form-group">
<input class="form-control" type="text" placeholder="Address" name="address" id="address">
</div>
<div style="clear: both;height: 20px;" ></div>


                              <div class="form-row">
                                <div class="col-sm-4">
                                  <button class="btn btn-primary" type="submit">Sign Up</button>
                                </div>
                                <div class="col-sm-8">
                                  <div class="text-left mt-2 m-l-20">Are you already user?  <a class="btn-link text-capitalize" href="<?php echo base_url('site/login'); ?>">Login</a></div>
                                </div>
                              </div>
                              <div class="form-divider"></div>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- login page end-->
      </div>
    </div>

<script type="text/javascript">
$(document).ready(function () {

  var token =  $('input[name="csrf_token_name"]').attr('value'); 

    $('#addclient-form').validate({ 
    errorLabelContainer: "#cs-error-note",
    rules: {
			name: "required",
			password: "required",
			address: "required",
			confirm: {
			required: true,
			equalTo: "#password"
            },
        email: {
            required: true,
            email: true,
            remote: {
                    url: "<?php echo base_url('site/checkemilexist') ?>",
                    type: "post",
                    data: {csrf_token_name:token,email: function(){ return $("#email").val();}},
                 },
        },
    },
    messages: {
        email: {
            required: "Please enter your email address.",
            email: "Please enter a valid email address.",
            remote: "Email already Exists! Please use diffrent email."
        },
        name:'Please enter your name',
        password:'Please enter your password',
        address:'Please enter your address',
        confirm: {
			required: 'Please enter confirm password',
			equalTo: "password and confirm password should be same"
            },
    },
    submitHandler: function(form) {
                        form.submit();
                   }
    });
});	



$(document).ready(function () {

    $('#login-form').validate({ // initialize the plugin
               emaillogin: 
               {
               required: true,
               email: true
               },
               passwordlogin:"required",
    });

});


</script>

<style type="text/css">
	.error
	{
		color: red;
		margin:0px;
		float: left !important; 
	}
	
</style>


    <!-- latest jquery-->
    
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
    <script src="<?php echo base_url(); ?>assets/js/login.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="<?php echo base_url(); ?>assets/js/script.js"></script>
    <!-- login js-->
    <!-- Plugin used-->
  </body>
</html>