
<?php
//To Handle Session Variables on This Page
session_start();

//If user is already logged in then redirect them back to dashboard. 
//This is required if user tries to manually enter register.php in URL.
if(isset($_SESSION['id_user']) && empty($_SESSION['companyLogged'])) {
    header("Location: ../user/dashboard.php");
    exit();
  } else if(isset($_SESSION['id_user']) && isset($_SESSION['companyLogged'])) {
    header("Location: ../company/dashboard.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Job Portal</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../css/AdminLTE.min.css">
  <link rel="stylesheet" href="../css/_all-skins.min.css">
  <!-- Custom -->
  <link rel="stylesheet" href="../css/custom.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

</head>
  
  <body class="hold-transition skin-green sidebar-mini">
    
    <!-- NAVIGATION BAR -->
    <header class="main-header">
	
       <!-- Logo -->
    <a href="index.php" class="logo logo-bg">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>J</b>P</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Job</b> Portal</span>
    </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li>
            <a href="../search.php">Jobs</a>
          </li>
          <li>
            <a href="../login.php">Login</a>
          </li>
          <li>
            <a href="../sign-up.php">Sign Up</a>
          </li>          
        </ul>
      </div>
    </nav>
  </header>

 <div class="content-wrapper" style="margin-left: 0px;">
    <section class="content-header">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-md-offset-4 well bg-white">
          <h1 class="text-center margin-bottom-20">CREATE YOUR PROFILE</h1>
            <form method="post" action="adduser.php" id="first_form">
              <div class="form-group">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name*" required="">
              </div>
              <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name*" required="">
              </div>
              <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email*" required="">
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password*" required="">
              </div>
              <div class="text-center">
                <button type="submit" class="btn btn-success btn-flat">Submit</button>
              </div>
              <?php 
              //If User already registered with this email then show error message.
              if(isset($_SESSION['registerError'])) {
                ?>
                <div>
                  <p class="text-center">Email Already Exists! Please Try Login!</p>
                </div>
              <?php
               unset($_SESSION['registerError']); }
              ?>     
            </form>
          </div>
        </div>
      </div>
    </section>
</div>
   
  </body>
</html>


