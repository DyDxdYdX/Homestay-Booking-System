<?php
include('config.php');

if(isset($_GET["id"]) && $_GET["id"] != ""){
    $id = $_GET["id"];
    
    // Delete the record from the database
    $sql = "UPDATE user SET user_STATUS = 'Active' WHERE userID=" . $id;
    echo $sql . "<br>";
    if (mysqli_query($conn, $sql)) {
        echo "User is Activated Successfully<br>";
        echo '<a href="user_manage.php">Back</a>';
    } else {
        echo "Error Activating User: " . mysqli_error($conn) . "<br>";
        echo '<a href="user_manage.php">Back</a>';
    }
}

mysqli_close($conn);
?>