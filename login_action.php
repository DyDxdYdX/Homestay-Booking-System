<?php
session_start();
include("config.php");

$userEmail = $_POST['userEmail']; 
$userPwd = $_POST['userPwd'];

$sql = "SELECT * FROM user WHERE userEmail='$userEmail' LIMIT 1";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_array($result);
    if(password_verify($_POST['userPwd'],$row['userPwd'])) {
        if($row['user_STATUS'] == 'Active'){
            $_SESSION["UID"] = $row["userID"];
            $_SESSION["usertype"] = $row["usertype"];
            $_SESSION['loggedin_time'] = time();

            echo "Welcome, user <b>$userEmail</b>. <br>";
            echo 'Click <a href="index.php">here</a> to go to home page.';
        }else {
            echo 'Login error, user email has been blocked.<br>';//user email blocked   
            echo '<a href="login.php"> | Login |</a> &nbsp;&nbsp;&nbsp; <br>';
        }
        
    }else{
        echo 'Login error, user email and password is incorrect.<br>';//user email & pwd not correct    
        echo '<a href="login.php"> | Login |</a> &nbsp;&nbsp;&nbsp; <br>';
    }
} else {
    echo "Login error, user <b>$userEmail</b> does not exist. <br>";//user not exist
    echo '<a href="login.php"> | Login |</a>&nbsp;&nbsp;&nbsp; <br>';   
}
?>