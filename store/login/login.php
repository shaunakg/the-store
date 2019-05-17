<html>
    <head>
        <link rel="stylesheet" href="../stylesheet.css">
    </head>
</html>

<?php

if (sizeof($_POST) < 3 && $_SERVER['REQUEST_METHOD'] == "POST") {
    http_response_code(400);
    echo '<div id="inc_pw_warn">Your browser made an error.</div><br> <b>That\'s all we know.</b><br><br>';
    echo '<pre>';
    echo 'A POST request was made with incorrect parameters.<br>This could be because you didn\'t fill in one of the fields.</pre><br>';
    echo '<br><b> Please <a href="index.php">try again.</a></b>';

    header("X-Error-Information: Direct API requests towards api/api.php, not here", true, 400);

    die();

} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
    header("Location: index.php", true, 301);
    header("X-Error-Information: Don't GET to this page! Go to index.php to fill out the login form.", true);

} else if ($_SERVER['REQUEST_METHOD'] != "GET" && $_SERVER['REQUEST_METHOD'] != "POST") {
    http_response_code(405);
    $method_not_allowed_msg = '<br>
    <h1>HTTP 405 - Method Not Allowed</h1><br>
    <b>You cannot use the method '. $_SERVER["REQUEST_METHOD"] .' on this PHP webpage!</b><br>
    <i>If you are a user on this webpage, please <a href="index.php">try again.</a></i>';

    echo $method_not_allowed_msg;
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

$action = $_POST["action"];
$username = $ldata->real_escape_string(trim(htmlentities($_POST['username'])));

if ($_POST['rempw'] == "y") {
    $password = $ldata->real_escape_string(trim($_POST['password']));
} else {
    $password = $ldata->real_escape_string(trim(md5(htmlentities($_POST['password']))));
}


$email = $ldata->real_escape_string(trim(htmlentities($_POST['email'])));

if ($action=="login") {
    $exists_query = "SELECT * FROM logins
    WHERE username='$username'
    AND password='$password'";

    // $exists_query = "SELECT * FROM logins";

    // echo $exists_query;

    $res = $ldata->query($exists_query);
    $row = $res->fetch_assoc();

    if (!$row) {
        $incorrect_password_warning = '<div id="inc_pw_warn">
        Warning: Your username or password is incorrect.<br>
        Please <a href="index.php">try again.</a></div>';

        echo $incorrect_password_warning;
    } else {

        if (isset($_POST['remember'])) {
            setcookie("browser_token", $row["browser_token"], time() + (86400 * 30), "/");
        }

        session_start();
        $_SESSION = array_merge($_SESSION,$row);
        $ruser = $row["username"];

        if ($_GET["showPage"]) {
            echo '<h1 id="correct_success_title">Logged in successfully!</h1>';
            echo '<a class="good-small-boxed" href="../">Go to the store</a><br>';
            echo '<br><div id="login_info">You are logged in as: ' . $ruser . '</div><br><br><br>';
        } else {
            header("Location:../",true,303);
            die();
        }

    }

} elseif ($action=="create") {

    if (ISSET($_POST['admin'])) {
        $user_admin = true;
    } else {
        $user_admin = false;
    }

    $rand_token = substr(md5(rand()), 0, 20);

    $create_query = "INSERT INTO logins (email, username, password, admin, browser_token)
    VALUES (TRIM('$email'),TRIM('$username'),TRIM('$password'),TRIM('$user_admin'),TRIM('$rand_token'))";

    $check_exists_query = "SELECT * FROM logins
    WHERE username='$username'";
    $ce_result = $ldata->query($check_exists_query);

    $ce_row = $ce_result->fetch_assoc();

    if (ISSET($ce_row) || $_POST['username']=="all_users") {
        header('Location: index.php?exists=1', true, 301);
        die();
    }

    if ($ldata->query($create_query) === TRUE) {
        echo('<div id="correct_success_title">Created login information! <a class="good-small-boxed" href="index.php">Login now</a></div>');
    } else {
        echo("Error $ldata->error");
    }
}

?>