<?php

//To Handle Session Variables on This Page
session_start();

//Including Database Connection From db.php file to avoid rewriting in all files
require_once("../db.php");

if(isset($_POST)) {

	$stmt = $conn->prepare("DELETE FROM job_post WHERE id_jobpost=? AND id_company=?");

	$stmt->bind_param("ii", $_GET['id'], $_SESSION['id_user']);

	if($stmt->execute()) {
		//If data Deleted successfully then redirect to index
		$_SESSION['jobPostDeleteSuccess'] = true;
		header("Location: index.php");
		exit();
	} else {

		echo "Error " . $sql . "<br>" . $conn->error;
	}

	$stmt->close();
	$conn->close();

} else {
	header("Location: index.php");
	exit();
}