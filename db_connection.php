<?php

require_once 'config.php';

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($con->connect_error) {
    error_log("Connection failed: " . $con->connect_error);

    die("Sorry, we're experiencing some technical difficulties. Please try again later.");
}
