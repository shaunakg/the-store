<link rel="stylesheet" href="../stylesheet.css">

<?php

if (!ISSET($_SESSION)) {
	session_start();
}

if (!ISSET($_SESSION['username'])) {
	header("Location: ../error/login_before_access.php", true, 303);
	die();
}

$session_usr = $_SESSION['username'];

// Setup MariaDB config using a user that only has access to the login database
// Note: I setup this user myself manually. The program can only access the login
// database.
$data_username="dtq-login-acc";
$data_password="123dtq_login";
$database="store_database";

// Setup a new connection between MySQL and the program
$ldata = new mysqli("localhost", $data_username, $data_password, $database); // Authenticate the user
$ldata->select_db($database) or die($ldata->error); // Select the database or exit with an error message

?>

<html>

<title>Webmail | Shop Version 5.0</title>

<centre><h1 class="good-title">User Webmail</h1></centre>

<br><br>

<form id="webmailform" action="send.php" method="POST">
<table style="width:100%;">
	<tr>
		<td><strong>To</strong></td>
		<td class="text-table"><input class="text-table" type="text" name="to" placeholder="user01"></td>
	</tr><tr>
		<td><strong>Subject</strong></td>
		<td class="text-table"><input class="text-table" type="text" name="subject" placeholder="Loving this website"></td>
	</tr><tr>
		<td><strong>Contents</strong></td>
		<td class="text-table"><input class="text-table" height=5 type="textarea" name="contents" placeholder="Really loving this entire site."></td>
	</tr>
</table><br>
<input type="hidden" name="from" value="<?php echo $_SESSION['username'];?>" style="display:none;">
<input type="submit" value="Send">
</form><br><br>

<?php

if (ISSET($_GET['sent'])) {
	echo '<strong>Message Sent!</strong><br><br>';
}

?>

<table style="width:100%" class="centre">
	<tr>
		<th>Timestamp</th>
		<th>From</th>
		<th>To</th>
		<th>Subject</th>
		<th>Contents</th>
	</tr>

</html>

<?php

$select_query = "SELECT * FROM user_webmail
WHERE to_user='$session_usr'
OR to_user='all_users'";

$result_unformatted = $ldata->query($select_query);

$all = [];
while ($row = $result_unformatted->fetch_assoc()) {
	array_push($all, $row);
}

foreach ($all as $message) {

	$timestamp = $message['timestamp'];
	$from = $message['from_user'];
	$to = $message['to_user'];
	$subject = $message['subject'];
	$contents = $message['contents'];

	echo "<tr><td>$timestamp</td>";
	echo "<td>$from</td>";
	echo "<td>$to</td>";
	echo "<td>$subject</td>";
	echo "<td>$contents</td>";
	echo '</tr>';
}

?>

</table><br>

<a href="../index.php" class="bad-small-boxed">Back</a><br><br>
<p></p>