<?php

header("Allow: POST");

// Setup MariaDB config using a user that only has access to the login database
// Note: I setup this user myself manually. The program can only access the login
// database.

$data_username="dtq-login-acc";
$data_password="123dtq_login";
$database="store_database";

// Setup a new connection between MySQL and the program
$ldata = new mysqli("localhost", $data_username, $data_password, $database); // Authenticate the user
$ldata->select_db($database) or die($ldata->error); // Select the database or exit with an error message

if (isset($_COOKIE["browser_token"])) {
    $browser_token = $_COOKIE["browser_token"];

    $find_query = "SELECT * FROM logins
    WHERE browser_token='$browser_token'";

    $res = $ldata->query($find_query);
    $row = $res->fetch_assoc();

    $username = $row['username'];
    $password = $row['password'];
    $email = $row['email'];
    $rempw = "y";
    $disabled = "true";

} else {
    $username = "";
    $password = "";
    $email = "";
    $rempw = "";
    $disabled = "";
}

?>

<link rel="stylesheet" href="../stylesheet.css">

<center>

<h1 class="good-title">Store Login</h1><br>

<form action="login.php" method="post" id="form-monospace">
    <div id="emailInput">eMail Ad: <input type="text" name="email" value="<?php echo $email?>"></div>
    Username: <input type="text" name="username" value="<?php echo $username?>" required><br>
    Password: <input type="password" name="password" value="<?php echo $password?>" require><br>
    <div id="adminCheckBox">Admin? <input type="checkbox" name="admin" value="yeet"></div>
    <input type="radio" name="action" value="login" onchange="showOptionsOnChange();" checked> Returning User <input type="radio" name="action" value="create" onchange="showOptionsOnChange();"> New User
    <div id="rememberCheckBox"><input type="checkbox" name="remember"> Remember Me</div><br><br>
    <input type="submit" name="go" value="Login" class="go-small-boxed">
    <a href="../index.php" class="neutral-small-boxed">Skip Login</a><br><br><br>
    <a href="forgot.php" class="bad-small-boxed">Forgot your password?</a><br>
    <input type="hidden" value="<?php echo $rempw?>" name="rempw">
</form>

<?php

if (ISSET($_GET['exists'])) {
    echo '<br><strong>That user already exists.</strong><br>';
}

?>

<br><p id="bottom-info">
    PULSAR INC STORE VERSION 5.0<br>
    Copyright &COPY; 2019 Shaunak G.<br>
    <a href="../_sitemap.html">[Sitemap]</a>
</p>

<script>

document.getElementById("adminCheckBox").style.visibility = "hidden";
document.getElementById("emailInput").style.visibility = "hidden";

function showOptionsOnChange() {
    var action = document.querySelector('input[name="action"]:checked').value;
    if (action == "login") {
        document.getElementById("adminCheckBox").style.visibility = "hidden";
        document.getElementById("emailInput").style.visibility = "hidden";
        document.getElementById("rememberCheckBox").style.visibility = "visible";
    } else {
        document.getElementById("adminCheckBox").style.visibility = "visible";
        document.getElementById("emailInput").style.visibility = "visible";
        document.getElementById("rememberCheckBox").style.visibility = "hidden";
    }
}
</script>

</center>