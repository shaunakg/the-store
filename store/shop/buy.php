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

$item_code = $_POST['item_id'];

$current_username = $_SESSION['username'];
$current_user_balance_query = "SELECT * FROM logins WHERE username='$current_username'";
$cub_result = $ldata->query($current_user_balance_query);
$cub_row = $cub_result->fetch_assoc();
$current_user_balance = $cub_row['user_balance'];

$current_product_query = "SELECT * FROM items WHERE item_code='$item_code'";
$current_product_result = $ldata->query($current_product_query);
$current_product_row = $current_product_result->fetch_assoc();
$current_product_price = $current_product_row['item_cost'];
$current_product_name = $current_product_row['item_name'];

$new_user_balance = $current_user_balance-$current_product_price;

if ($new_user_balance<0) {
	header("Location: ../error/catalog_product_too_expensive.php/?caccount=$current_user_balance&newproduct=$current_product_price", true, 303);
	die();
}

?>

<h1 class="bad-title">Transaction</h1><br>

<strong>You're about to conduct a transaction with the store. Here are the details.</strong>

<ul>
	<li>USER ID: <?php echo $current_username; ?></li>
	<li>Transaction Amount: $<?php echo $current_product_price; ?></li>
	<br><br>
	<li>Product Name: <?php echo $current_product_name; ?></li>
	<li>Product Description: <?php echo $current_product_row['item_description']; ?> </li>
	<br><br>
	<li>Account Balance (Current): $<?php echo $current_user_balance; ?> </li>
	<li>Account Balance (After Purchase): $<?php echo $new_user_balance; ?> </li>
</ul>

<br><br>

<div style="background-color:lightblue;padding:15px">
<br>
<strong>Do you want to continue with the purchase?</strong><br><br>
<form action="" method="POST"><input type="submit" name="do_purchase" value="Purchase"><input type="hidden" size="1" name="item_id" value="<?php echo $item_code; ?>">    <a href="catalog.php" class="bad-small-boxed">Cancel</a></form>
</div>

<?php

if (ISSET($_POST['do_purchase'])) {

	// Setup MariaDB config using a user that only has access to the login database
	// Note: I setup this user myself manually. The program can only access the login
	// database.
	$data_username="dtq-login-acc";
	$data_password="123dtq_login";
	$database="store_database";

	// Setup a new connection between MySQL and the program
	$ldata = new mysqli("localhost", $data_username, $data_password, $database); // Authenticate the user
	$ldata->select_db($database) or die($ldata->error); // Select the database or exit with an error message

	$item_code = $_POST['item_id'];

	$current_username = $_SESSION['username'];
	$current_user_balance_query = "SELECT * FROM logins WHERE username='$current_username'";
	$cub_result = $ldata->query($current_user_balance_query);
	$cub_row = $cub_result->fetch_assoc();
	$current_user_balance = $cub_row['user_balance'];

	$current_product_query = "SELECT * FROM items WHERE item_code='$item_code'";
	$current_product_result = $ldata->query($current_product_query);
	$current_product_row = $current_product_result->fetch_assoc();
	$current_product_price = $current_product_row['item_cost'];
	$current_product_name = $current_product_row['item_name'];

	$new_user_balance = $current_user_balance-$current_product_price;

	if ($new_user_balance<0) {
		header("Location: ../error/catalog_product_too_expensive.php/?caccount=$current_user_balance&newproduct=$current_product_price", true, 303);
		die();
	}

	$transaction_record_query = "INSERT INTO user_transaction_records (username, item_bought, item_price, current_balance)
	VALUES ('$current_username','$item_code','$current_product_price','$new_user_balance')";

	$transaction_do_query = "UPDATE logins
	SET user_balance='$new_user_balance'
	WHERE username='$current_username'";

	$transaction_do = $ldata->query($transaction_do_query);
	$transaction_record = $ldata->query($transaction_record_query);

	echo '<br><br><strong>Your purchase has been processed. Thank you!';
	echo '<br><br><a href="catalog.php" class="good-small-boxed">Take me back to the catalog</a>';
}

?>