<?php
session_start();
include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if (!empty($user_name) && !empty($password) && !empty($email) && !is_numeric($user_name)) {

        $query = "SELECT * FROM users WHERE user_name = '$user_name' limit 1";

        $result = mysqli_query($connect, $query);

        if ($result) {
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                echo "<script>alert('Username Taken')</script>";
            } else {
                $user_id = random_num(20);
                $query = "INSERT INTO users(user_id, email, user_name, password) values ('$user_id', '$email','$user_name', '$password')";

                mysqli_query($connect, $query);

                $query2 = "INSERT INTO profile_img(userId, status) VALUES ('$user_id', 0)";

                mysqli_query($connect, $query2);

                header("Location: login.php");
                die;
            }
        }
    } else {
        echo "<script>alert('Please enter some valid Information')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <link rel='stylesheet' type='text/css' href='index.css?version=2'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Sign Up Form</title>
</head>

<body>
    <div class="header">
        <h1>Jibby<span class="righty white">Sign Up</span></h1>
    </div>
    <div id="box">
        <form method="post">
            <span class="white">Email</span>
            <input class="text" type="email" name="email"><br><br>
            <span class="white">Username</span>
            <input class="text" type="text" name="user_name"><br><br>
            <span class="white">Password</span>
            <input class="text" type="password" name="password"><br><br>
            <input id="button" type="submit" value="Sign Up"><br><br>
            <a href="login.php" class="righty white">Click to Login In</a><br><br>
        </form>
    </div>
</body>

</html>