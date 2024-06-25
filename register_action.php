<?php
include("config.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $usertype = mysqli_real_escape_string($conn, $_POST['usertype']);
    $userEmail = mysqli_real_escape_string($conn, $_POST['userEmail']);
    $userPwd = mysqli_real_escape_string($conn, $_POST['userPwd']);
    $confirmPwd = mysqli_real_escape_string($conn, $_POST['confirmPwd']);
}

if ($userPwd !== $confirmPwd) {
    die("Password and confirm password do not match.");
}

$sql = "SELECT * FROM user WHERE userEmail='$userEmail' LIMIT 1"; 
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    echo "<p ><b>Error: </b> User exist, please register a new user</p>";
    header("refresh:2;URL=login.php");        
} else {
    $pwdHash = trim(password_hash($_POST['userPwd'], PASSWORD_DEFAULT));
    $sql = "INSERT INTO user (usertype, userEmail, userPwd, user_STATUS) VALUES ('$usertype', '$userEmail', '$pwdHash', 'Active')";
    $insertOK=0;

    if (mysqli_query($conn, $sql)) {
        echo "<p>New user record created successfully.</p>";
        header("refresh:2;URL=login.php"); 
        $insertOK=1;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    if($insertOK==1){
        $lastInsertedId = mysqli_insert_id($conn);
        $sql = "INSERT INTO profile (userID, username, phoneNo, address, img_profile) VALUES ('$lastInsertedId','-','-','-','-')";

        if (mysqli_query($conn, $sql)) {
            echo "<p>New user pofile record created successfully. Welcome <b>".$userEmail."</b></p>";
            header("refresh:2;URL=login.php"); 
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>