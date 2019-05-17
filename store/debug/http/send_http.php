<?php

if ($code = $_GET['code']) {
    http_response_code($code);
    header("User triggered HTTP error $code", true, $code);
} else {
    echo 'Warning: Enter a code in the URL';
}

?>