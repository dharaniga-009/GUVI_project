<?php

$hostName = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "login_register";
$conn = mysqli_connect('localhost', 'root', '', 'login_register');
if (!$conn) {
    die("Something went wrong;");
}

?>