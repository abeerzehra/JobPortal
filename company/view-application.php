<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
//This is required if user tries to manually enter view-job-post.php in URL.
if(empty($_SESSION['id_user'])) {
  header("Location: ../index.php");
  exit();
}

//Including Database Connection From db.php file to avoid rewriting in all files  
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
  <!-- DataTables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../css/AdminLTE.min.css">
  <link rel="stylesheet" href="../css/_all-skins.min.css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                  <li><a href="index.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                  <li><a href="create-job-post.php"><i class="fa fa-file-o"></i> Create Job Post</a></li>
                  <li><a href="my-job-post.php"><i class="fa fa-file-o"></i> My Job Post</a></li>
                  <li class="active"><a href="view-job-applications.php"><i class="fa fa-newspaper-o"></i>View Applications</a></li>
                  <li><a href="settings.php"><i class="fa fa-gear"></i> Settings</a></li>
                  <li><a href="../logout.php"><i class="fa fa-arrow-circle-o-right"></i> Logout</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-9 bg-white padding-2">
            <div class="row margin-top-20">
            <div class="col-md-12">
              <?php
              $sql ="SELECT * FROM apply_job_post INNER JOIN users ON apply_job_post.id_user=users.id_user WHERE apply_job_post.id_user='$_GET[id_user]' AND apply_job_post.id_jobpost='$_GET[id_jobpost]' AND apply_job_post.status='$_GET[st]'";
              $result=$conn->query($sql);

              if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
              ?>
                <div class="pull-left">
                  <h2><b><i><?php echo $row['firstname'] . " " . $row['lastname']; ?></i></b></h2>
                </div>
                <div class="pull-right">
                  <a href="view-job-applications.php" class="btn btn-default btn-lg btn-flat margin-top-20"><i class="fa fa-arrow-circle-left"></i> Back</a>
                </div>
                <?php
                if($row['status'] != 1) {
                  ?>
                  <div class="pull-right" style="margin-right: 10px;">
                  <a href="reject-user.php?id_user=<?php echo $_GET['id_user']; ?>&id_jobpost=<?php echo $row['id_jobpost']; ?>&email=<?php echo $row['email']; ?>" class="btn btn-danger btn-lg btn-flat margin-top-20"><i class="fa fa-times"></i> Reject</a>
                </div>
                <?php
                }
                if($row['status'] == 0 || $row['status'] == 1) {
                  ?>
                  <div class="pull-right" style="margin-right: 10px;">
                <a href="accept-user.php?id_user=<?php echo $_GET['id_user']; ?>&id_jobpost=<?php echo $row['id_jobpost']; ?>&email=<?php echo $row['email']; ?>" class="btn btn-success btn-lg btn-flat margin-top-20"><i class="fa fa-check"></i> Approve</a>
                </div>
                <?php
                }
                if($row['status'] == 2) {
                  ?>
                  <div class="pull-right" style="margin-right: 10px;">
                    <?php if(isset($row['interview_date'])) { ?>
                    <input type="button" id="datepicker" name="date" class="btn btn-primary btn-lg btn-flat margin-top-20" value="<?php echo $row['interview_date']; ?>">
                  <?php } else { ?>
                    <input type="button" id="datepicker" name="date" class="btn btn-primary btn-lg btn-flat margin-top-20" value="Schedule">
                  
                <?php } ?>
                </div>
                <?php }
                ?>
                <div class="clearfix"></div>
                <hr>  
                <p id="email"><strong>Email:</strong> <?php echo $row['email']; ?></p>
                <p><strong>Address:</strong> <?php echo $row['address']; ?></p>
                <p><strong>City:</strong> <?php echo $row['city']; ?></p>
                <p><strong>State:</strong> <?php echo $row['state']; ?></p>
                <p><strong>Contact No:</strong> <?php echo $row['contactno']; ?></p>
                <p><strong>Qualification:</strong> <?php echo $row['qualification']; ?></p>
                <p><strong>Stream:</strong> <?php echo $row['stream']; ?></p>
                <p><strong>Passing Year:</strong> <?php echo $row['passingyear']; ?></p>
                <p><strong>Date Of Birth:</strong> <?php echo $row['dob']; ?></p>
                <p><strong>Designation:</strong> <?php echo $row['designation']; ?></p>
                <?php
                if(isset($row['resume'])) {
                  ?>
                  <a href="../uploads/resume/<?php echo $row['resume']; ?>" class="btn btn-success btn-lg btn-flat margin-top-20" download="<?php echo $row['firstname']; ?>">Download Resume</a>
                  <?php
                }
              } 
              } else { header("Location: index.php"); exit(); } ?>
              </div>
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
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="../js/adminlte.min.js"></script>


     <script type="text/javascript">
      $(function() {
        $(".successMessage:visible").fadeOut(2000);
      });

   $(function() {
       $("#datepicker").datepicker({
        minDate: -7, 
        maxDate: "+5M" ,
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        onSelect: function(dateText, inst) {                    
            var date = $('#datepicker').val();  
            var user = <?php echo $_GET['id_user']; ?>;
            var job_id = <?php echo $_GET['id_jobpost']; ?>;
            var email = $("#email").val();
            window.location.href = 'schedule-interview.php?date='+date+'&id_user='+user+'&id_jobpost='+job_id+'&email='+email;
        }
    });
       
});
    </script>
</body>
</html>
