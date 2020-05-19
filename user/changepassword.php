<?php

//To Handle Session Variables on This Page
session_start();

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("../db.php");

if(isset($_POST)) {

	$pass = base64_encode(strrev(md5($_POST['old_pass'])));
	//sql query to check if email already exists or not
	$sql = "SELECT * FROM users WHERE password='$pass' AND id_user='$_SESSION[id_user]'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {

		//Encrypt Password
		$password = base64_encode(strrev(md5($_POST['new_pass'])));

		//sql new registration insert query
		$sql = "UPDATE users SET password='$password' WHERE password='$pass' AND id_user='$_SESSION[id_user]'";

		if($conn->query($sql)===TRUE) {
			$_SESSION['passwordChanged'] = true;
			header("Location: settings.php");
			exit();
		} else {
			//If data failed to insert then show that error. Note: This condition should not come unless we as a developer make mistake or someone tries to hack their way in and mess up :D
			echo "Error " . $sql . "<br>" . $conn->error;
		}
	} else {
		//if email found in database
		$_SESSION['passwodNotFoundError'] = true;
		header("Location: settings.php");
		exit();
	}

	//Close database connection. Not compulsory but good practice.
	$conn->close();

} else {
	//redirect them back to forgot-password.php page if they didn't click Forgot Password button
	header("Location: settings.php");
	exit();
}