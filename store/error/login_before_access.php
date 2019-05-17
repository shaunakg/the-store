<link rel="stylesheet" href="../stylesheet.css">

<centre>
	<h1>You can't access this page without login</h1>
	<h3> <a class="good-small-boxed" href="../">Go back to store</a>  <a class="good-small-boxed" href="../login/index.php">Login again</a></h3><br>
	<pre id="debug">Debug: unauthorised access without login.</pre>
<centre>

<?php

http_response_code(401);

if (ISSET($_SESSION['username'])) {
	header("Location: ../index.php", true, 303);
	die();
}

?>

