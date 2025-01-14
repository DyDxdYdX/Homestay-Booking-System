<?php
// error_handler.php - Handles displaying error messages and redirects

function handle_error($message, $redirect_url = "managehomestay.php") {
    echo "<div class='error-box'>$message</div>";
    header("refresh:2;URL=$redirect_url");
    exit();
}
?>
