<!-- Author: MOHD. NAZMI BIN NORMAN BI21110356 -->
<?php
session_start();
include("config.php");
?>
<html>
<head>
<title>Homestay Booking System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<?php

// This action is called when the Delete link is clicked
if(isset($_GET["id"]) && $_GET["id"] != ""){
    $id = $_GET["id"];

    // Fetch the image filename associated with this record
    $fetch_filename_sql = "SELECT imgpath FROM homestaylist WHERE hslistID=" . $id . " AND userID=" . $_SESSION["UID"];

    $result = mysqli_query($conn, $fetch_filename_sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $image_filename = $row['imgpath'];

        // Delete the record from the database
        $sql = "DELETE FROM homestaylist WHERE hslistID=" . $id . " AND userID=" . $_SESSION["UID"];

        if (mysqli_query($conn, $sql)) {
            echo '<div class="error-box">Record deleted successfully<br></div>';
            // Delete the image file if it exists in the uploads folder
            $uploads_folder = 'uploads/';
            $image_path = $uploads_folder . $image_filename;

            if (!empty($image_filename) && file_exists($image_path)) {
                if (unlink($image_path)) {
                    echo "Image file deleted successfully<br>";
                } else {
                    echo "Error deleting image file<br>";
                }
            }

            header("refresh:2;URL=managehomestay.php"); 
        } else {
            echo "Error deleting record: " . mysqli_error($conn) . "<br>";
            header("refresh:2;URL=managehomestay.php"); 
        }
    } else {
        echo "Error fetching image filename: " . mysqli_error($conn) . "<br>";
        header("refresh:2;URL=managehomestay.php"); 
    }

    mysqli_free_result($result);
}

mysqli_close($conn);
?>
</body>
</html>