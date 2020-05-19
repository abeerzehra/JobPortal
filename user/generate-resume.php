<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
//This is required if user tries to manually enter dashboard.php in URL.
if(empty($_SESSION['id_user'])) {
	header("Location: ../index.php");
	exit();
}

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("../db.php");
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
        </ul>
      </div>
    </nav>
  </header>

<div class="content-wrapper" style="margin-left: 0px;">
    <!-- I am creating this form based on template I provided. If your template looks different then these fields will change -->
	<section id="candidates" class="content-header">
    <div class="container">      
      <div class="row">
	       <div class="col-md-3">
            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Welcome <b><?php echo $_SESSION['name'] ?></b></h3>
              </div>
              <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked">
                  <li><a href="edit-profile.php"><i class="fa fa-user"></i> Edit Profile</a></li>
                  <li class="active"><a href="resume-upload.php"><i class="fa fa-file"></i> Resume</a></li>
                  <li><a href="dashboard.php"><i class="fa fa-address-card-o"></i> My Applications</a></li>
                  <li><a href="settings.php"><i class="fa fa-gear"></i> Settings</a></li>
                  <li><a href="../logout.php"><i class="fa fa-arrow-circle-o-right"></i> Logout</a></li>
                </ul>
              </div>
            </div>
          </div>
	  
	   <div class="col-md-9 bg-white padding-2">
            <h2 class="text-center">Generate Resume</h2>
            <div class="panel-body">
              <form class="form-horizontal" method="post" action="generate-resume-data.php">
                <h3>Personal Details Section : </h3>   
                <div class="form-group">
                  <label class="col-md-4 control-label">Name</label>
                  <div class="col-md-6">
                    <input type="text" name="name" class="form-control" required="">
                  </div>
                </div>    

                <div class="form-group">
                  <label class="col-md-4 control-label">Address</label>
                  <div class="col-md-6">
                    <input type="text" name="address" class="form-control" required="">
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-4 control-label">Phone</label>
                  <div class="col-md-6">
                    <input type="text" name="phone" class="form-control" required="">
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="col-md-4 control-label">Email</label>
                  <div class="col-md-6">
                    <input type="text" name="email" class="form-control" required="">
                  </div>
                </div>

                <h3>Experience Section : </h3>

                <div class="form-group">
                  <label class="col-md-4 control-label">Number Of Company You Want To Add For Experience: </label>
                  <div class="col-md-6">
                    <select name="experienceNo" class="form-control" id="experienceNo" required="">
                      <option value="">Select Value</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                    </select>
                  </div>
                </div>
                
                <div id="experienceSection"></div>

                <div class="form-group">
                  <center>
                    <button type="submit" class="btn btn-primary btn-flat">Generate</button>
                  </center>
                </div>
  
              </form>
            </div>
         
		</div>
      </div>
    </div>
	</section>
</div>

  <footer class="main-footer" style="margin-left: 0px;">
    <div class="text-center">
      <strong>Copyright &copy; 2019-2020 Developed </strong> All rights
    reserved.
    </div>
  </footer>
<!-- jQuery 3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../js/adminlte.min.js"></script>
    <script>
      $("#experienceNo").on("change", function () {
        var numInputs = $(this).val();
        $("#experienceSection").html('');
        for(var i=0; i < numInputs; i++) {
          var j = i + 1;
         $("#experienceSection").append('<div class="form-group"><label for="companyname'+i+'" class="col-md-4 control-label">Company Name '+j+'</label><div class="col-md-6"><input id="companyname'+i+'" type="text" class="form-control" name="companyname[]" required></div></div><div class="form-group"><label for="location'+i+'" class="col-md-4 control-label">Location '+j+'</label><div class="col-md-6"><input id="location'+i+'" type="text" class="form-control" name="location[]" required></div></div><div class="form-group"><label for="timeperiod'+i+'" class="col-md-4 control-label">Time Period '+j+'</label><div class="col-md-6"><input id="timeperiod'+i+'" placeholder="2017-2020" type="text" class="form-control" name="timeperiod[]" required></div></div><div class="form-group"><label for="position'+i+'" class="col-md-4 control-label">Position '+j+'</label><div class="col-md-6"><input id="position'+i+'" type="text" class="form-control" placeholder="Junior Software Developer" name="position[]" required></div></div><div class="form-group"><label for="experience'+i+'" class="col-md-4 control-label">Job Description '+j+'</label><div class="col-md-6"><textarea id="experience'+i+'" class="form-control" name="experience[]" placeholder="Worked and Developed..." required></textarea></div></div><hr>');
        }
      });
    </script>
    
    <script>
    // After generate button is pressed redirect to resume page as resume will be downloaded by then.
      $('form').on('submit', function() {
        setTimeout(function() { window.location = 'resume-upload.php'; }, 1000);
      });
    </script>

  </body>
</html>