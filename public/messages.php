<?php
session_start();
include("connection.php");
include("functions.php");
$user_data = check_login($connect);
$id = $user_data['user_id'];
$pfpUrl = "uploads/default.png";
$query = "SELECT * FROM profile_img WHERE userId = '$id' AND status = 1 LIMIT 1;";

$result = mysqli_query($connect, $query);

if ($result) {
    if ($result && mysqli_num_rows($result) > 0) {
        $user_data = mysqli_fetch_assoc($result);
        // If has a profile picture linked
        $pfpUrl = "uploads/profile" . $id . ".png?" . mt_rand();
    }
}



if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $text = $_POST['text'];

    if (!empty($text)) {

        $query = "INSERT INTO messages(user_id, message) VALUES ('$id', '$text')";

        mysqli_query($connect, $query);
        header("Location: messages.php");
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jibby - Messages</title>
</head>
<style>
/* Popup container - can be anything you want */
.popup {
    position: relative;
    display: inline-block;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}

/* The actual popup */
.popup .popuptext {
    visibility: hidden;
    width: 200px;
    background-color: #555;
    color: #fff;
    text-align: center;
    border-radius: 6px;
    padding: 6px;
    position: absolute;
    z-index: 1;
    top: 123px;
    right: 10px;
    height: 100px;
}

.popup .popuptext::after {
    content: "";
    position: absolute;
    bottom: 100%;
    left: 75%;
    border-width: 10px;
    border-style: solid;
    border-color: transparent transparent #555;
}

/* Toggle this class - hide and show the popup */
.popup .show {
    visibility: visible;
    -webkit-animation: fadeIn 0.8s;
    animation: fadeIn 0.8s;
}

/* Add animation (fade in the popup) */
@-webkit-keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }

    to {
        opacity: 1;
    }
}

a.btns {
    display: block;
    width: 100%;
    background: grey;
    margin: 6px 0;
    padding: 3px 0px;
    border-radius: 5%;
    font-size: 24px;
}

.clicked {
    background: pink;
}

.bigger-logo {
    font-size: 48px;
    padding: 12px;
    color: black;
}
</style>

<body>
    <div class="header">
        <h1>
            <a href="index.php">Jibby</a>
            <span class="righty white" style="margin-right: 100px;">Messages</span>
        </h1>
        <div style="<?php echo 'background-image: url(' . $pfpUrl . ');' ?>" class="popup" onclick="popup()"
            id="profile-picture" href="logout.php">
            <span class="popuptext" id="myPopup">
                <a class="btns" href="profile.php">Profile</a>
                <a class="btns" href="logout.php">Logout</a>
            </span>
        </div>
        <div id="outline" href="logout.php"></div>
    </div>
    <div class="row">
        <div class="side">
            <a class="material-icons bigger-logo" href="index.php">home</a>
            <a class="material-icons bigger-logo" href="messages.php">message</a>
            <a class="material-icons bigger-logo" href="delete-messages.php">email</a>
        </div>
        <div id="scroll" class="main" style="overflow-x:hidden;overflow-y:scroll; max-height: 507px;">
            <?php
            $sql = "SELECT * FROM messages";

            $result = mysqli_query($connect, $sql);

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $this_user = $row['user_id'];
                        $query = "SELECT user_name FROM users WHERE user_id = '$this_user'";

                        $user_result = mysqli_query($connect, $query);

                        if ($user_result) {
                            $user_data = mysqli_fetch_assoc($user_result);
                            echo "<section style='background-image:url(uploads/profile" . $this_user . ".png);width: 30px;height: 30px;border-radius: 50%;background-size: cover;'>";
                            echo "<span style='float: left;margin-top: 5px;white-space:nowrap;margin-left:40px;'>" . $user_data['user_name'] . ": " . $row['message'] . "</span></section><br>";
                        }
                    }
                }
            }
            ?>
            <form method="POST">
                <input style="width: 90%;" type="text" name="text" autocomplete="off">
                <input type="submit" name="submit">
            </form>
        </div>
    </div>
    <div class="footer">
        <h2>Footer</h2>
    </div>

</body>
<script defer>
window.onload = scrollToBottom('scroll');

function scrollToBottom(id) {
    var div = document.getElementById(id);
    div.scrollTop = div.scrollHeight - div.clientHeight;
}

function popup() {
    var popup = document.getElementById("myPopup");
    popup.classList.toggle("show");
}

var doubleClick = $("span");
doubleClick.dblclick(function() {
    doubleClick.toggleClass("clicked");
});
</script>

</html>