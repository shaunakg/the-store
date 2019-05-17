<link rel="stylesheet" href="stylesheet.css">

<?php

session_start();

if (isset($_SESSION['username'])) {

	$welctext = 'Welcome, '.$_SESSION['username'];
	$loginoutlink = "login/logout.php";
	$logtext = "Log out";

	if ($_SESSION['admin'] == 1) {
		$admin = true;
	} else {
		$admin = false;
	}

} else {
	$welctext = "[not logged in]";
	$loginoutlink = "login/index.php";
	$logtext = "Log in";
	$admin = false;
}

?>
<div class="navbar">

	<div class="dropdown">

		<button class="dropbtn"><?php echo $welctext;?></button>
		<div class="dropdown-content">
			<a href="<?php echo $loginoutlink;?>"><?php echo $logtext;?></a>

			<?php

			if ($admin) {
				echo '<a class="placeholder" target=none>Secure Pages [Admin]</a>';
				echo '<a href="auth/all_webmail.php">[Δ] All Webmail</a>';
				echo '<a href="auth/all_transactions.php">[Δ] All Transactions</a>';
				echo '<a href="auth/new_item.php">[Δ] New Catalog Item</a>';
				echo '<a href="auth/topup.php">[Δ] User Balances & Topup</a>';
				echo '<a class="hover-hidden" href="debug/diag.php">Store Debug (5.0)</a>';
			} else {
				echo '<a class="hover-hidden" target=none>Store Version 5.0</a>';
			}

			?>
		</div>

	</div>


	<div class="navbar-right">

			<a href="mail/index.php">My Webmail</a>
			<a href="shop/transactions.php">My Transactions</a>
			<a href="shop/catalog.php">Catalog</a>

	</div>
</div>
<br>

<center><h1 class="hover-orange">Welcome To <strong>The Store</strong></h1></center>

<center><fieldset>
	<p class="left-padded">
		<h2>Features</h2>
		Secure login - MD5 hashed passwords stored in a database<br>
		Catalog - The catalog includes many products<br>
		Starting balance - Every user gets $1,000,000 to use on startup<br>
		Webmail - Chat with other users<br>
	</p>
</fieldset></center>

