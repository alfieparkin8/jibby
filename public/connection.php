<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "login";

if (!$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)) {
    die('Failed to connect');
}