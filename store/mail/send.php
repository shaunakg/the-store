<?php

// Setup MariaDB config using a user that only has access to the login database
// Note: I setup this user myself manually. The program can only access the login
// database.
$data_username="dtq-login-acc";
$data_password="123dtq_login";
$database="store_database";

// Setup a new connection between MySQL and the program
$ldata = new mysqli("localhost", $data_username, $data_password, $database); // Authenticate the user
$ldata->select_db($database) or die($ldata->error); // Select the database or exit with an error message

if (!ISSET($_SESSION)) {
	session_start();
}

if (!ISSET($_SESSION['username'])) {
	header("Location: ../error/login_before_access.php", true, 303);
	die();
}

$session_usr = $_SESSION['username'];

if (ISSET($_POST)) {
	$from = $_POST['from'];
	$to = $_POST['to'];
	$subject = $_POST['subject'];
	$contents = $_POST['contents'];

	$send_query = "INSERT INTO user_webmail (to_user,from_user,subject,contents)
	VALUES ('$to','$from','$subject','$contents')";

	$ldata->query($send_query);

	header("Location: index.php?sent=1", true, 301);
	die();
} else {
	header("Location: index.php", true, 301);
	die();
}