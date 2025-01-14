<?php
session_start();
include("config.php");
include("upload.php");
include("db_operations.php");
include("error_handler.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hslistID = $_POST["hslistID"];
    $hsname = $_POST["hsname"];
    $hsdesc = $_POST["hsdesc"];
    $hsprice = $_POST["hsprice"];
    $uploadfileName = null;

    // Get DB connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check if a file is uploaded
    if (isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
        // Handle file upload
        $upload_result = handle_file_upload($_FILES["fileToUpload"]);
        if (!$upload_result['success']) {
            handle_error($upload_result['message']);
        }
        $uploadfileName = $upload_result['file_name'];
    }

    // Update the homestay details (with or without a new file)
    $status = update_homestay($conn, $hslistID, $_SESSION["UID"], $hsname, $hsdesc, $hsprice, $uploadfileName);

    if ($status) {
        echo '<div class="error-box">Homestay updated successfully!</div>';
        header("refresh:2;URL=managehomestay.php");
    } else {
        handle_error("Error updating homestay.");
    }

    mysqli_close($conn);
}
?>
