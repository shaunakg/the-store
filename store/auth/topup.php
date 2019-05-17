<link rel="stylesheet" href="../stylesheet.css">

<?php

session_start();

if (!ISSET($_SESSION['username'])) {
	header("Location: ../error/login_before_access.php", true, 303);
	die();
} else if ($_SESSION["admin"] != 1) {
	header("Location: ../error/login_before_access.php", true, 303);
	die();
}

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

<centre><h1 class="bad-title">User Balance</h1></centre><br>

<table style="width:100%" class="centre">
	<tr>
		<th>User</th>
		<th>Balance</th>
	</tr>

<?php

$current_user = $_SESSION['username'];

$select_query = "SELECT * FROM logins";

$result_unformatted = $ldata->query($select_query);

// echo '<pre>';
// print_r($result_unformatted);
// echo '</pre>';

$all = [];
while ($row = $result_unformatted->fetch_assoc()) {
	array_push($all, $row);
}


foreach ($all as $user) {

	$username = $user['username'];
	$balance = $user['user_balance'];

	echo "<tr><td>$username</td>";
	echo "<td>$$balance</td>";
	echo '</tr>';
}

?>

</table><br><br>

<form action="" method="POST">
<table style="width:100%" class="centre">
	<tr>
		<th>User</th>
		<th>Balance Topup Amount</th>
	</tr><tr>
		<td><input style="width:100%" type="text" name="username" placeholder="Enter username" required></td>
		<td><input style="width:100%" type="number" name="amount" placeholder="Enter amount (Negative for debit)" required></td>
	</tr>
</table>
<br>
<input type="submit" name="go" value="Topup">
<a href="../index.php" class="bad-small-boxed">Back</a>
</form><br>

<?php

if (ISSET($_POST["go"])) {

	if (!ISSET($_SESSION['username'])) {
		header("Location: ../error/login_before_access.php", true, 303);
		die();
	} else if ($_SESSION["admin"] != 1) {
		header("Location: ../error/login_before_access.php", true, 303);
		die();
	}

	// Setup MariaDB config using a user that only has access to the login database
	// Note: I setup this user myself manually. The program can only access the login
	// database.
	$data_username="dtq-login-acc";
	$data_password="123dtq_login";
	$database="store_database";

	// Setup a new connection between MySQL and the program
	$ldata = new mysqli("localhost", $data_username, $data_password, $database); // Authenticate the user
	$ldata->select_db($database) or die($ldata->error); // Select the database or exit with an error message

	$username = $_POST['username'];
	$amount = $_POST['amount'];

	$admin_user = $_SESSION['username'];

	$get_current_balance_query = "SELECT * FROM logins WHERE username='$username'";
	$result_unformatted = $ldata->query($get_current_balance_query);
	$row = $result_unformatted->fetch_assoc();
	$new_balance = $row['user_balance'] + $amount;

	if ($new_balance<0) {
		echo '<strong>Balance cannot be less than 0, please try again.</strong>';
		die();
	}

	$transaction_record_query = "INSERT INTO user_transaction_records (username, type, item_bought, item_price, current_balance)
	VALUES ('$username','admin_topup','Topup by admin: $admin_user','-$amount','$new_balance')";

	$update_balance_query = "UPDATE logins
	SET user_balance='$new_balance'
	WHERE username='$username'";

	$user_exists_query = "SELECT * FROM logins
	WHERE username='$username'";
	$ue_unformatted = $ldata->query($user_exists_query);
	$ue_row = $ue_unformatted->fetch_assoc();
	if (ISSET($ue_row)) {
		if ($ldata->query($update_balance_query) === TRUE) {
			echo '<b>Finished updating balance. New balance is now: $' . $new_balance . '</b>';
			$ldata->query($transaction_record_query);
			$_POST = 0;
		} else {
			echo "Error: " . $update_query . "<br>" . $grades_database->error;
		}
	} else {
		echo '<b>Error: Please choose a user that exists.</b>';
	}

}