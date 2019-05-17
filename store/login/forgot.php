<html>

<link rel="stylesheet" href="../stylesheet.css">

<h1 id="pw-reset-title">Password Reset Form</h1>

<p>Use this form to reset your password if you have forgotten it.</p>

<head>
    <link rel="stylesheet" href="stylesheet.css">
</head>

<form action="" id="form-monospace" method="POST">
    Your email: <input type="text" name="email"><br>
    Username: <input type="text" name="user"><br>
    New password: <input type="password" name="password"><br><br>
    <input type="submit" name="go">  <a class="bad-small-boxed" href="login.php">I know my password, take me back to the store</a>
</form>

</html>

<?php

function siteURL() {
    return sprintf(
        "%s://%s%s",
        isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
        $_SERVER['SERVER_NAME'],
        $_SERVER['REQUEST_URI']
    );
}

$SITE_URL = siteURL();

if (isset($_POST['go'])) {
    $email = $_POST['email'];
    $user = $_POST['user'];
    $password = md5($_POST['password']);

    $url = "$SITE_URL/../api/api.php?action=reset&email=$email&newpass=$password";

    echo "<a class=\"good-small-boxed\" href=$url>Click here to reset your password</a>";

    // $to = "gadkari.shaunak@gmail.com";
    // $subject = "My subject";
    // $txt = "Hello world!";
    // $headers = "From: $to" . "\r\n" .
    // "CC: somebodyelse@example.com";

    // mail($to,$subject,$txt,$headers);
}