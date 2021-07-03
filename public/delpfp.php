<?php
session_start();
include("connection.php");
include("functions.php");
$user_data = check_login($connect);
$id = $user_data['user_id'];
$query = "SELECT * FROM profile_img WHERE userId = '$id' AND status = 1 LIMIT 1;";

$result = mysqli_query($connect, $query);

if ($result) {
    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        // If has a profile picture linked
        $query2 = "UPDATE profile_img SET status = 0 WHERE userId = '$id';";
        //Set status to 0
        mysqli_query($connect, $query2);
        header("Location: profile.php");
        die;
    }
}