<?php
session_start();
if(isset($_SESSION["UID"])){
    unset($_SESSION["UID"]);
    unset($_SESSION["userName"]);
    unset($_SESSION["usertype"]);
    echo 'Logout successfully, click';
    echo '<a href="index.php"> here </a> to login again. <br>';
}

?>