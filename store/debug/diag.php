<link rel="stylesheet" href="../stylesheet.css">

<h1>Website Debug Page</h1>
<pre>
<?php

session_start();

echo 'SESSION INFO (if none, you are not logged in) : ';
print_r($_SESSION);
echo '<br>';

?>
</pre>

<a href="../index.php" class="good-small-boxed">Go back to storefront</a> <a href="authdiag.php" class="bad-small-boxed">More Information (Authorisation Only)</a>