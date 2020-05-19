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
<div class="wrapper">

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

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="margin-left: 0px;">

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
		    <!-- If resume not uploaded then show error message -->
      <?php if(isset($_SESSION['uploadError'])) { ?>
      <div class="row">
        <div class="col-md-12 successMessage">
          <div class="alert alert-danger">
            <?php echo $_SESSION['uploadError']; ?>
          </div>
        </div>
      </div>
      <?php unset($_SESSION['uploadError']); } ?>
	  
     <div class="col-md-4 col-md-offset-4">
          <div class="panel panel-default">
            <div class="panel-heading">Upload Resume</div>
            <div class="panel-body">
              <form action="upload-resume.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Upload Resume</label>
                  <input type="file" name="resume" class="form-control" required="">
                </div>
                <div class="form-group">
                  <input type="submit" value="Upload" class="btn btn-success btn-flat">
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-md-offset-4">
          <div class="panel panel-default">
            <div class="panel-heading">Upload Video Resume</div>
            <div class="panel-body">
              <form action="upload-resume-video.php" method="post" enctype="multipart/form-data">
                <div class="form-group">
                  <label>Upload Video Resume</label>
                  <input type="file" name="video" class="form-control" required="">
                </div>
                <div class="form-group">
                  <input type="submit" value="Upload" class="btn btn-success btn-flat">
                </div>
              </form>
            </div>
          </div>
        </div>
		<div class="col-md-4 col-md-offset-4">
		<h3>Generate Resume: <h3>
          <a href="generate-resume.php" class="btn btn-primary" >Generate Resume</a>
		</div>
		<div class="col-md-4 col-md-offset-4">
		<?php
        //If resume is uploaded then show download link.
        $sql = "SELECT resume FROM users WHERE id_user='$_SESSION[id_user]' AND resume IS NOT NULL";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
          $row = $result->fetch_assoc();
          ?>
			<h3>Uploaded Resumes: <h3>
          <a href="../uploads/resume/<?php echo $row['resume']; ?>" class="btn btn-success" download="MyUploadedResume">Download Resume</a>
        <?php }  ?>
            </div>
          </div>
        </div>
      </div>
    </section>

    

  </div>
  <!-- /.content-wrapper -->


  <footer class="main-footer" style="margin-left: 0px;">
    <div class="text-center">
      <strong>Copyright &copy; 2020-2021 Developed</strong> All rights
    reserved.
    </div>
  </footer>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../js/adminlte.min.js"></script>
</body>
</html>