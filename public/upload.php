<?php
session_start();
include("connection.php");
include("functions.php");

$user_data = check_login($connect);

$id = $user_data['user_id'];

if (isset($_POST['submit'])) {
    $file = $_FILES['file'];

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExtension = explode(".", $fileName);
    $fileExt = strtolower(end($fileExtension));

    $allow = array("png");

    if (in_array($fileExt, $allow)) {
        if ($fileError === 0) {
            if ($fileSize < 1000000) {
                $fileNameEncoded = "profile" . $id . "." . $fileExt;
                $fileDir = "uploads/" . $fileNameEncoded;
                move_uploaded_file($fileTmpName, $fileDir);
                $query = "UPDATE profile_img SET status = 1 WHERE userId = '$id';";
                $result = mysqli_query($connect, $query);

                header("Location: profile.php?uploadsuccess");
            } else {
                echo "Your file is too big";
            }
        } else {
            echo "Error uploading file";
        }
    } else {
        echo "Invalid file type.";
    }
}