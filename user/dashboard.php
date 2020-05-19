<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
//This is required if user tries to manually enter dashboard.php in URL.
if(empty($_SESSION['id_user'])) {
	header("Location: ../index.php");
	exit();
}
require_once("../db.php");
?>
<!DOCTYPE html>
<html>
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
                  <li><a href="resume-upload.php"><i class="fa fa-file"></i> Resume</a></li>
                  <li class="active"><a href="dashboard.php"><i class="fa fa-address-card-o"></i> My Applications</a></li>
                  <li><a href="settings.php"><i class="fa fa-gear"></i> Settings</a></li>
                  <li><a href="../logout.php"><i class="fa fa-arrow-circle-o-right"></i> Logout</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-9 bg-white padding-2">
	<?php if(isset($_SESSION['jobApplySuccess'])) { ?>
      <div class="row">
        <div class="col-md-12 successMessage">
          <div class="alert alert-success">
            You Have Successfully Applied!
          </div>
        </div>
      </div>
      <?php unset($_SESSION['jobApplySuccess']); } ?>
            <h2><i>Recent Applications</i></h2>
            <p>Here you'll find applications you have applied in</p>
            
			 <?php
                //Sql Query for showing all applied job posts. 
                //
                //So basically - Select all *job post id* from *apply_job_post table* that match with *job_post table* where user matches currect logged in user in *apply_job post table*.
                  $sql = "SELECT * FROM job_post INNER JOIN apply_job_post ON job_post.id_jobpost=apply_job_post.id_jobpost WHERE apply_job_post.id_user='$_SESSION[id_user]'";
                  $result = $conn->query($sql);

                  //If user applied to job then display that post information.
                  if($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) 
                    {
                      $sql2 = "SELECT * FROM company WHERE id_company='$row[id_company]'"; 
                      $result2 = $conn->query($sql2);
                      $row2 = $result2->fetch_assoc();
                     ?>
                      <div class="attachment-block clearfix padding-2" style="margin-top: 20px">
					   <h4 class="attachment-heading"><a href="view-job-post.php?id=<?php echo $row['id_jobpost'] ?>&applied=1" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['jobtitle'] ?> @ <?php echo $row2['companyname'] ?></a></h4>
						<div class="attachment-text padding-2">
							<div class="pull-left"><i class="fa fa-calendar"> </i> <?php echo date("d-M-Y", strtotime($row['createdat'])); ?></div>
							<?php if($row['status'] == 0) {     ?> 							
							 <div class="pull-right"><strong class="text-orange">Pending</strong></div>
							<?php } else if ($row['status'] == 2) { ?>
							<div class="pull-right"><strong class="text-green">Approved</strong></div>
							<?php } else { ?>
							<div class="pull-right"><strong class="text-red">Rejected</strong></div>
							<?php } if(isset($row['interview_date'])) { ?>
						    <div class="text-center"><i class="fa fa-address-card"></i><strong> <?php echo $row['interview_date']; ?></strong></div>
							<?php  }  ?>		
					    </div>                                     
                     </div>
                     <?php
                    }
                  }
                  else { ?>
                  <h3 class="text-center">You Haven't Applied For Any Jobs Yet ;)</h3>

                  <?php
                  }
                  $conn->close();
                ?>
    
            </div>
            
          </div>
        </div>
      </div>
    </section>

    

  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer" style="margin-left: 0px;">
    <div class="text-center">
      <strong>Copyright &copy; 2020-2021 Developed </strong> All rights
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

    <script type="text/javascript">
      $(function() {
        $(".successMessage:visible").fadeOut(2000);
      });
    </script>
</body>
</html>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5d99b7156c1dde20ed053e3a/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->