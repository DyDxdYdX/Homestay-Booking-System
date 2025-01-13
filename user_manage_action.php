<?php
include_once 'config.php';

if (isset($_GET["id"]) && $_GET["id"] != "" && isset($_GET["action"])) {
    $id = intval($_GET["id"]); // Ensure $id is an integer
    $action = $_GET["action"];

    // Determine the status based on the action
    $status = null; // Default value
    if ($action === "block") {
        $status = "Blocked";
    } elseif ($action === "activate") {
        $status = "Active";
    }


    if ($status) {
        // Update the record in the database
        $sql = "UPDATE user SET user_STATUS = '$status' WHERE userID = $id";
        echo $sql . "<br>";

        if (mysqli_query($conn, $sql)) {
            echo "User is {$status} Successfully<br>";
        } else {
            echo "Error updating user status: " . mysqli_error($conn) . "<br>";
        }
    } else {
        echo "Invalid action provided.<br>";
    }
    echo '<a href="user_manage.php">Back</a>';
} else {
    echo "Invalid request.<br>";
    echo '<a href="user_manage.php">Back</a>';
}

mysqli_close($conn);

