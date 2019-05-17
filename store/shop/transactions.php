<link rel="stylesheet" href="../stylesheet.css">

<?php

session_start();

if (!ISSET($_SESSION['username'])) {
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

<centre><h1 class="bad-title">User Transaction Record</h1></centre><br>

<table style="width:100%" class="centre">
	<tr>
		<th>Time of Transaction</th>
		<th>Transaction Type</th>
		<th>User</th>
		<th>Item Code</th>
		<th>Price</th>
		<th>Balance After Transaction</th>
	</tr>

<?php

$current_user = $_SESSION['username'];

$select_query = "SELECT * FROM user_transaction_records WHERE username='$current_user'";

$result_unformatted = $ldata->query($select_query);

// echo '<pre>';
// print_r($result_unformatted);
// echo '</pre>';

$all = [];
while ($row = $result_unformatted->fetch_assoc()) {
	array_push($all, $row);
}


foreach ($all as $entry) {

	$timestamp = $entry['timestamp'];
	$username = $entry['username'];
	$item_code = $entry['item_bought'];
	$price = $entry['item_price'];
	$balance = $entry['current_balance'];
	$type = $entry['type'];

	echo "<tr><td>$timestamp</td>";
	echo "<td>$type</td>";
	echo "<td>$username</td>";
	echo "<td>$item_code</td>";
	echo "<td>$".$price."</td>";
	echo "<td>$".$balance."</td>";
	echo '</tr>';
}

echo "<h2>Current Balance: $".$balance;

?>

</table>
<br><br>
<a href="../index.php" class="bad-small-boxed">Back</a><br>