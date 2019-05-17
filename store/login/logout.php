<link rel="stylesheet" href="../stylesheet.css">

<?php

session_start();

$ses_back = $_SESSION;

session_destroy();

?>

<centre>
<h1>Logged out successfully</h1>
<h3> <a class="medium-boxed-button" href="../">Go back to store</a>  <a class="medium-boxed-button" href="index.php">Login again</a></h3><br>
<pre id="debug">Debug: session state destroyed successfully.</pre>
<centre>
