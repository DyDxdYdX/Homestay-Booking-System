<?php
// upload.php - Handles file uploads
function handle_file_upload($file, $target_dir = "uploads/") {
    $uploadOk = 1;
    $uploadfileName = $file["name"];
    $target_file = $target_dir . basename($uploadfileName);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        return ["success" => false, "message" => "ERROR: File already exists."];
    }

    // Check file size (limit to 10MB)
    if ($file["size"] > 10000000) {
        return ["success" => false, "message" => "ERROR: File is too large."];
    }

    // Allow only certain file formats
    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        return ["success" => false, "message" => "ERROR: Only JPG, JPEG, PNG & GIF files are allowed."];
    }

    // Try uploading the file
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return ["success" => true, "file_name" => $uploadfileName];
    } else {
        return ["success" => false, "message" => "ERROR: There was an error uploading your file."];
    }
}
?>
