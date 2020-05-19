<?php
  //To Handle Session Variables on This Page
  session_start();
  //Including Database Connection From db.php file to avoid rewriting in all files
  require_once("db.php");
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
  <link rel="stylesheet" href="css/AdminLTE.min.css">
  <link rel="stylesheet" href="css/_all-skins.min.css">
  <!-- Custom -->
  <link rel="stylesheet" href="css/custom.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">

    <link rel="stylesheet" href="//cdn.datatables.net/plug-ins/1.10.15/features/searchHighlight/dataTables.searchHighlight.css">
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
	
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">     
            <ul class="nav navbar-nav navbar-right">
            <?php
            //Show user dashboard link once logged in.
            if(isset($_SESSION['id_user']) && empty($_SESSION['companyLogged'])) { 
              ?>
              <li><a href="user/dashboard.php">Dashboard</a></li>
              <li><a href="logout.php">Logout</a></li>
            <?php
              } else if(isset($_SESSION['id_user']) && isset($_SESSION['companyLogged'])) { 
              ?>
              <li><a href="company/dashboard.php">Dashboard</a></li>
              <li><a href="logout.php">Logout</a></li>
              <?php }  else { 
              //Show Login Links if no one is logged in.
            ?>
                <li><a href="sign-up.php">Register</a></li>
                <li><a href="login.php">Login</a></li>
            <?php } ?>
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    </header>

    <section >
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="jumbotron text-center">
              <h1>Search Job</h1>
              <p>Find Your Dream Job</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- LATEST JOB POSTS -->
    <section id="candidates" class="content-header">
      <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <form id="myForm" class="form-inline">
            <div class="form-group">
              <label>Experience</label>
              <select id="experience" class="form-control">
                <option value="" selected="">Select Experience (Years)</option>
                 <?php 
                // SQL query to get all differnet qualification that has been entered in our database
                  $sql ="SELECT DISTINCT(experience) FROM job_post WHERE experience IS NOT NULL ORDER BY experience";
                  $result = $conn->query($sql);
                  if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()) {
                      echo "<option value'".$row['experience']."'>".$row['experience']."</option>";
                    }
                  }
                ?>
                
              </select>
            </div>
            <div class="form-group">
              <label>Qualification</label>
              <select id="qualification" class="form-control">
                <option value="" selected="">Select Qualification</option>
                <?php 
                // SQL query to get all differnet qualification that has been entered in our database
                  $sql ="SELECT DISTINCT(qualification) FROM job_post WHERE qualification IS NOT NULL";
                  $result = $conn->query($sql);
                  if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()) {
                      echo "<option value'".$row['qualification']."'>".$row['qualification']."</option>";
                    }
                  }
                ?>
              </select>
            </div>
            <button class="btn btn-success">Search</button>
          </form>
        </div>
      </div>
        <div class="row" style="margin-top: 5%;">
          <div class="table-responsive">
            <table id="myTable" class="table">
              <thead>
                <th>Job Name</th>
                <th>Job Description</th>
                <th>Minimum Salary</th>
                <th>Maximum Salary</th>
                <th>Experience</th>
                <th>Qualification</th>
                <th>Action</th>
              </thead>
              <tbody>
                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>


   <footer class="main-footer" style="margin-left: 0px;">
    <div class="text-center">
      <strong>Copyright &copy; 2020-2021 Developed </strong> All rights
    reserved.
    </div>
  </footer>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <!-- jQuery 3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../js/adminlte.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

    <script src="https://bartaz.github.io/sandbox.js/jquery.highlight.js"></script>

    <script src="//cdn.datatables.net/plug-ins/1.10.15/features/searchHighlight/dataTables.searchHighlight.min.js"></script>

    <script type="text/javascript">
      $(function() {
        //this is how datatables are created. we are getting data from refresh_job_search page using ajax
        var oTable = $('#myTable').DataTable({
          "autoWidth": false,
          "ajax" : {
            "url" : "refresh_job_search.php",
            "dataSrc" : "",
          "data" : function (d) {
              d.experience = $("#experience").val();
              d.qualification = $("#qualification").val();
            }
          }
        });

        oTable.on('draw', function() {
          var body = $(oTable.table().body());

          body.unhighlight();

          body.highlight(oTable.search());


        });

        //We only want to reload the ajax on submit button click instead of redirecting to form post page. so we use preventDefault();
        $("#myForm").on("submit", function(e) {
          e.preventDefault();
          oTable.ajax.reload( null, false);
        })

      });
    </script>

  </body>
</html>