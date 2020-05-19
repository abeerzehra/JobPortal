
<?php

//To Handle Session Variables on This Page
session_start();

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("../db.php");

?>
<script type="text/javascript">
  $(document).ready(function() {

  $('#first_form').submit(function(e) {
    e.preventDefault();
    var first_name = $('#fname').val();
    var last_name = $('#lname').val();
    var email = $('#email').val();
    var password = $('#password').val();

    $(".error").remove();

    if (first_name.length < 1) {
      $('#first_name').after('<span style = "color: red" class="error">This field is required</span>');
    }
    if (last_name.length < 1) {
      $('#last_name').after('<span style = "color: red" class="error">This field is required</span>');
    }
    if (email.length < 1) {
      $('#email').after('<span style = "color: red" class="error">This field is required</span>');
    } 
    if (password.length < 8) {
      $('#password').after('<span style = "color: red" class="error">Password must be at least 8 characters long</span>');
    }
  });

});
</script>

<?php
//If user Actually clicked register button
if(isset($_POST)) {

	//Escape Special Characters In String First
	$firstname = mysqli_real_escape_string($conn, $_POST['fname']);
	$lastname = mysqli_real_escape_string($conn, $_POST['lname']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	//Encrypt Password
	$password = base64_encode(strrev(md5($password)));
	

	//sql query to check if email already exists or not
	$sql = "SELECT email FROM users WHERE email='$email'";
	$result = $conn->query($sql);

	//if email not found then we can insert new data
	if($result->num_rows == 0) {

		$hash = md5(uniqid());


		//sql new registration insert query
		$sql = "INSERT INTO users(firstname, lastname, email, password, hash) VALUES ('$firstname', '$lastname', '$email', '$password', '$hash')";

		if($conn->query($sql)===TRUE) {
			// Send Email

			// $to = $email;

			// $subject = "Job Portal - Confirm Your Email Address";

			// $message = '
			
			// <html>
			// <head>
			// 	<title>Confirm Your Email</title>
			// <body>
			// 	<p>Click Link To Confirm</p>
			// 	<a href="yourdomain.com/verify.php?token='.$hash.'&email='.$email.'">Verify Email</a>
			// </body>
			// </html>
			// ';

			// $headers[] = 'MIME-VERSION: 1.0';
			// $headers[] = 'Content-type: text/html; charset=iso-8859-1';
			// $headers[] = 'To: '.$to;
			// $headers[] = 'From: hello@yourdomain.com';
			// //you add more headers like Cc, Bcc;

			// $result = mail($to, $subject, $message, implode("\r\n", $headers)); // \r\n will return new line. 

			// if($result === TRUE) {

			// 	//If data inserted successfully then Set some session variables for easy reference and redirect to login
			// 	$_SESSION['registerCompleted'] = true;
			// 	header("Location: login.php");
			// 	exit();

			// }

			// //If data inserted successfully then Set some session variables for easy reference and redirect to login
			$_SESSION['registerCompleted'] = true;
			//Activating user becaus eof email error if you want to activate email verification remove this.
			$sql = "UPDATE users SET active='1' WHERE email='$email' AND hash='$hash'";
			$conn->query($sql);
			header("Location: user-login.php");
			exit();
		} else {
			//If data failed to insert then show that error. Note: This condition should not come unless we as a developer make mistake or someone tries to hack their way in and mess up :D
			echo "Error " . $sql . "<br>" . $conn->error;
		}
	} else {
		//if email found in database then show email already exists error.
		$_SESSION['registerError'] = true;
		header("Location: user-register.php");
		exit();
	}

	//Close database connection. Not compulsory but good practice.
	$conn->close();

} else {
	//redirect them back to register page if they didn't click register button
	header("Location: user-register.php");
	exit();
}