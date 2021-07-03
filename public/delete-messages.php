<?php
session_start();
include("connection.php");
include("functions.php");
$user_data = check_login($connect);
$query = "DELETE FROM messages";

$result = mysqli_query($connect, $query);

if ($result) {
    echo "<script>alert('Messages Deleted')</script>";
    header("Location; messages.php");
    die;
}