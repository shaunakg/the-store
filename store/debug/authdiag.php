<link rel="stylesheet" href="../stylesheet.css">


<?php

session_start();

if ($_SESSION['admin'] == 1) {
    echo 'Authorised Access!';
} else {
    echo 'Please <a class="bad-small-boxed" href="../login/index.php">login</a> with an authorised account to access this secure page.<br><br>Or, <a class="good-small-boxed" href="../index.php"> go back to the storefront </a>';
}

?>