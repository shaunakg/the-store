<link rel="stylesheet" href="../../stylesheet.css">

<?php

$account = $_GET['caccount'];
$price = $_GET['newproduct'];

?>

<h1>Warning: Your account balance is too low to buy this product.</h1>
<?php
	echo('<centre>Your account balance is $' . $account . ', while the product costs $' . $price . '.</centre><br><br>');
?>
<centre><a class="good-small-boxed" href="../../shop/catalog.php">Take me back to the catalog</a></centre>