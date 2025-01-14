<?php
session_start();
include("config.php");
include("upload.php");
include("db_operations.php");
include("error_handler.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hsname = $_POST["hsname"];
    $hsdesc = $_POST["hsdesc"];
    $hsprice = $_POST["hsprice"];

    // Handle file upload
    $upload_result = handle_file_upload($_FILES["fileToUpload"]);
    if (!$upload_result['success']) {
        handle_error($upload_result['message']);
    }

    $uploadfileName = $upload_result['file_name'];
    
    // Get DB connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Insert homestay into database
    $status = insert_homestay($conn, $_SESSION["UID"], $hsname, $hsdesc, $hsprice, $uploadfileName);
    if ($status) {
        echo '<div class="error-box">Homestay added successfully!</div>';
        header("refresh:2;URL=managehomestay.php");
    } else {
        handle_error("Error adding homestay.");
    }

    mysqli_close($conn);
}
?>
