<link rel="stylesheet" href="../stylesheet.css">

<?php

if (!ISSET($_SESSION)) {
	session_start();
}

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

<title>Catalog | Shop Version 5.0</title>

<centre><h1 class="good-title">Store Catalog</h1></centre><br>

<table style="width:100%" class="centre">
	<tr>
		<th>Picture</th>
		<th>Item</th>
		<th>Description</th>
		<th>Price</th>
		<th>Options</th>
	</tr>

<?php

$select_query = "SELECT * FROM items";

$result_unformatted = $ldata->query($select_query);

$all = [];
while ($row = $result_unformatted->fetch_assoc()) {
	array_push($all, $row);
}

foreach ($all as $item) {
	echo '<tr><td class="image-td"><img src="'.$item["item_img_url"].'" class="image-td"></td>';
	echo '<td>' . $item["item_name"] . '</td>';
	echo '<td>' . $item["item_description"] . '</td>';
	echo '<td>$' . $item["item_cost"] . '</td>';
	echo '<td><form action="buy.php" method="POST"><input type="text" name="item_id" value="'. $item["item_code"] . '" size="1" class="hidden-input"><input type="submit" value="Buy Now"></form></td>';
	echo '</tr>';
}

?>

</table><br>

<a href="../index.php" class="bad-small-boxed">Back</a><br><br>
<p></p>