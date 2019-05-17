<link rel="stylesheet" href="../stylesheet.css">

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

?>

<form action="" method="POST">

<table style="width:100%">
	<tr>
		<th>Item Store Code</th>
		<th>Item Common Name</th>
		<th>Item Price</th>
		<th>Item Image URL</th>
		<th>Item Description</th>
	</tr><tr>
		<td><input type="text" placeholder="apple_macbookpro13inch" name="item_code" style="width:100%" required></td>
		<td><input type="text" placeholder="Apple Macbook Pro (13 Inch) With Retina Display" name="item_name" style="width:100%" required></td>
		<td><input type="number" placeholder="7500" name="item_price" style="width:100%" required></td>
		<td><input type="text" placeholder="https://images-na.ssl-images-amazon.com/images/I/61GJPL1hCpL._SL1500_.jpg" name="item_img_url" style="width:100%" required></td>
		<td><input type="textarea" placeholder="[Macbook Description]" name="item_desc" style="width:100%" required></td>
	</tr>
</table><br>

<input type="submit" value="Enter Item" name="submit">    <a href="../shop/catalog.php" class="good-small-boxed">To Catalog</a>    <a href="../index.php" class="bad-small-boxed">Back</a>

</form>

<?php

if (ISSET($_POST['submit'])) {

	$item_code = $ldata->real_escape_string($_POST["item_code"]);
	$item_name = $ldata->real_escape_string($_POST["item_name"]);
	$item_price = $ldata->real_escape_string($_POST["item_price"]);
	$item_img_url = $ldata->real_escape_string($_POST["item_img_url"]);
	$item_desc = $ldata->real_escape_string($_POST["item_desc"]);

	$query = "INSERT INTO items (item_code, item_name, item_cost, item_img_url, item_description)
	VALUES ('$item_code','$item_name','$item_price','$item_img_url','$item_desc')";

	$ldata->query($query);

	echo '<br>Inserted item into table';
}


?>