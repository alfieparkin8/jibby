<?php
session_start();
include("connection.php");
include("functions.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];

    if (filter_var($user_name, FILTER_VALIDATE_EMAIL) && !empty($password)) {
        $query = "SELECT * FROM users WHERE email = '$user_name' limit 1";

        $result = mysqli_query($connect, $query);

        if ($result) {
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                if ($user_data['password'] === $password) {
                    $_SESSION['user_id'] = $user_data['user_id'];
                    header("Location: index.php");
                    die;
                }
            }
        }
    }

    if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
        $query = "SELECT * FROM users WHERE user_name = '$user_name' limit 1";

        $result = mysqli_query($connect, $query);

        if ($result) {
            if ($result && mysqli_num_rows($result) > 0) {
                $user_data = mysqli_fetch_assoc($result);
                if ($user_data['password'] === $password) {
                    $_SESSION['user_id'] = $user_data['user_id'];
                    header("Location: index.php");
                    die;
                }
            }
        }
        echo "<script>alert('Incorrect Username/Password')</script>";
    } else {
        echo "<script>alert('Please enter some valid Information')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang='en'>

<head>
    <link rel='stylesheet' type='text/css' href='index.css?version=3'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Login Form</title>
</head>

<body>
    <div class="header">
        <h1>Jibby<span class="righty white">Login</span>
        </h1>
    </div>
    <div id="box">
        <form method="post">
            <span class="white">Username/Email</span>
            <input class="text" type="text" name="user_name"><br><br>
            <span class="white">Password</span>
            <input class="text" type="password" name="password"><br><br>
            <input id="button" type="submit" value="Login"><br><br>
            <a href="signup.php" class="righty white">Click to Sign Up</a><br><br>
        </form>
    </div>
</body>

</html>