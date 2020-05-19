<?php

//To Handle Session Variables on This Page
session_start();

//If user Not logged in then redirect them back to homepage. 
//This is required if user tries to manually enter profile.php in URL.
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
                  <li class="active"><a href="edit-profile.php"><i class="fa fa-user"></i> Edit Profile</a></li>
                  <li><a href="resume-upload.php"><i class="fa fa-file"></i> Resume</a></li>
                  <li><a href="dashboard.php"><i class="fa fa-address-card-o"></i> My Applications</a></li>
                  <li><a href="settings.php"><i class="fa fa-gear"></i> Settings</a></li>
                  <li><a href="../logout.php"><i class="fa fa-arrow-circle-o-right"></i> Logout</a></li>
                </ul>
              </div>
            </div>
          </div>
		
		<div class="col-md-9 bg-white padding-2">
          <h2 class="text-center">Profile</h2>
          <form method="post" action="updateprofile.php" style="margin: 0 auto;">
          <?php
            //Sql to get logged in user details.
            $sql = "SELECT * FROM users WHERE id_user='$_SESSION[id_user]'";
            $result = $conn->query($sql);

            //If user exists then show his details.
            //Todo: Create Seprate Page For Password Change.
            if($result->num_rows > 0) {
              while($row = $result->fetch_assoc()) {
            ?>
			
          <div class="col-md-4 well" style="margin: 5px;margin-left: 10%;background: #FFFF !important">      
            <h3 class="text-center">Personal</h3>
            <div class="form-group" style="border-top:1px solid black;padding-top: 5px;">
                <label for="fname">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" value="<?php echo $row['firstname']; ?>" required="">
              </div>
              <div class="form-group">
                <label for="lname">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="<?php echo $row['lastname']; ?>" required="">
              </div>
              <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" placeholder="Email" value="<?php echo $row['email']; ?>" readonly>
              </div>
          </div>
          <div class="col-md-4 well" style="margin: 5px;margin-left: 10%;background: #FFFF !important">
            <h3 class="text-center">Contact</h3>
            <div class="form-group" style="border-top:1px solid black;padding-top: 5px;">
                <label for="contactno">Contact Number</label>
                <input type="text" class="form-control" id="contactno" name="contactno" placeholder="Contact Number" value="<?php echo $row['contactno']; ?>">
              </div>
              <div class="form-group">
                <label for="qualification">Highest Qualification</label>
                <input type="text" class="form-control" id="qualification" name="qualification" placeholder="Highest Qualification" value="<?php echo $row['qualification']; ?>">
              </div>
              <div class="form-group">
                <label for="stream">Stream</label>
                <input type="text" class="form-control" id="stream" name="stream" placeholder="stream" value="<?php echo $row['stream']; ?>">
              </div>
          </div>
          
          <div class="col-md-4 well" style="margin: 5px;margin-left: 10%;background: #FFFF !important">
            <h3 class="text-center">Location</h3>
            <div class="form-group" style="border-top:1px solid black;padding-top: 5px;">
              <label for="address">Address</label>
              <textarea id="address" name="address" class="form-control" rows="5" placeholder="Address"><?php echo $row['address']; ?></textarea>
            </div>
            <div class="form-group">
              <label for="city">City</label>
              <input type="text" class="form-control" id="city" name="city" value="<?php echo $row['city']; ?>" placeholder="city">
            </div>
            <div class="form-group">
              <label for="state">State</label>
              <input type="text" class="form-control" id="state" name="state" placeholder="state" value="<?php echo $row['state']; ?>">
            </div>
          </div>

            <div class="col-md-4 col-md-offset-4 well" style="margin: 5px;margin-left: 10%;background: #FFFF !important">
            <h3 class="text-center">Others</h3>
              <div class="form-group" style="border-top:1px solid black;padding-top: 5px;">
                <label for="passingyear">Passing Year</label>
                <input type="date" class="form-control" id="passingyear" name="passingyear" placeholder="Passing Year" value="<?php echo $row['passingyear']; ?>">
              </div>
              <div class="form-group">
                <label for="dob">Date of Birth</label>
                <input type="date" class="form-control" id="dob" name="dob" placeholder="Date of Birth" min="1960-01-01" max="2005-01-31" value="<?php echo $row['dob']; ?>">
              </div>
              <div class="form-group">
                <label for="age">Age</label>
                <input type="text" class="form-control" id="age" name="age" placeholder="Age" value="<?php echo $row['age']; ?>" readonly>
              </div>
              <div class="form-group">
                <label for="designation">Designation</label>
                <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" value="<?php echo $row['designation']; ?>">
              </div>
          </div> 
          <div class="text-center col-md-4 col-md-offset-4" style="margin-top:20px;margin-left:-11%; ">
                <button type="submit" class="btn btn-success btn-flat">Update</button>
          </div>
                    
              
            <?php
                }
              }
            ?>                   
            </form>
          </div>
		</div>
        </div>
      </div>
    </section>
</div>

  <footer class="main-footer" style="margin-left: 0px;">
    <div class="text-center">
      <strong>Copyright &copy; 2020-2021 Developed </strong> All rights
    reserved.
    </div>
  </footer>
<!-- jQuery 3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../js/adminlte.min.js"></script>
    <script type="text/javascript">
      $('#dob').on('change', function() {
        var today = new Date();
        var birthDate = new Date($(this).val());
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();

        if(m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
          age--;
        }

        $('#age').val(age);
      });
    </script>
  </body>
</html>