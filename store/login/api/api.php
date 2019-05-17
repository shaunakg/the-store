<?php

header("Allow: POST, GET, OPTIONS");

// Setup MariaDB config using a user that only has access to the login database
// Note: I setup this user myself manually. The program can only access the login
// database.
$data_username="dtq-login-acc";
$data_password="123dtq_login";
$database="store_database";

// Setup a new connection between MySQL and the program
$ldata = new mysqli("localhost", $data_username, $data_password, $database); // Authenticate the user
$ldata->select_db($database) or die($ldata->error); // Select the database or exit with an error message

$req = $_SERVER['REQUEST_METHOD'];

print_r($_POST);

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $action = $_POST["action"];

    if ($action == "delete_all_usrs") {
        $auth_token = $_POST["auth_token"];

        $exists_query = "SELECT * FROM logins
        WHERE browser_token='$auth_token'";

        // $exists_query = "SELECT * FROM logins";

        // echo $exists_query;

        $res = $ldata->query($exists_query);
        $row = $res->fetch_assoc();

        if (!$row) {

            http_response_code(403);
            header("X-Error-Information: Incorrect username or password on API request", true, 403);

        } else {
            if ($row["admin"] == "1") {
                $truncate_query = "TRUNCATE TABLE logins";
                $ldata->query($truncate_query);

                header("X-Information: Successfully truncated table. Note: your authentication is no longer valid.", true);
            } else {
                http_response_code(403);
                header("X-Error-Information: Insufficient privs to complete operation (user exists, but is not admin)", true, 403);
            }
        }

    } else if ($action=="create_usr") {
        $username = $_POST["user"];
        $password = md5($_POST["password"]);
        $email = $_POST["email"];

        $rand_token = substr(md5(rand()), 0, 20);

        $create_query = "INSERT INTO logins (email, username, password,api,browser_token)
        VALUES (TRIM('$email'),TRIM('$username'),TRIM('$password'),1,TRIM('$rand_token'))";

        $ldata->query($create_query);

        header("X-Information: Successfully created user.", true, 201);

    } else if ($action == "delete_usr") {
        $self_username = $_POST["auth_user"];
        $self_password = $_POST["auth_password"];

        $auth_token = $_POST["auth_token"];

        $exists_query = "SELECT * FROM logins
        WHERE browser_token='$auth_token'";

        // $exists_query = "SELECT * FROM logins";

        // echo $exists_query;

        $res = $ldata->query($exists_query);
        $row = $res->fetch_assoc();

        if (!$row) {

            http_response_code(403);
            header("X-Error-Information: Incorrect username or password on API request", true, 403);

        } else {
            if ($row["admin"] == "1") {
                $delete_query = "DELETE FROM logins
                WHERE username='$username'
                AND password='$password'";

                $ldata->query($truncate_query);

                header("X-Information: Successfully executed SQL DELETE.", true);
            } else {
                http_response_code(403);
                header("X-Error-Information: Insufficient privs to complete operation (user exists, but is not admin)", true, 403);
            }
        }
    }
} else if ($_GET["action"] == "reset") {

    $email = $_GET['email'];
    $new_pass = $_GET["newpass"];

    $update_pw_query = "UPDATE logins
    SET password=TRIM('$new_pass')
    WHERE email=TRIM('$email')";

    $ldata->query($update_pw_query);

    header("X-Information: Completed password reset with token", true, 206);

} else if ($req == "OPTIONS" || ($req == "GET" && !isset($_GET))) {
    header("Allow: POST", true, 301);
    header("Location: README.html", true, 301);
    die();
} else {
    http_response_code(405);
    header("X-Error-Information: This is a API request page, use POST, not $req", true, 405);
}

?>